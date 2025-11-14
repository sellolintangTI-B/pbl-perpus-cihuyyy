<?php

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\Badge;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

$bookingCode = $_GET['code'] ?? '#AA682358';
$status = $_GET['status'] ?? 'berlangsung';
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
        <div class="bg-white rounded-xl shadow-lg p-4 mb-4 border border-gray-400 flex flex-col items-start justify-start gap-4">
            <!-- Header with Code and Status -->
            <div class="flex justify-between items-start w-full">
                <div>
                    <h3 class="text-lg font-bold text-primary">Kode Booking: #<?= $bookingDetail['code'] ?></h3>
                </div>
                <?= Badge::badge(label: $bookingDetail['status'], color: $bookingDetail['status'] === $statusEnum["berlangsung"] ? 'tertiary' : ($bookingDetail['status'] ===  $statusEnum["selesai"] ? 'secondary' : 'red')) ?>
            </div>

            <!-- Booking Information -->
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <?= Icon::person('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-black/80">Nama: <?= $bookingDetail['pic'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::location('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-gray-700">
                        Tempat: <span class="text-secondary font-medium"><?= $bookingDetail['room'] ?></span>, Perpustakaan PNJ, LT. <?= $bookingDetail['floor'] ?>
                    </span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::calendar_pencil('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-gray-700">Location: <?= $bookingDetail['date'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::clock('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-gray-700">Tempat: <?= $bookingDetail['time'] ?></span>
                </div>
                <?php if ($bookingDetail['status'] === $statusEnum['selesai']): ?>
                    <div class="flex items-start gap-3">
                        <?= Icon::clock('w-5 h-5 text-black/80') ?>
                        <span class="text-sm text-gray-700">Check in: 13.05 &bull; Check out: 15.05</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Members Section -->
            <div class=" pt-4">
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

            <?php if ($bookingDetail['status'] === $statusEnum['berlangsung']): ?>
                <div class="flex flex-col gap-2 pt-4">
                    <h4 class="text-base font-semibold text-primary">Detail Pembatalan:</h4>
                    <div class="w-full flex flex-col gap-4">
                        <div class="flex items-start gap-3">
                            <?= Icon::person('w-5 h-5 text-black/80') ?>
                            <span class="text-sm text-gray-700">dibatalkan oleh: nugiman</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <?= Icon::clock('w-5 h-5 text-black/80') ?>
                            <span class="text-sm text-gray-700">Jam: 15.05</span>
                        </div>
                    </div>
                    <p>
                        Alasan:
                    </p>
                    <p class="text-sm">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab accusamus doloribus sunt. Labore exercitationem fugit eos assumenda repudiandae voluptas similique!
                    </p>
                </div>
            <?php endif; ?>


            <?php if ($bookingDetail['status'] === $statusEnum['berlangsung']): ?>
                <?= Button::button(label: 'Cancel', type: 'submit', color: 'red', class: 'w-full py-2 rounded-full!') ?>
            <?php endif; ?>
        </div>

    </div>
</div>