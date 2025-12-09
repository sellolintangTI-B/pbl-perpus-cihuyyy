<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Badge;
use App\Components\Icon\Icon;
use Carbon\Carbon;
use App\Components\CustomSelect;

$no = 1;

$feedback = $data['feedback'];
$room = $data['room'];

$Ruangan = ['' => 'Semua'];
foreach ($room as $r) {
    $Ruangan[$r->id] = $r->name;
}

$tahun = ['' => 'Semua'];
foreach ($data['years'] as $key => $value) {
    $tahun[$value->year] = $value->year;
}

$bulan = [
    '' => 'Semua',
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

?>

<div class="w-full h-full">
    <div class="w-full h-full flex flex-col items-start justify-start gap-5">
        <div class="w-full flex items-center justify-start">
            <h1 class="text-2xl font-medium text-primary">
                Data Feedback
            </h1>
        </div>

        <!-- Action Section -->
        <div class="w-full h-10 flex items-center justify-between">
            <div class="flex items-center justify-start gap-2 h-full">
                <?php
                $exportParams = [];
                if (isset($_GET['ruangan']) && $_GET['ruangan'] !== '') {
                    $exportParams[] = 'ruangan=' . urlencode($_GET['ruangan']);
                }
                if (isset($_GET['bulan']) && $_GET['bulan'] !== '') {
                    $exportParams[] = 'bulan=' . urlencode($_GET['bulan']);
                }
                if (isset($_GET['tahun']) && $_GET['tahun'] !== '') {
                    $exportParams[] = 'tahun=' . urlencode($_GET['tahun']);
                }
                $exportUrl = '/admin/feedback/export' . (!empty($exportParams) ? '?' . implode('&', $exportParams) : '');
                ?>
                <?= Button::anchor(
                    label: 'Export',
                    icon: 'export',
                    color: 'primary',
                    class: 'px-3 py-2',
                    btn_icon_size: 'w-4 h-4',
                    href: $exportUrl
                ) ?>
            </div>

            <div class="flex items-start justify-end gap-2 h-full w-full">
                <form class="flex items-start justify-center gap-2 h-full" method="GET">
                    <?= CustomSelect::render(
                        name: 'ruangan',
                        defaultLabel: 'Ruangan',
                        options: $Ruangan,
                        selectedValue: $_GET['ruangan'] ?? ''
                    ) ?>

                    <?php if (isset($_GET['tahun']) && $_GET['tahun'] !== ''): ?>
                        <?= CustomSelect::render(
                            name: 'bulan',
                            defaultLabel: 'Bulan',
                            options: $bulan,
                            selectedValue: $_GET['bulan'] ?? ''
                        ) ?>
                    <?php endif; ?>

                    <?= CustomSelect::render(
                        name: 'tahun',
                        defaultLabel: 'Tahun',
                        options: $tahun,
                        selectedValue: $_GET['tahun'] ?? ''
                    ) ?>

                    <?php Button::anchor(
                        icon: 'arrow_cycle',
                        color: 'primary',
                        href: '/admin/feedback/index',
                        class: 'h-full! py-2! px-4! shadow-none!'
                    ) ?>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full h-full overflow-y-auto p-2">
            <?php if (empty($feedback)): ?>
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <p class="text-lg font-medium">Tidak ada data feedback</p>
                        <p class="text-sm mt-2">Belum ada feedback yang tersedia untuk filter ini</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php foreach ($feedback as $d): ?>
                        <div class="w-full p-6 rounded-lg bg-baseColor shadow-md shadow-gray-200 flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <h1 class="text-xl font-medium text-primary flex gap-2">
                                    Kode Booking:
                                    <span class="text-secondary">
                                        #<?= htmlspecialchars($d->booking_code ?? '-') ?>
                                    </span>
                                </h1>
                                <div class="flex gap-2 items-center">
                                    <?= Icon::star('w-5 h-5 text-primary') ?>
                                    <h1 class="text-black/80 text-xl font-medium">
                                        <?= htmlspecialchars($d->rating) ?>
                                    </h1>
                                </div>
                            </div>

                            <div class="w-full h-px bg-black/40"></div>

                            <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                                <?= Icon::location("w-5 h-5") ?>
                                <p class="font-medium text-sm">
                                    Tempat: <?= htmlspecialchars($d->room_name) ?>, Perpustakaan PNJ, LT. <?= htmlspecialchars($d->floor) ?>
                                </p>
                            </div>

                            <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                                <?= Icon::person("w-5 h-5") ?>
                                <p class="font-medium text-sm">
                                    Nama: <?= htmlspecialchars($d->name) ?>
                                </p>
                            </div>

                            <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                                <?= Icon::calendar_pencil("w-5 h-5") ?>
                                <p class="font-medium text-sm">
                                    Tanggal Booking: <?= htmlspecialchars(Carbon::parse($d->start_time)->translatedFormat('l, d M Y')) ?>
                                </p>
                            </div>

                            <div class="flex flex-col gap-2 items-start justify-center text-black/80">
                                <div class="flex gap-2 items-start mt-2">
                                    <div>
                                        <?= Icon::file("w-5 h-5") ?>
                                    </div>
                                    <p class="font-medium text-sm">
                                        Deskripsi:
                                    </p>
                                </div>
                                <div x-data="{ isExpanded: false }" class="w-full">
                                    <p
                                        class="text-sm text-black/80 cursor-pointer transition-all duration-300 max-w-full break-words overflow-hidden text-ellipsis"
                                        :class="isExpanded ? 'line-clamp-none' : 'line-clamp-4'"
                                        @click="isExpanded = !isExpanded">
                                        <?= htmlspecialchars($d->feedback) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>