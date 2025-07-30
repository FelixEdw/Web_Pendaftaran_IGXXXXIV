@props(['factories'])

<div class="relative">
    <!-- SVG Container for Arrows -->
    <svg id="connectionArrows" class="absolute inset-0 pointer-events-none z-10" style="width: 100%; height: 100%;">
    </svg>

    <div class="grid grid-cols-4 gap-2" id="factoryGrid">
    @foreach($factories as $index => $factory)
    
        <div class="p-3 aspect-square flex flex-col items-center justify-center relative factory-item {{ $factory['owned'] ? '' : 'locked-initial' }}"
            data-unlocked="{{ $factory['owned'] ? 'true' : 'false' }}" data-index="{{ $index }}"
            onclick="showFactoryInfo({{ $index }}, {{ json_encode($factory) }})">

            <div class="aspect-square w-full relative border-2 transition cursor-pointer rounded-[20px]
                {{ $factory['owned'] ? 'bg-green-100 border-green-400 hover:border-green-600' : 'bg-white border-red-300 hover:border-red-400' }}">

                @if($factory['owned'])
                    <img
                        src="{{ asset('storage/rally-2/mesin' . $factory['jenis'] . '.png') }}"
                        alt="{{ $factory['name'] }}"
                        class="w-full h-full object-cover rounded-[20px]" />

                    <div
                        class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $factory['level'] }}
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center rounded-[20px]">
                        <x-fas-plus class="w-10 h-10 text-red-500" />
                    </div>
                @endif
            </div>

            @if($factory['owned'] && $factory['operator_hired'] == 0)
                <img src="{{ asset('icons/icon_pekerja.svg') }}" alt="icon pekerja"
                    onclick="event.stopPropagation(); showWorkerModal({{ $index }}, {{ json_encode($factory) }})"
                    class="cursor-pointer hover:scale-110 transition-transform">
            @endif
        </div>
    @endforeach
</div>


<!-- Factory Info Modal -->
<div id="factoryInfoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full mx-4 relative transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-left mb-4">
            <h3 id="machineTitle" class="font-bold text-lg text-black mb-2">machine A info :</h3>
            <div id="machineLevel" class="text-sm text-gray-600 mb-1">level 1</div>
            <div id="machineCapacity" class="text-sm text-gray-600 mb-1">Kapasitas: 5</div>
            <div id="machineTime" class="text-sm text-gray-600 mb-3">waktu : 6 menit</div>
        </div>

        <div id="machinePrice" class="text-green-600 font-bold text-2xl mb-4">$3000</div>

        <div id="ownedButtons" class="hidden space-y-3">
            <button onclick="showUpgradeModal()"
                class="w-full bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition">
                UPGRADE
            </button>
            <button id="connectButton" onclick="showConnectModal()"
                class="w-full bg-blue-500 text-white py-3 rounded-lg font-bold hover:bg-blue-600 transition">
                CONNECT
            </button>
            <button onclick="showSellModal()"
                class="w-full bg-red-500 text-white py-3 rounded-lg font-bold hover:bg-red-600 transition">
                SELL
            </button>
        </div>

        <button id="buyButton" onclick="buyMachine()"
            class="w-full bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition">
            BUY
        </button>
    </div>
</div>

<!-- Buy Confirmation Modal -->
<div id="buyConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-center">
            <h3 class="text-xl font-bold text-black mb-4">Do you want to buy a machine?</h3>

            <div id="confirmPrice" class="text-green-600 font-bold text-2xl mb-6">$3000</div>

            <div class="flex space-x-3">
                <button onclick="hideBuyConfirm()"
                    class="flex-1 bg-gray-400 text-white py-3 rounded-lg font-bold hover:bg-gray-500 transition">
                    CANCEL
                </button>
                <button onclick="confirmBuy()"
                    class="flex-1 bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition">
                    BUY
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upgrade Modal -->
<div id="upgradeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-center">
            <h3 class="text-xl font-bold text-black mb-2">Do you want to upgrade?</h3>
            <div id="upgradeFromTo" class="text-gray-600 mb-4">level 1 → level 2</div>

            <div class="text-left mb-4 space-y-1">
                <div id="upgradeCapacity" class="text-sm text-gray-600">Kapasitas: 6 unit</div>
                <div id="upgradeTime" class="text-sm text-gray-600">waktu: 4 menit</div>
            </div>

            <div id="upgradePrice" class="text-green-600 font-bold text-2xl mb-6">$4000</div>

            <div class="flex space-x-3">
                <button onclick="hideUpgradeModal()"
                    class="flex-1 bg-gray-400 text-white py-3 rounded-lg font-bold hover:bg-gray-500 transition">
                    CANCEL
                </button>
                <button onclick="confirmUpgrade()"
                    class="flex-1 bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition">
                    UPGRADE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Worker Modal -->
<div id="workerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full mx-4 transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-center">
            <h3 id="workerTitle" class="text-xl font-bold text-black mb-4">Hire worker</h3>
            <div id="workerPrice" class="text-green-600 font-bold text-2xl mb-6">$ 1000</div>

            <div class="flex space-x-3">
                <button id="hireButton" onclick="confirmHire()"
                    class="flex-1 bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition">
                    HIRE
                </button>
                <button id="layoffButton" onclick="showLayoffConfirm()"
                    class="flex-1 bg-red-500 text-white py-3 rounded-lg font-bold hover:bg-red-600 transition">
                    LAYOFF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Layoff Confirmation Modal -->
<div id="layoffConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-center">
            <h3 class="text-xl font-bold text-black mb-4">Do you want to layoff the worker?</h3>

            <div id="layoffCost" class="text-red-600 font-bold text-2xl mb-6">-$500</div>

            <div class="flex space-x-3">
                <button onclick="hideLayoffConfirm()"
                    class="flex-1 bg-gray-400 text-white py-3 rounded-lg font-bold hover:bg-gray-500 transition">
                    CANCEL
                </button>
                <button onclick="confirmLayoff()"
                    class="flex-1 bg-red-500 text-white py-3 rounded-lg font-bold hover:bg-red-600 transition">
                    LAYOFF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Connect Modal -->
<div id="connectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-center">
            <h3 class="text-xl font-bold text-black mb-4">Connect to Factory</h3>
            <p class="text-gray-600 mb-4">Choose factory to connect:</p>

            <div id="factoryList" class="space-y-2 mb-6 max-h-48 overflow-y-auto">
            </div>

            <button onclick="hideConnectModal()"
                class="w-full bg-gray-400 text-white py-3 rounded-lg font-bold hover:bg-gray-500 transition">
                CANCEL
            </button>
        </div>
    </div>
</div>

<!-- SVG Container for Arrows -->
<svg id="connectionArrows" class="absolute inset-0 pointer-events-none z-10" style="width: 100%; height: 100%;">
</svg>
<div id="sellModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 transform scale-90 opacity-0 transition-all duration-200">
        <div class="text-center">
            <h3 class="text-xl font-bold text-black mb-4">Do you want to sell the machine?</h3>

            <div id="sellPrice" class="text-green-600 font-bold text-2xl mb-6">+$2000</div>

            <div class="flex space-x-3">
                <button onclick="hideSellModal()"
                    class="flex-1 bg-gray-400 text-white py-3 rounded-lg font-bold hover:bg-gray-500 transition">
                    CANCEL
                </button>
                <button onclick="confirmSell()"
                    class="flex-1 bg-red-500 text-white py-3 rounded-lg font-bold hover:bg-red-600 transition">
                    SELL
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    
    let selectedFactoryIndex = null;
    let selectedFactory = null;
    let connections = [];

    let factoriesData = @json($factories);
    let selectedWorkerFactoryIndex = null;
    let selectedWorkerFactory = null;


   function showFactoryInfo(index, factory) {
        selectedFactoryIndex = index;
        selectedFactory = factory;

        document.getElementById('machineTitle').textContent = `Machine ${factory.name} Info`;
        document.getElementById('machineLevel').textContent = `Level ${factory.level || 1}`;
        document.getElementById('machineCapacity').textContent = `Kapasitas: ${factory.kapasitas_dasar || 5}`;
        document.getElementById('machineTime').textContent = `Waktu: ${factory.base_time || 6} menit`;
        document.getElementById('machinePrice').textContent = `$${factory.sell_prices[selectedFactory.level] || 3000}`;

        const buyButton = document.getElementById('buyButton');
        const ownedButtons = document.getElementById('ownedButtons');

        const isOwned = factory.owned === true || factory.owned === "true";

        const connectButton = document.getElementById('connectButton');

        if (factory.owned) {
            buyButton.classList.add('hidden');
            ownedButtons.classList.remove('hidden');

            if (factory.jenis == 4 && connectButton) {
                connectButton.classList.add('hidden');
            } 
            // ✅ Tambahkan logika ini untuk disable jika belum sewa pekerja
            else if ((factory.operator_hired === 0 || !factory.operator_hired) && connectButton) {
                connectButton.disabled = true;
                connectButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
            else if (connectButton) {
                connectButton.disabled = false;
                connectButton.classList.remove('hidden', 'opacity-50', 'cursor-not-allowed');
            }

        } else {
            ownedButtons.classList.add('hidden');
            buyButton.classList.remove('hidden');
        }




        showModal('factoryInfoModal');
    }

    function hideFactoryInfo() {
        hideModal('factoryInfoModal', () => {
          //  selectedFactoryIndex = null;
          //  selectedFactory = null;
        });
    }

    function buyMachine() {
        console.log("selectedFactory:", selectedFactory); // 👈 cek apakah datanya ada
        if (!selectedFactory || selectedFactory.owned) return;

        // lanjutkan ke confirm modal
        document.getElementById('confirmPrice').textContent = `$${selectedFactory.price || 3000}`;
        showModal('buyConfirmModal');
    }

    function hideBuyConfirm() {
        hideModal('buyConfirmModal');
    }

   function confirmBuy() {
    console.log("BELII")
        const price = selectedFactory.harga_dasar || 3000;
        const machineId = selectedFactory.machine_id;

        if (window.capital < price) {
            alert("Uang tidak mencukupi untuk membeli mesin ini.");
            hideBuyConfirm();
            return;
        }

        $.ajax({
            url: "{{ route('peserta.rally2.buy') }}",
            type: "POST",
            data: {
                machine_id: machineId,
                _token: window.Laravel.csrfToken
            },
            success: function(data) {
                if (data.error) {
                    alert("Gagal: " + data.error);
                    return;
                }

                window.capital = data.capital;
                updateCapitalDisplay();

                alert(data.message);
                hideBuyConfirm();
                hideFactoryInfo();
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Terjadi kesalahan saat membeli.");
            }
        });
    }


    function showUpgradeModal() {
        const currentLevel = parseInt(selectedFactory.level);
        const nextLevel = currentLevel + 1;
        if (nextLevel > 3) {
            alert("Mesin sudah pada level maksimum.");
            return;
        }

        const upgradePrices = selectedFactory.upgrade_prices || {};
        const capacities = selectedFactory.capacity_per_level || {};
        const times = selectedFactory.time_per_level || {};

        const nextCapacity = capacities[nextLevel] ?? 'Tidak tersedia';
        const nextTime = times[nextLevel] ?? 'Tidak tersedia';
        const nextPrice = upgradePrices[nextLevel] ?? 'Tidak tersedia';

        document.getElementById('upgradeFromTo').textContent = `Level ${currentLevel} → Level ${nextLevel}`;
        document.getElementById('upgradeCapacity').textContent = `Kapasitas: ${nextCapacity} unit`;
        document.getElementById('upgradeTime').textContent = `Waktu: ${nextTime} menit`;
        document.getElementById('upgradePrice').textContent = `$${nextPrice}`;

        hideFactoryInfo();
        showModal('upgradeModal');
    }


    function hideUpgradeModal() {
        hideModal('upgradeModal');
    }

    function confirmUpgrade() {
        const owned = selectedFactory.owned_id;
        const currentLevel = parseInt(selectedFactory.level);
        const nextLevel = currentLevel + 1;

        const upgradePrices = selectedFactory.upgrade_prices || {};
        const capacities = selectedFactory.capacity_per_level || {};
        const times = selectedFactory.time_per_level || {};
        const sells = selectedFactory.sell_prices || {};

        const price = upgradePrices[nextLevel];
        const newCapacity = capacities[nextLevel];
        const newTime = times[nextLevel];
        const sell = sells[nextLevel];

        // Validasi agar tidak mengirim data kosong
        if (price === undefined || newCapacity === undefined || newTime === undefined || sell === undefined) {
            alert("Data upgrade tidak tersedia.");
            hideUpgradeModal();
            return;
        }

        fetch("{{ route('peserta.rally2.upgrade') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.Laravel.csrfToken
            },
            body: JSON.stringify({
                owned: owned,
                next_level: nextLevel,
                price: price,
                new_capacity: newCapacity,
                new_time: newTime,
                sell: sell
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                alert(data.message || "Berhasil diupgrade!");
                window.capital = data.capital;
                location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert("Gagal upgrade mesin.");
        });

        hideUpgradeModal();
    }




    
    function showSellModal() {
        const sellPrices = selectedFactory.sell_prices || {};
        const currentLevel = parseInt(selectedFactory.level) || 1;
        const sellPrice = sellPrices[currentLevel] ?? Math.floor((selectedFactory.harga_dasar || 3000) * 0.7);

        document.getElementById('sellPrice').textContent = `+$${sellPrice}`;

        hideFactoryInfo();
        showModal('sellModal');
    }

    function hideSellModal() {
        hideModal('sellModal');
    }

    function confirmSell() {
        const ownedId = selectedFactory.owned_id;
        const currentLevel = parseInt(selectedFactory.level);
        const sellPrices = selectedFactory.sell_prices || {};
        const defaultSell = Math.floor((selectedFactory.harga_dasar || 3000) * 0.7);
        const sellAmount = sellPrices[currentLevel] ?? defaultSell;

        console.log(ownedId)
        console.log(sellAmount)
        fetch("{{ route('peserta.rally2.sell') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.Laravel.csrfToken
            },
            body: JSON.stringify({
                owned: ownedId,
                price: sellAmount
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                alert(data.message || "Mesin berhasil dijual!");
                window.capital = data.capital;
                location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan saat menjual mesin.");
        });

        hideSellModal();
    }

    function showConnectModal() {
        populateFactoryList();
        hideFactoryInfo();
        showModal('connectModal');
    }

    function hideConnectModal() {
        hideModal('connectModal');
    }

    function populateFactoryList() {
    const factoryList = document.getElementById('factoryList');
    factoryList.innerHTML = '';

    const fromOwnedId = selectedFactory.owned_id;
    const nextJenis = parseInt(selectedFactory.jenis) + 1;

    const connectionFromThisFactory = selectedFactory.connections.find(c => c.from === fromOwnedId);

    // Kalau sudah terkoneksi (sebagai FROM), tampilkan info saja
    if (connectionFromThisFactory) {
        const connectedFactory = factoriesData.find(f => f.owned_id === connectionFromThisFactory.to);

        if (connectedFactory) {
            const factoryItem = document.createElement('div');
            factoryItem.className = `
                w-full p-4 bg-blue-50 border border-blue-300 shadow-md rounded-xl text-left
            `.trim();

            factoryItem.innerHTML = `
                <div class="font-semibold text-blue-800 text-lg">
                    Terhubung ke Factory ${String.fromCharCode(65 + factoriesData.indexOf(connectedFactory))}
                </div>
                <div class="text-sm text-blue-700 mt-1">
                    Jenis ${connectedFactory.jenis}, Level ${connectedFactory.level || 1}
                </div>
            `;
            factoryList.appendChild(factoryItem);
        } else {
            factoryList.innerHTML = '<p class="text-red-500 py-4">Koneksi ditemukan, tapi factory tujuan tidak ditemukan</p>';
        }

        return; // sudah konek, keluar dari fungsi
    }

    // 🔍 Fungsi bantu: cek apakah factory ini sudah jadi FROM
    function isAlreadyUsedAsFrom(ownedId) {
        return factoriesData.some(f =>
            (f.connections || []).some(c => c.from === ownedId)
        );
    }

    function isAlreadyUsedAsTo(ownedId) {
        return factoriesData.some(f =>
            (f.connections || []).some(c => c.to === ownedId)
        );
    }

    // Cari kandidat factory yang bisa dikoneksikan
    let candidateCount = 0;

    factoriesData.forEach((factory, index) => {
        const isValidConnection =
            factory.owned &&
            index !== selectedFactoryIndex &&
            parseInt(factory.jenis) === nextJenis; 

        if (isValidConnection) {
            candidateCount++;

            const factoryItem = document.createElement('button');
            factoryItem.className = `
                w-full p-4 bg-green-50 border border-green-300 shadow-md rounded-xl
                text-left transition hover:bg-green-100 hover:scale-[1.02] hover:shadow-lg cursor-pointer
            `.trim();

            factoryItem.innerHTML = `
                <div class="font-semibold text-green-800 text-lg">
                    Factory ${String.fromCharCode(65 + index)}
                </div>
                <div class="text-sm text-green-700 mt-1">
                    Level ${factory.level || 1}
                </div>
            `;
            factoryItem.onclick = () => connectFactories(selectedFactoryIndex, index);
            factoryList.appendChild(factoryItem);
        }
    });

    if (candidateCount === 0) {
        factoryList.innerHTML = '<p class="text-gray-500 py-4">Tidak ada factory jenis berikutnya yang bisa dikoneksikan</p>';
    }

    // Debug
    console.log("selectedFactory:", selectedFactory);
    console.log("factoriesData:", factoriesData);
}






    function connectFactories(fromIndex, toIndex) {
        const fromFactory = factoriesData[fromIndex];
        const toFactory = factoriesData[toIndex];

        const payload = {
            source_team_machine_id: fromFactory.owned_id,
            target_team_machine_id: toFactory.owned_id,
        };

        console.log("🔧 Payload to send:", payload);

        $.ajax({
            url: "{{ route('peserta.rally2.connect') }}",
            method: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            headers: {
                "X-CSRF-TOKEN": window.Laravel.csrfToken
            },
            success: function(response) {
                alert("✅ Koneksi berhasil disimpan!");
                hideConnectModal();
                location.reload(); // atau update tampilan saja
            },
            error: function(xhr, status, error) {
                console.error("❌ AJAX Error:", error);
                console.log("📄 Response text:", xhr.responseText);
                alert("❌ Gagal menghubungkan factory: " + (xhr.responseJSON?.message || "Unknown error"));
            }
        });
    }



    function drawConnections() {
        const svg = document.getElementById('connectionArrows');
        const grid = document.getElementById('factoryGrid');
        const gridRect = grid.getBoundingClientRect();

        svg.innerHTML = '';

        connections.forEach(connection => {
            const fromElement = grid.children[connection.from];
            const toElement = grid.children[connection.to];

            if (fromElement && toElement) {
                const fromRect = fromElement.getBoundingClientRect();
                const toRect = toElement.getBoundingClientRect();

                const fromX = fromRect.left + fromRect.width / 2 - gridRect.left;
                const fromY = fromRect.top + fromRect.height / 2 - gridRect.top;
                const toX = toRect.left + toRect.width / 2 - gridRect.left;
                const toY = toRect.top + toRect.height / 2 - gridRect.top;

                const arrow = document.createElementNS('http://www.w3.org/2000/svg', 'g');

                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', fromX);
                line.setAttribute('y1', fromY);
                line.setAttribute('x2', toX);
                line.setAttribute('y2', toY);
                line.setAttribute('stroke', '#3B82F6');
                line.setAttribute('stroke-width', '3');
                line.setAttribute('marker-end', 'url(#arrowhead)');

                arrow.appendChild(line);
                svg.appendChild(arrow);
            }
        });

        if (!svg.querySelector('#arrowhead')) {
            const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
            const marker = document.createElementNS('http://www.w3.org/2000/svg', 'marker');
            marker.setAttribute('id', 'arrowhead');
            marker.setAttribute('markerWidth', '10');
            marker.setAttribute('markerHeight', '7');
            marker.setAttribute('refX', '9');
            marker.setAttribute('refY', '3.5');
            marker.setAttribute('orient', 'auto');

            const polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
            polygon.setAttribute('points', '0 0, 10 3.5, 0 7');
            polygon.setAttribute('fill', '#3B82F6');

            marker.appendChild(polygon);
            defs.appendChild(marker);
            svg.appendChild(defs);
        }
    }

    window.addEventListener('resize', drawConnections);

    function showWorkerModal(index, factory) {
        selectedWorkerFactoryIndex = index;
        selectedWorkerFactory = factory;

        if (!factory.owned) {
            alert('Factory must be dibeli terlebih dahulu!');
            return;
        }
        
        
        const workerTitle = document.getElementById('workerTitle');
        const workerPrice = document.getElementById('workerPrice');
        const hireButton = document.getElementById('hireButton');
        const layoffButton = document.getElementById('layoffButton');

        workerTitle.textContent = 'Hire worker';

        workerPrice.textContent = '$ 1000';
        workerPrice.className = 'text-green-600 font-bold text-2xl mb-6';

        const hasWorkers = factory.workers > 0;

        if (hasWorkers) {
            hireButton.classList.remove('hidden');
            layoffButton.classList.remove('hidden');
            hireButton.className = 'flex-1 bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition';
            layoffButton.className = 'flex-1 bg-red-500 text-white py-3 rounded-lg font-bold hover:bg-red-600 transition';
        } else {
            hireButton.classList.remove('hidden');
            layoffButton.classList.add('hidden');
            hireButton.className = 'w-full bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 transition';
        }

        showModal('workerModal');
    }

    function hideWorkerModal() {
        hideModal('workerModal', () => {
            selectedWorkerFactoryIndex = null;
            selectedWorkerFactory = null;
        });
    }

    function confirmHire() {
        const ownedId = selectedWorkerFactory.owned_id;

        if (window.capital < 1000) {
            alert("Uang tidak mencukupi untuk menyewa pekerja.");
            hideWorkerModal();
            return;
        }

        $.ajax({
            url: "{{ route('peserta.rally2.hire') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            data: {
                owned_id: ownedId,
            },
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message || "Pekerja berhasil disewa!");
                    window.capital = data.capital;
                    updateCapitalDisplay();
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("Terjadi kesalahan saat menyewa pekerja.");
            }
        });

        hideWorkerModal();
    }


    function showLayoffConfirm() {
        document.getElementById('layoffCost').textContent = '-$500';

        hideWorkerModal();
        showModal('layoffConfirmModal');
    }

    function hideLayoffConfirm() {
        hideModal('layoffConfirmModal');
    }

    function confirmLayoff() {
        alert('Worker laid off!');
        hideLayoffConfirm();
    }

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.bg-white');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }, 10);
    }

    function hideModal(modalId, callback = null) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.bg-white');

        modalContent.style.transform = 'scale(0.9)';
        modalContent.style.opacity = '0';

        setTimeout(() => {
            modal.classList.add('hidden');
            if (callback) callback();
        }, 200);
    }

    document.getElementById('factoryInfoModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideFactoryInfo();
        }
    });

    document.getElementById('buyConfirmModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideBuyConfirm();
        }
    });

    document.getElementById('upgradeModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideUpgradeModal();
        }
    });

    document.getElementById('layoffConfirmModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideLayoffConfirm();
        }
    });

    document.getElementById('workerModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideWorkerModal();
        }
    });

    document.getElementById('connectModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideConnectModal();
        }
    });

    document.getElementById('sellModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hideSellModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('layoffConfirmModal').classList.contains('hidden')) {
                hideLayoffConfirm();
            } else if (!document.getElementById('workerModal').classList.contains('hidden')) {
                hideWorkerModal();
            } else if (!document.getElementById('connectModal').classList.contains('hidden')) {
                hideConnectModal();
            } else if (!document.getElementById('sellModal').classList.contains('hidden')) {
                hideSellModal();
            } else if (!document.getElementById('upgradeModal').classList.contains('hidden')) {
                hideUpgradeModal();
            } else if (!document.getElementById('buyConfirmModal').classList.contains('hidden')) {
                hideBuyConfirm();
            } else if (!document.getElementById('factoryInfoModal').classList.contains('hidden')) {
                hideFactoryInfo();
            }
        }
    });

    function updateCapitalDisplay() {
        const el = document.querySelector('div.text-right > .text-green-800');
        if (el) {
            el.textContent = '$' + window.capital.toLocaleString();
        }
    }
</script>