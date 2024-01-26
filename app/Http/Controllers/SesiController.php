<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    //MENAMPILKAN HALAMAN LOGIN 
    function index()
    {
        return view('home');
    }
    function login(Request $request)
    {
        //daftar fungsi ini di route
        $request->validate(
            [
                //cek isian
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'username wajib diisi!',
                'password.required' => 'password wajib diisi!',
            ]
        );
        $ceklogin = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::attempt($ceklogin)) {
            // echo "sukses";
            // exit();
            $user = Auth::user();
            if ($user->level == 'admin') {
                return redirect('/admin');
            } elseif ($user->level == 'gurubk') {
                return redirect('/guru');
            }
        } else {
            //jika gagal
            return redirect('/')
                ->withErrors('username dan password salah')
                ->withInput();
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return Redirect('/');
    }
}
