<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function page_login()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }else{
           return redirect('/dashboard');
        }
    }

    public function auth(Request $request)
    {
        $loginInput = $request->input('username') ?? $request->input('name') ?? $request->input('nip');
        $password = $request->input('password');

        if (!$loginInput || !$password) {
            return redirect()->route('login')->with('gagal', 'Mohon masukkan Nama/Username dan password');
        }

        // Coba login berdasarkan name
        if (Auth::attempt(['name' => $loginInput, 'password' => $password])) {
            return redirect('/dashboard')->with('sukses', 'Selamat, Anda berhasil masuk aplikasi');
        }

        // Coba login berdasarkan email
        if (Auth::attempt(['email' => $loginInput, 'password' => $password])) {
            return redirect('/dashboard')->with('sukses', 'Selamat, Anda berhasil masuk aplikasi');
        }

        // Fallback login berdasarkan NIP
        if (Auth::attempt(['nip' => $loginInput, 'password' => $password])) {
            return redirect('/dashboard')->with('sukses', 'Selamat, Anda berhasil masuk aplikasi');
        }

        return redirect()->route('login')->with('gagal', 'Mohon periksa Nama/Username dan password dengan benar')->withInput();
    }

    public function logout(Request $request = null)
    {
        // Abaikan request jika berasal dari prefetch browser (instant.page hover)
        if (request()->header('Sec-Purpose') === 'prefetch' || request()->header('Purpose') === 'prefetch' || request()->header('X-Purpose') === 'preview' || request()->header('X-Moz') === 'prefetch') {
            return response('', 204);
        }

    	Auth::logout();
    	return redirect()->route('login')->with('sukses', 'Anda telah berhasil keluar dari sistem.');
    }
   
    public function password_baru($id)
    {
        $user = User::find($id);
        // dd($user);
        return view('newpassword',['user'=>$user,'id'=>$id]);
    }
    public function updatepassword(Request $request, $id)
    {
        $this->validate($request,[
            'password' => 'required|min:6',
            'password_konfirm' => 'required_with:password|same:password|min:6'
        ]);
      
        $password = bcrypt($request->password);
        User::where('id', $id)->update(['password' => $password,
        'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        return redirect()->route('petugas')->with('sukses','Selamat, password anda sudah diperbaharui');
    }
}
