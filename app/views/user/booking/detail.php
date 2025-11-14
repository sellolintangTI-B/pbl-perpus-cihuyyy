<?php

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\Badge;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

$bookingCode = $_GET['code'] ?? '#AA682358';
$status = $_GET['status'] ?? 'dibatalkan';
$statusEnum = [
    "berlangsung" => "berlangsung",
    "dibatalkan" => "dibatalkan",
    "selesai" => "selesai"
];

$bookingDetail = [
    'code' => $data['booking']->booking_code,
    'status' => $data['booking']->status,
    'pic' => $data['booking']->pic,
    'room' => $data['booking']->name,
    'floor' => $data['booking']->floor,
    'date' => Carbon::parse($data['booking']->start_time)->translatedFormat('l, d F Y'),
    'time' => Carbon::parse($data['booking']->start_time)->toTimeString() . ' - ' . Carbon::parse($data['booking']->end_time)->toTimeString(),
    'members' => $data['participants']
];

?>


<div class="bg-baseColor font-poppins">
    <div class="max-w-6xl mx-auto p-4">
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
                    <h3 class="text-lg font-bold text-primary">Kode Booking: #<?= $bookingDetail['code'] ?></h3>
                </div>
                <?= Badge::badge(label: $bookingDetail['status'], color: $bookingDetail['status'] === $statusEnum["berlangsung"] ? 'primary' : ($bookingDetail['status'] ===  $statusEnum["selesai"] ? 'secondary' : 'red')) ?>
            </div>

            <!-- Booking Information -->
            <div class="space-y-3 mb-5">
                <div class="flex items-start gap-3">
                    <?= Icon::person('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-black/80"><?= $bookingDetail['pic'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::location('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-gray-700">
                        Tempat: <span class="text-secondary font-medium"><?= $bookingDetail['room'] ?></span>, Perpustakaan PNJ, LT. <?= $bookingDetail['floor'] ?>
                    </span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::calendar_pencil('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-gray-700"><?= $bookingDetail['date'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::clock('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-gray-700"><?= $bookingDetail['time'] ?></span>
                </div>
            </div>

            <!-- Members Section -->
            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-base font-semibold text-primary mb-3">Anggota:</h4>
                <ul class="space-y-2">
                    <?php  foreach ($bookingDetail['members'] as $member): ?>
                        <li class="flex items-start gap-3">
                            <span class="text-secondary font-medium shrink-0">•</span>
                            <span class="text-sm text-gray-700"><?= $member->name ?></span>
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