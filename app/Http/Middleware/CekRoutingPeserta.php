<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRoutingPeserta
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentPhase = config('game.current_phase');

        if (Auth::check() && Auth::user()->role === 'peserta') {
            $path = $request->path(); // contoh: peserta/kotalama, peserta/ubaya
 if (
                $path === 'peserta' || 
                $path === 'peserta/' || 
                str_starts_with($path, 'peserta/accountdetail')
            ) {
                return $next($request);
            }

            // Validasi berdasarkan fase
            switch ($currentPhase) {
                // Jika nanti aktifkan rally-1
                 case 'rally-1':
                     if (!str_starts_with($path, 'peserta/rally1')) {
                         return redirect()->route('peserta.rally-1.index')->with('error', 'Hanya bisa mengakses Rally 1 saat ini.');
                     }
                     break;

                case 'rally-2':
                    // Cek sesi aktif
                    $active = Session::where('jenis_sesi', 1)->first();

                    // Jika sesi berhenti (id=5) → hanya boleh akses halaman stopped
                    if ($active && (int) $active->id == 5) {
                        if (!$request->is('peserta/rally2/stopped')) {
                            return redirect()
                                ->route('peserta.rally-2.stopped')
                                ->with('error', 'Sesi sedang berhenti.');
                        }
                        break;
                    }

                    // Jika TIDAK berhenti → wajib berada di namespace rally2
                    if (!$request->is('peserta/rally2*')) {
                        return redirect()
                            ->route('peserta.rally-2.index')
                            ->with('error', 'Anda hanya bisa mengakses Ubaya saat ini.');
                    }

                    // Blok akses ke /stopped ketika sesi tidak berhenti
                    if ($request->is('peserta/rally2/stopped')) {
                        return redirect()->route('peserta.rally-2.index');
                    }
                    break;
                default:
                    return abort(403, 'Fase permainan tidak dikenali.');
            }

            return $next($request);
        }

        if (Auth::guest()) {
            return redirect()->route('login');
        }

        return abort(404);
    }
}
