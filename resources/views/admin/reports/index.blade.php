<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan & Analitik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kartu Statistik Umum -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-600">Total Tiket</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['totalTickets'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-600">Tiket Open</h3>
                    <p class="text-3xl font-bold mt-2 text-green-600">{{ $stats['openTickets'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-600">Tiket Closed</h3>
                    <p class="text-3xl font-bold mt-2 text-gray-500">{{ $stats['closedTickets'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-600">Total Pengguna</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['totalUsers'] }}</p>
                </div>
            </div>

            <!-- Grafik -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Distribusi Tiket per Kategori</h3>
                    <div style="height: 400px;">
                        <canvas id="ticketsByCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ticketsByCategoryChart');
        new Chart(ctx, {
            type: 'pie', // Tipe grafik: pie (lingkaran)
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: '# of Tickets',
                    data: @json($categoryData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Tiket Berdasarkan Kategori'
                    }
                }
            }
        });
    </script>
</x-app-layout>