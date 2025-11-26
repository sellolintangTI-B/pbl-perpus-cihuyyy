<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Badge;
use App\Components\Icon\Icon;
use Carbon\Carbon;
use App\Components\Modal;

$no = 1;
?>

<div class="w-full h-full">
    <div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
        <div class="w-full flex items-center justify-start">
            <h1 class="text-2xl font-medium text-primary">
                Data Feedback
            </h1>
        </div>
        <!-- action section -->
        <div class="w-full h-10 flex items-center justify-between">
            <div class="flex items-center justify-end gap-2 h-full w-full max-w-[24rem]">

            </div>
            <div class="flex items-center justify-end gap-2 h-full w-full max-w-[24rem]">

            </div>
        </div>

        <!-- main content -->
        <div class="w-full h-full overflow-y-auto p-2">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- mulai di fetch disini feedbacknnyaaaaa -->
                <?php foreach ($data['feedback'] as $d): ?>
                    <div class="w-full p-6 rounded-lg bg-baseColor shadow-md shadow-gray-200 flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <h1 class="text-xl font-medium text-primary flex gap-2">
                                Kode Booking:
                                <span class="text-secondary">
                                    #<?= $d->booking_code ?? '-' ?>
                                </span>
                            </h1>
                            <div class="flex gap-2 items-center">
                                <?= Icon::star('w-5 h-5 text-primary') ?>
                                <h1 class="text-black/80 text-xl font-medium">
                                    <?= $d->rating ?>
                                </h1>
                            </div>
                        </div>
                        <div class="w-full h-px bg-black/40"></div>
                        <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                            <?= Icon::location("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Tempat: <?= $d->room_name ?>, Perpustakaan PNJ, LT. <?= $d->floor ?>
                            </p>
                        </div>
                        <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                            <?= Icon::person("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Nama: <?= $d->name ?>
                            </p>
                        </div>
                        <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                            <?= Icon::calendar_pencil("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Tanggal Booking: <?= Carbon::parse("$d->start_time")->translatedFormat('l, d M Y') ?>
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 items-start justify-center text-black/80 ">
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
                                    class="text-sm text-black/80 cursor-pointer transition-all duration-300 max-w-full break-all overflow-hidden text-ellipsis "
                                    :class="isExpanded ? 'line-clamp-none' : 'line-clamp-4'"
                                    @click="isExpanded = !isExpanded">
                                    <?= $d->feedback ?>
                                </p>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>