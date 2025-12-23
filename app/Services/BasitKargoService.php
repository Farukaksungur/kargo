<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BasitKargoService
{
    protected $baseUrl = 'https://basitkargo.com/api';
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = config('services.basitkargo.api_token');
    }

    /**
     * API isteği gönder
     */
    protected function makeRequest($method, $endpoint, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->{strtolower($method)}($this->baseUrl . $endpoint, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'API isteği başarısız',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Basit Kargo API Hatası: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'API bağlantı hatası: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Aktif kargo firmalarını listele
     */
    public function getHandlers()
    {
        return $this->makeRequest('GET', '/handlers');
    }

    /**
     * Desi/Kg ile fiyat sorgula
     */
    public function getFeeByDesiKg($desiKg)
    {
        return $this->makeRequest('GET', '/handlers/fee/desiKg/' . $desiKg);
    }

    /**
     * Paket bilgileri ile fiyat sorgula
     */
    public function getFeeByPackages($packages)
    {
        return $this->makeRequest('POST', '/handlers/fee/packages', $packages);
    }

    /**
     * Sipariş oluştur (kargo kodu üretmeden)
     */
    public function createOrder($orderData)
    {
        return $this->makeRequest('POST', '/v2/order', $orderData);
    }

    /**
     * Sipariş oluştur ve kargo kodu üret
     */
    public function createOrderWithBarcode($orderData, $handlerCode)
    {
        $orderData['handlerCode'] = $handlerCode;
        return $this->makeRequest('POST', '/v2/order/barcode', $orderData);
    }

    /**
     * Sipariş listele/filtrele
     */
    public function listOrders($params = [])
    {
        $queryString = http_build_query($params);
        return $this->makeRequest('GET', '/v2/order?' . $queryString);
    }

    /**
     * ID ile sipariş sorgula
     */
    public function getOrderById($id)
    {
        return $this->makeRequest('GET', '/v2/order/' . $id);
    }

    /**
     * Barkod ile sipariş sorgula
     */
    public function getOrderByBarcode($barcode)
    {
        return $this->makeRequest('GET', '/v2/order/barcode/' . $barcode);
    }

    /**
     * Takip no ile sipariş sorgula
     */
    public function getOrderByTrackingNumber($trackingNumber)
    {
        return $this->makeRequest('GET', '/v2/order/tracking/' . $trackingNumber);
    }

    /**
     * Sipariş iptal et
     */
    public function cancelOrder($id)
    {
        return $this->makeRequest('POST', '/v2/order/' . $id . '/cancel');
    }

    /**
     * İade oluştur
     */
    public function createReturn($returnData)
    {
        return $this->makeRequest('POST', '/v2/order/return', $returnData);
    }

    /**
     * Etiket indir
     */
    public function downloadLabel($id, $format = 'pdf')
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get($this->baseUrl . '/v2/order/' . $id . '/label?format=' . $format);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->body(),
                'content_type' => $response->header('Content-Type'),
            ];
        }

        return [
            'success' => false,
            'error' => 'Etiket indirilemedi',
        ];
    }

    /**
     * Şehirleri listele
     */
    public function getCities()
    {
        return $this->makeRequest('GET', '/location/cities');
    }

    /**
     * İlçeleri listele
     */
    public function getTowns($cityId)
    {
        return $this->makeRequest('GET', '/location/towns/' . $cityId);
    }

    /**
     * Mahalleleri listele
     */
    public function getDistricts($townId)
    {
        return $this->makeRequest('GET', '/location/districts/' . $townId);
    }

    /**
     * Bakiye sorgula
     */
    public function getBalance()
    {
        return $this->makeRequest('GET', '/user/balance');
    }

    /**
     * Kargo durum kodlarını dönüştür
     */
    public function mapStatus($status)
    {
        $statusMap = [
            'NEW' => 'hazirlaniyor',
            'READY_TO_SHIP' => 'hazirlaniyor',
            'SHIPPED' => 'yolda',
            'OUT_FOR_DELIVERY' => 'yolda',
            'COMPLETED' => 'teslim_edildi',
            'NEEDS_SUPPORT' => 'hazirlaniyor',
            'DELAYED' => 'yolda',
            'RETURNING' => 'yolda',
            'RETURNED' => 'teslim_edildi',
            'LOST' => 'hazirlaniyor',
        ];

        return $statusMap[$status] ?? 'hazirlaniyor';
    }
}

