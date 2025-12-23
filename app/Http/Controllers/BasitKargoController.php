<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use App\Services\BasitKargoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasitKargoController extends Controller
{
    protected $basitKargoService;

    public function __construct(BasitKargoService $basitKargoService)
    {
        $this->basitKargoService = $basitKargoService;
    }

    /**
     * Kargo firmalarını listele
     */
    public function getHandlers()
    {
        $result = $this->basitKargoService->getHandlers();
        
        if ($result['success']) {
            return response()->json($result['data']);
        }
        
        return response()->json(['error' => $result['error']], 400);
    }

    /**
     * Fiyat sorgula
     */
    public function getFee(Request $request)
    {
        $desiKg = $request->get('desi_kg');
        $packages = $request->get('packages');

        if ($desiKg) {
            $result = $this->basitKargoService->getFeeByDesiKg($desiKg);
        } elseif ($packages) {
            $result = $this->basitKargoService->getFeeByPackages($packages);
        } else {
            return response()->json(['error' => 'desi_kg veya packages parametresi gerekli'], 400);
        }

        if ($result['success']) {
            return response()->json($result['data']);
        }

        return response()->json(['error' => $result['error']], 400);
    }

    /**
     * Kargo oluştur ve Basit Kargo'ya gönder
     */
    public function createKargo(Request $request, $kargoId)
    {
        $kargo = Kargo::findOrFail($kargoId);
        
        $request->validate([
            'handler_code' => 'required|string',
        ]);

        // Basit Kargo API formatına dönüştür
        $orderData = [
            'content' => [
                'name' => $kargo->urun_bilgisi ?? 'Kargo',
                'code' => $kargo->takip_no,
                'items' => [
                    [
                        'name' => $kargo->urun_bilgisi ?? 'Ürün',
                        'code' => $kargo->takip_no,
                        'quantity' => '1',
                    ]
                ],
                'packages' => [
                    [
                        'height' => 10,
                        'width' => 15,
                        'depth' => 5,
                        'weight' => 1,
                    ]
                ]
            ],
            'client' => [
                'name' => $kargo->alici_ad . ' ' . $kargo->alici_soyad,
                'phone' => $kargo->alici_telefon,
                'city' => $kargo->il,
                'town' => $kargo->ilce,
                'address' => $kargo->adres,
            ],
        ];

        // Kapıda ödeme varsa ekle
        if ($kargo->odeme_tutari > 0) {
            $orderData['collect'] = $kargo->odeme_tutari;
            $orderData['collectOnDeliveryType'] = 'CASH';
        }

        // Sipariş oluştur ve kargo kodu üret
        $result = $this->basitKargoService->createOrderWithBarcode(
            $orderData,
            $request->handler_code
        );

        if ($result['success']) {
            $orderData = $result['data'];
            
            // Kargo kaydını güncelle
            $kargo->update([
                'basitkargo_id' => $orderData['id'],
                'basitkargo_barcode' => $orderData['barcode'] ?? null,
                'basitkargo_handler_code' => $request->handler_code,
                'kargo_kodu' => $orderData['barcode'] ?? null,
                'kargo_firmasi' => $this->getHandlerName($request->handler_code),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kargo başarıyla oluşturuldu',
                'data' => $orderData,
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Kargo oluşturulamadı',
        ], 400);
    }

    /**
     * Kargo durumunu sorgula
     */
    public function getKargoStatus($kargoId)
    {
        $kargo = Kargo::findOrFail($kargoId);

        if (!$kargo->basitkargo_id) {
            return response()->json(['error' => 'Bu kargo Basit Kargo ile oluşturulmamış'], 400);
        }

        $result = $this->basitKargoService->getOrderById($kargo->basitkargo_id);

        if ($result['success']) {
            $orderData = $result['data'];
            
            // Durumu güncelle
            $durum = $this->basitKargoService->mapStatus($orderData['status']);
            $kargo->update([
                'durum' => $durum,
                'basitkargo_tracking_link' => $orderData['shipmentInfo']['handlerShipmentTrackingLink'] ?? null,
            ]);

            // Tarihleri güncelle
            if (isset($orderData['shipmentInfo']['shippedTime'])) {
                $kargo->yola_cikis_tarihi = $orderData['shipmentInfo']['shippedTime'];
            }
            if (isset($orderData['shipmentInfo']['deliveredTime'])) {
                $kargo->teslim_tarihi = $orderData['shipmentInfo']['deliveredTime'];
                $kargo->durum = 'teslim_edildi';
            }

            return response()->json([
                'success' => true,
                'data' => $orderData,
            ]);
        }

        return response()->json(['error' => $result['error']], 400);
    }

    /**
     * Etiket indir
     */
    public function downloadLabel($kargoId)
    {
        $kargo = Kargo::findOrFail($kargoId);

        if (!$kargo->basitkargo_id) {
            return redirect()->back()->with('error', 'Bu kargo Basit Kargo ile oluşturulmamış');
        }

        $result = $this->basitKargoService->downloadLabel($kargo->basitkargo_id);

        if ($result['success']) {
            return response($result['data'])
                ->header('Content-Type', $result['content_type'])
                ->header('Content-Disposition', 'attachment; filename="etiket-' . $kargo->takip_no . '.pdf"');
        }

        return redirect()->back()->with('error', 'Etiket indirilemedi');
    }

    /**
     * Toplu durum güncelleme
     */
    public function syncStatuses()
    {
        $kargolar = Kargo::whereNotNull('basitkargo_id')
            ->where('durum', '!=', 'teslim_edildi')
            ->get();

        $updated = 0;
        $errors = [];

        foreach ($kargolar as $kargo) {
            $result = $this->basitKargoService->getOrderById($kargo->basitkargo_id);
            
            if ($result['success']) {
                $orderData = $result['data'];
                $durum = $this->basitKargoService->mapStatus($orderData['status']);
                
                $kargo->update([
                    'durum' => $durum,
                    'basitkargo_tracking_link' => $orderData['shipmentInfo']['handlerShipmentTrackingLink'] ?? null,
                ]);

                if (isset($orderData['shipmentInfo']['shippedTime'])) {
                    $kargo->yola_cikis_tarihi = $orderData['shipmentInfo']['shippedTime'];
                }
                if (isset($orderData['shipmentInfo']['deliveredTime'])) {
                    $kargo->teslim_tarihi = $orderData['shipmentInfo']['deliveredTime'];
                    $kargo->durum = 'teslim_edildi';
                }

                $updated++;
            } else {
                $errors[] = $kargo->takip_no . ': ' . ($result['error'] ?? 'Bilinmeyen hata');
            }
        }

        return response()->json([
            'success' => true,
            'updated' => $updated,
            'total' => $kargolar->count(),
            'errors' => $errors,
        ]);
    }

    /**
     * Webhook handler
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        // Webhook'tan gelen veriyi işle
        if (isset($data['id'])) {
            $kargo = Kargo::where('basitkargo_id', $data['id'])->first();

            if ($kargo) {
                $durum = $this->basitKargoService->mapStatus($data['status']);
                
                $kargo->update([
                    'durum' => $durum,
                    'basitkargo_tracking_link' => $data['shipmentInfo']['handlerShipmentTrackingLink'] ?? null,
                ]);

                if (isset($data['shipmentInfo']['shippedTime'])) {
                    $kargo->yola_cikis_tarihi = $data['shipmentInfo']['shippedTime'];
                }
                if (isset($data['shipmentInfo']['deliveredTime'])) {
                    $kargo->teslim_tarihi = $data['shipmentInfo']['deliveredTime'];
                    $kargo->durum = 'teslim_edildi';
                }
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handler kodundan isim al
     */
    private function getHandlerName($code)
    {
        $handlers = [
            'PTT' => 'PTT Kargo',
            'MNG' => 'MNG Kargo',
            'YURTICI' => 'Yurtiçi Kargo',
            'ARAS' => 'Aras Kargo',
            'SURAT' => 'Sürat Kargo',
        ];

        return $handlers[$code] ?? $code;
    }
}

