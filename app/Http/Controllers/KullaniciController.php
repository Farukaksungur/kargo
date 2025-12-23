<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\IslemLogu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KullaniciController extends Controller
{
    public function index()
    {
        $kullanicilar = User::with('rol')->get();
        
        return view('kullanicilar.index', compact('kullanicilar'));
    }

    public function create()
    {
        $roller = Rol::where('aktif', true)->get();
        
        return view('kullanicilar.create', compact('roller'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'rol_id' => 'required|exists:rols,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);
        
        return redirect()->route('kullanicilar.index')
            ->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $kullanici = User::findOrFail($id);
        $roller = Rol::where('aktif', true)->get();
        
        return view('kullanicilar.edit', compact('kullanici', 'roller'));
    }

    public function update(Request $request, $id)
    {
        $kullanici = User::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $kullanici->update($data);
        
        return redirect()->route('kullanicilar.index')
            ->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    public function sifreDegistir()
    {
        return view('kullanicilar.sifre-degistir');
    }

    public function sifreGuncelle(Request $request)
    {
        $request->validate([
            'mevcut_sifre' => 'required',
            'yeni_sifre' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->mevcut_sifre, $user->password)) {
            return back()->withErrors(['mevcut_sifre' => 'Mevcut şifre yanlış.']);
        }

        $user->update([
            'password' => Hash::make($request->yeni_sifre),
        ]);

        return redirect()->route('kullanicilar.index')
            ->with('success', 'Şifreniz başarıyla değiştirildi.');
    }

    public function loglar()
    {
        $loglar = IslemLogu::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('kullanicilar.loglar', compact('loglar'));
    }
}
