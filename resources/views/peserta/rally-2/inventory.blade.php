@extends('layouts.rally-2')

@section('title', 'INVENTORY - Rally 2')

@section('content')
    {{-- Header --}}
    <div class="flex justify-between items-center p-4 bg-[#ECE6E2]">
        <a href="{{ route('peserta.rally-2.index') }}" class="text-[#6B4D28] text-2xl">
            <x-ri-arrow-left-s-line class="w-10 h-10 text-[#6B4D28]" />
        </a>
        <div class="text-xl font-bold text-[#6B4D28]">INVENTORY</div>
        <button onclick="toggleSideMenu()">
            <x-radix-text-align-justify class="w-10 h-10 text-[#6B4D28]" />
        </button>
    </div>

    {{-- Main Card --}}
    <div class="flex items-center justify-start px-6 py-8 min-h-[calc(100vh-64px)] bg-cover bg-center"
        style="background-image: url('{{ asset('icons/motif_gear.svg') }}');">
        <div
            class="bg-gradient-to-br from-gray-400 via-gray-500 to-gray-700 rounded-2xl p-8 w-full max-w-sm shadow-lg border-2 border-gray-700">
            {{-- Image --}}
            <div class="flex justify-center mb-4">
                <img src="{{ asset('icons/contoh_sepeda.svg') }}" alt="Bicycle Item" class="h-24">
            </div>

            {{-- Inventory Amount --}}
            <div class="text-center mb-4">
                <span class="text-lg font-bold text-white">AMOUNT: {{ $inventory }}</span>
            </div>

            {{-- Quantity Selector --}}
            <div class="flex items-center justify-center gap-6 mb-6">
                <button onclick="changeQuantity(-1)"
                    class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-2xl font-bold text-black hover:bg-gray-300 transition">
                    −
                </button>

                <span id="quantityDisplay" class="text-4xl font-bold text-white min-w-[60px] text-center">1</span>

                <button onclick="changeQuantity(1)"
                    class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-2xl font-bold text-black hover:bg-gray-300 transition">
                    +
                </button>
            </div>

            {{-- Price --}}
            <div class="text-center mb-6">
                <span id="totalPriceDisplay" class="text-2xl font-bold text-green-400">$110</span>
            </div>

            {{-- Sell Button --}}
            <button onclick="sellItem()"
                class="w-full bg-green-500 text-white py-4 rounded-xl text-lg font-bold hover:bg-green-600 transition shadow-lg">
                SELL
            </button>
        </div>
    </div>

    {{-- Sidebar --}}
    <x-rally-2-sidebar />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Script --}}
    <script>
        let quantity = 1;
        let maxQuantity = {{ $inventory }};
        const pricePerItem = 110;

        function changeQuantity(change) {
            const newQuantity = quantity + change;
            if (newQuantity >= 1 && newQuantity <= maxQuantity) {
                quantity = newQuantity;
                updateDisplay();
            }
        }

        function updateDisplay() {
            $('#quantityDisplay').text(quantity);
            $('#totalPriceDisplay').text('$' + (quantity * pricePerItem));
        }

        function sellItem() {
            // Disable button to prevent double clicks
            const sellButton = $('button:contains("SELL")');
            const originalText = sellButton.text();
            sellButton.prop('disabled', true).text('PROCESSING...');

            const total = quantity * pricePerItem;

            console.log('Sending data:', {
                quantity: quantity,
                total_price: total,
                maxQuantity: maxQuantity
            });

            $.ajax({
                url: '{{ route("peserta.rally-2.sellsepeda") }}',
                method: 'POST',
                data: {
                    quantity: quantity,
                    total_price: total,
                    _token: '{{ csrf_token() }}'
                },
                timeout: 30000, // 30 seconds timeout
                success: function (response) {
                    console.log('Full Response:', response);

                    // Re-enable button
                    sellButton.prop('disabled', false).text(originalText);

                    if (response.success) {
                        alert(response.message);

                        // Reset quantity
                        quantity = 1;
                        updateDisplay();

                        // Update inventory display
                        if (response.inventory !== undefined) {
                            // Method 1: Direct update
                            $('span.text-lg.font-bold.text-black').each(function () {
                                if ($(this).text().includes('AMOUNT:')) {
                                    $(this).text("AMOUNT: " + response.inventory);
                                }
                            });

                            // Update maxQuantity
                            maxQuantity = response.inventory;

                            console.log('Updated inventory to:', response.inventory);
                            console.log('Updated money to:', response.uang);
                        }

                        // Show debug info if available
                        if (response.debug) {
                            console.log('Debug info:', response.debug);
                        }

                    } else {
                        alert('Response success is false: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function (xhr, status, error) {
                    console.log('AJAX Error Details:', {
                        xhr: xhr,
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        responseJSON: xhr.responseJSON
                    });

                    // Re-enable button
                    sellButton.prop('disabled', false).text(originalText);

                    let errorMessage = 'Terjadi kesalahan.';

                    if (status === 'timeout') {
                        errorMessage = 'Request timeout. Coba lagi.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            const errorData = JSON.parse(xhr.responseText);
                            errorMessage = errorData.message || errorMessage;
                        } catch (e) {
                            errorMessage = 'Server error: ' + xhr.status;
                        }
                    }

                    alert("ERROR: " + errorMessage);
                }
            });
        }

        // Initialize when document is ready
        $(document).ready(function () {
            console.log('Page loaded. Initial values:', {
                quantity: quantity,
                maxQuantity: maxQuantity,
                pricePerItem: pricePerItem
            });

            updateDisplay();

            // Add some validation
            if (maxQuantity <= 0) {
                alert('Tidak ada inventory yang tersedia!');
                $('button:contains("SELL")').prop('disabled', true);
            }
        });
    </script>
@endsection