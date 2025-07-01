<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <section class="py-10 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Dashboard Admin</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Pendapatan -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Total Pendapatan</h2>
                    <p class="text-xl font-bold text-green-600 dark:text-green-400">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>

                <!-- Pesanan Selesai -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Pesanan Selesai</h2>
                    <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $jumlahSelesai }}</p>
                </div>

                <!-- Pesanan Belum Selesai -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Belum Selesai</h2>
                    <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ $jumlahBelumSelesai }}</p>
                </div>

                <!-- Total Pesanan -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Total Pesanan</h2>
                    <p class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ $jumlahSemua }}</p>
                </div>
            </div>
        </div>
    </section>
</x-layout>