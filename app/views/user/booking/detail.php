<?php

$bookingCode = $_GET['code'] ?? '#AA682358';
$status = $_GET['status'] ?? 'Berlangsung';

$bookingDetail = [
    'code' => $bookingCode,
    'status' => $status,
    'pic' => 'P.J: Nugroho Nur Cahyo',
    'room' => 'Ruang Perancis',
    'location' => 'Tempat: Ruang Perancis, Perpustakaan PNJ, LT. 4',
    'date' => 'Tanggal: 8 - 11 - 2025',
    'time' => 'Jam: 13:00 - 15:00',
    'members' => [
        'Nugroho Nur Cahyo (Mahasiswa)',
        'Naufal Bintang Pradana Himawan (Mahasiswa)',
        'Farrel Maahira Aqraprana Nugraha (Mahasiswa)',
        'Sello Lintang Pambayun (Mahasiswa)',
        'Bambang Warsuta (Dosen)'
    ]
];
?>


<div class="bg-baseColor font-poppins">
    <div class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="javascript:history.back()" class="text-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-medium text-primary">Detail Booking</h1>
        </div>

        <!-- Detail Card -->
        <div class="bg-white rounded-xl shadow-lg p-5 mb-4">
            <!-- Header with Code and Status -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-bold text-primary">Kode Booking: <span class="text-secondary"><?= $bookingDetail['code'] ?></span></h3>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium <?= $bookingDetail['status'] === 'Berlangsung' ? 'bg-secondary/20 text-secondary' : ($bookingDetail['status'] === 'Selesai' ? 'bg-green-100 text-green-600' : 'bg-pink-200 text-red') ?>">
                    <?= $bookingDetail['status'] ?>
                </span>
            </div>

            <!-- Booking Information -->
            <div class="space-y-3 mb-5">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-700"><?= $bookingDetail['pic'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-700">
                        Tempat: <span class="text-secondary font-medium"><?= $bookingDetail['room'] ?></span>, Perpustakaan PNJ, LT. 4
                    </span>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-700"><?= $bookingDetail['date'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-700"><?= $bookingDetail['time'] ?></span>
                </div>
            </div>

            <!-- Members Section -->
            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-base font-semibold text-primary mb-3">Anggota:</h4>
                <ul class="space-y-2">
                    <?php foreach ($bookingDetail['members'] as $index => $member): ?>
                        <li class="flex items-start gap-3">
                            <span class="text-secondary font-medium flex-shrink-0">•</span>
                            <span class="text-sm text-gray-700"><?= $member ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Action Button - Only show Cancel if status is Berlangsung -->
        <?php if ($bookingDetail['status'] === 'Berlangsung'): ?>
            <button onclick="confirmCancel()"
                class="w-full bg-pink-200 text-red border-2 border-pink-300 py-3 rounded-xl font-medium hover:bg-pink-300 transition-colors">
                Cancel
            </button>
        <?php endif; ?>
    </div>

    <script>
        function confirmCancel() {
            if (confirm('Apakah Anda yakin ingin membatalkan booking ini?')) {
                // Redirect to cancel handler
                window.location.href = '/cancel-booking.php?code=<?= urlencode($bookingDetail['code']) ?>';
            }
        }
    </script>
</div>