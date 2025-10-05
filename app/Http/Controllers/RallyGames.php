<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RallyGames extends Controller
{
    public function index()
    {
        //normal
        //rally-1
        //rally-2
        // Cek jika belum login
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        // Cek jika user adalah peserta
        if (Auth::check() && Auth::user()->role === 'peserta') {
            $currentPhase = config('game.current_phase');

            switch ($currentPhase) {
                case 'normal':
                    return redirect()->route('peserta.home')
                        ->with('error', 'Tunggu Lomba Dimulai Ya');

                case 'rally-1':
                    return route('peserta.rally-1.index');

                case 'rally-2':
                    return route('peserta.rally-2.index');

                default:
                    return abort(403, 'Fase permainan tidak dikenali.');
            }
        }

        // Jika bukan peserta
        return abort(403, 'Akses ditolak.');
    }

    public function stopped(){
        return view("peserta.rally-2.stopped");
    }
}
