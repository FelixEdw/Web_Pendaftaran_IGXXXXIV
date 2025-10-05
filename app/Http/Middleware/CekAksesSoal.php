<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekAksesSoal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        if (!session()->has("akses_soal_$id")) {
            abort(403, 'Akses soal hanya bisa dilakukan melalui QR Scan.');
        }

         // Cek apakah sudah pernah diakses dan selesaikan
        if (session()->get("soal_selesai_$id")) {
            return redirect()->route('peserta.rally-2.scanner')
                ->with('error', 'Soal ini sudah diselesaikan sebelumnya.');
        }

        return $next($request);
    }
}
