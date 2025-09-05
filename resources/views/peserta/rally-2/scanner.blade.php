@extends('layouts.rally-2')

@section('title', 'QR Scanner - Rally 2')

@section('content')
    <div class="flex justify-between items-center p-4 bg-[#ECE6E2]">
        <a href="{{ route('peserta.rally-2.index') }}" class="text-[#6B4D28] text-2xl">
            <x-ri-arrow-left-s-line class="w-10 h-10 text-[#6B4D28]" />
        </a>
        <div class="text-xl font-bold text-[#6B4D28]">QR SCANNER</div>
        <button onclick="toggleSideMenu()">
            <x-radix-text-align-justify class="w-10 h-10 text-[#6B4D28]" />
        </button>
    </div>

    {{-- Pesan Error --}}
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded m-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center justify-center p-4 text-center min-h-[calc(100vh-64px)] bg-cover bg-center"
        style="background-image: url('{{ asset('icons/motif_gear.svg') }}');">
        <div id="qr-reader-container" class="relative overflow-hidden mx-auto"
            style="width:100%; max-width:400px; height: 350px;">
            <div id="qr-reader" class="w-full h-full flex items-center justify-center">
                <script src="https://unpkg.com/html5-qrcode"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        function startScanner(cameraConfig) {
                            const qrReader = new Html5Qrcode("qr-reader");
                            qrReader.start(
                                cameraConfig,
                                {
                                    fps: 10,
                                    qrbox: { width: 400, height: 350 },
                                },
                                qrCodeMessage => {
                                    qrReader.stop().then(() => {
                                        console.log("QR Code Detected:", qrCodeMessage);

                                        if (/^M-\d+$/.test(qrCodeMessage)) {
                                            // QR untuk Mystery Envelope
                                            const id_envelope = qrCodeMessage.split('-')[1];
                                            window.location.href = `/mystery-envelope/${id_envelope}`;
                                        } else if (/^\d+$/.test(qrCodeMessage)) {
                                            const id_soal = qrCodeMessage;
                                            window.location.href = `${id_soal}`;
                                        } else {
                                            document.getElementById("qr-reader-results").innerText = "QR tidak valid!";
                                        }
                                    }).catch(err => {
                                        console.error("Gagal stop kamera:", err);
                                    });
                                },
                                errorMessage => {
                                }
                            );
                        }

                        Html5Qrcode.getCameras().then(cameras => {
                            if (cameras && cameras.length) {
                                const backCamera = cameras.find(cam =>
                                    cam.label.toLowerCase().includes("back") ||
                                    cam.label.toLowerCase().includes("rear") ||
                                    cam.label.toLowerCase().includes("environment")
                                );
                                if (backCamera) {
                                    startScanner({ deviceId: { exact: backCamera.id } });
                                } else {
                                    startScanner({ deviceId: { exact: cameras[0].id } });
                                }
                            } else {
                                document.getElementById("qr-reader-results").innerText = "Tidak ditemukan kamera!";
                            }
                        }).catch(() => {
                            document.getElementById("qr-reader-results").innerText = "Gagal mengakses kamera!";
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <x-rally-2-sidebar />
@endsection