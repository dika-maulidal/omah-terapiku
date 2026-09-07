<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('upt')) {
            $upt = $request->get('upt');
            if ($upt === 'all' || empty($upt)) {
                session()->forget('selected_upt');
            } else {
                session(['selected_upt' => $upt]);
            }
        }

        if(auth()->user()->role_display()=="Admin"){
            return view('dashboard.admin');
        }else if(auth()->user()->role_display()=="Pendaftaran"){
            return view('dashboard.registrasi');
        }else if(auth()->user()->role_display()=="Dokter"){
            return view('dashboard.dokter');
        }
    }
}
