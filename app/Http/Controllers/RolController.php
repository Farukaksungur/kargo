<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Yetki;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roller = Rol::with('yetkiler')->get();
        $yetkiler = Yetki::where('aktif', true)->get();
        
        return view('roller.index', compact('roller', 'yetkiler'));
    }

    public function store(Request $request)
    {
        $rol = Rol::create($request->only(['ad', 'aciklama']));
        
        if ($request->has('yetkiler')) {
            $rol->yetkiler()->attach($request->yetkiler);
        }
        
        return redirect()->route('roller.index')
            ->with('success', 'Rol başarıyla oluşturuldu.');
    }
}
