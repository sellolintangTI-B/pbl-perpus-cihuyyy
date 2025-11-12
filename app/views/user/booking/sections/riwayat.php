<?php
// Sample data - replace with database query
$historyBookings = [
    [
        'code' => '#AA682358',
        'status' => 'Selesai',
        'room' => 'Ruang Perancis',
        'location' => 'Tempat: Ruang Perancis, Perpustakaan PNJ, LT. 4',
        'date' => 'Tanggal: 8 - 11 - 2025',
        'time' => 'Jam: 13:00 - 15:00'
    ],
    [
        'code' => '#AA682358',
        'status' => 'Dibatalkan',
        'room' => 'Ruang Perancis',
        'location' => 'Tempat: Ruang Perancis, Perpustakaan PNJ, LT. 4',
        'date' => 'Tanggal: 8 - 11 - 2025',
        'time' => 'Jam: 13:00 - 15:00'
    ]
];
?>

<div class="w-full">
    <!-- Filter Badges -->
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        <button @click="activeFilter = 'semua'"
            :class="activeFilter === 'semua' ? 'bg-primary text-white' : 'bg-white text-primary border border-primary'"
            class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap hover:shadow-md transition-all duration-300">
            Semua
        </button>
        <button @click="activeFilter = 'selesai'"
            :class="activeFilter === 'selesai' ? 'bg-secondary text-white' : 'bg-white text-secondary border border-secondary'"
            class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap hover:shadow-md transition-all duration-300">
            Selesai
        </button>
        <button @click="activeFilter = 'dibatalkan'"
            :class="activeFilter === 'dibatalkan' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500 border border-pink-500'"
            class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap hover:shadow-md transition-all duration-300">
            Dibatalkan
        </button>
    </div>

    <!-- Booking History List -->
    <div class="space-y-4">
        <?php foreach ($historyBookings as $booking): ?>
            <div class="bg-white rounded-xl shadow-md p-4"
                x-show="activeFilter === 'semua' || activeFilter === '<?= strtolower($booking['status']) ?>'"
                x-transition>
                <!-- Header with Code and Status -->
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-base font-bold text-primary mb-1">Kode Booking: <?= $booking['code'] ?></h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium <?= $booking['status'] === 'Selesai' ? 'bg-secondary/20 text-secondary' : 'bg-pink-200 text-red' ?>">
                        <?= $booking['status'] ?>
                    </span>
                </div>

                <!-- Booking Details -->
                <div class="space-y-2 text-sm text-gray-700 mb-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span><?= $booking['location'] ?></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span><?= $booking['date'] ?></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        <span><?= $booking['time'] ?></span>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="/detail-booking.php?code=<?= urlencode($booking['code']) ?>&status=<?= urlencode($booking['status']) ?>"
                    class="block w-full bg-linear-to-r from-primary to-secondary text-white text-center py-3 rounded-xl font-medium hover:shadow-lg transition-all duration-300">
                    See Details →
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State (when filtered) -->
    <div x-show="activeFilter !== 'semua' && document.querySelectorAll('[x-show]:not([style= display: none])').length===0" class="text-center py-12">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p class="text-gray-500">Tidak ada booking dengan status ini</p>
    </div>
</div>