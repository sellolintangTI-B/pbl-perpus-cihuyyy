<?php

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\Badge;
use App\Components\FormInput;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Components\Modal;
use App\Utils\Authentication;

$authUser = new Authentication;

$bookingCode = $_GET['code'] ?? '#AA682358';
$status = $_GET['status'] ?? 'berlangsung';
$statusEnum = [
    "created" => "created",
    "checked_in" => "checked_in",
    "dibatalkan" => "cancelled",
    "selesai" => "finished"
];
$statusLabel = [
    "created" => "berlangsung",
    "checked_in" => "berlangsung",
    "cancelled" => "dibatalkan",
    "finished" => "selesai"
];
$bookingDetail = [
    'id' => $data['booking']->id,
    'code' => $data['booking']->booking_code,
    'status' => $data['booking']->status,
    'pic' => $data['booking']->pic,
    'room' => $data['booking']->name,
    'floor' => $data['booking']->floor,
    'date' => Carbon::parse($data['booking']->start_time)->translatedFormat('l, d F Y'),
    'time' => Carbon::parse($data['booking']->start_time)->translatedFormat('l, H F Y') . ' - ' . Carbon::parse($data['booking']->end_time)->toTimeString(),
    'members' => $data['participants']
];
?>
<div class="bg-baseColor font-poppins" x-data="{ onModalShow: false, showFeedback: false }">
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
                    <h3 class="text-2xl font-medium text-primary">Kode Booking: #<?= $bookingDetail['code'] ?></h3>
                </div>
                <?= Badge::badge(label: $statusLabel[$bookingDetail['status']], color: ($bookingDetail['status'] == $statusEnum["created"] || $bookingDetail['status'] == $statusEnum["checked_in"]) ? 'tertiary' : ($bookingDetail['status'] ==  $statusEnum["selesai"] ? 'secondary' : 'red')) ?>
            </div>

            <!-- Booking Information -->
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <?= Icon::person('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-black/80 font-medium">Nama: <?= $bookingDetail['pic'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::location('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-black/80 font-medium">
                        Tempat: <span class="text-secondary font-medium"><?= $bookingDetail['room'] ?></span>, Perpustakaan PNJ, LT. <?= $bookingDetail['floor'] ?>
                    </span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::calendar_pencil('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-black/80 font-medium">Tanggal: <?= $bookingDetail['date'] ?></span>
                </div>

                <div class="flex items-start gap-3">
                    <?= Icon::clock('w-5 h-5 text-black/80') ?>
                    <span class="text-sm text-black/80 font-medium">Waktu: <?= $bookingDetail['time'] ?></span>
                </div>
                <?php
                if ($data['detailFinished'] && $bookingDetail['status'] == $statusEnum['selesai']) {
                ?>
                    <div class="flex gap-2 items-center justify-start text-black/80">
                        <?= Icon::clock("w-5 h-5") ?>
                        <p class="font-medium text-sm">

                            <?php
                            foreach ($data['detailFinished'] as $detail): ?>
                                <?= $detail->status == 'checked_in' ? 'Check In' : ' &bull; Check Out' ?>:
                                <?= Carbon::parse($detail->created_at)->translatedFormat(' H:i:A') ?>
                            <?php endforeach ?>
                        </p>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Members Section -->
            <div class=" pt-4">
                <h4 class="text-base font-semibold text-primary mb-3">Anggota:</h4>
                <ul class="space-y-2 px-2">
                    <?php foreach ($bookingDetail['members'] as $member): ?>
                        <li class="flex items-start gap-3">
                            <span class="text-secondary font-medium shrink-0">•</span>
                            <span class="text-sm text-gray-700"><?= $member->name ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if ($data['detailCancel'] && $bookingDetail['status'] == $statusEnum['dibatalkan']): ?>
                <div class="w-full flex flex-col gap-2 mt-4">
                    <div class="flex flex-col gap-1  items-start justify-certer w-full">
                        <label class="block text-lg font-medium text-primary">Detail Pembatalan</label>
                        <div class="w-full h-px bg-black/40"></div>
                    </div>
                    <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                        <?= Icon::person("w-5 h-5") ?>
                        <p class="font-medium text-sm">
                            Actor: <?= $data['detailCancel']->cancel_actor ?>
                        </p>
                    </div>
                    <div class="flex gap-2 items-center justify-start text-black/80 mt-2">
                        <?= Icon::clock("w-5 h-5") ?>
                        <p class="font-medium text-sm">
                            Jam Pembatalan: <?= Carbon::parse($data['detailCancel']->created_at)->translatedFormat('H:i A') ?>
                        </p>
                    </div>
                    <div class="flex gap-2 items-start mt-2">
                        <?= Icon::file("w-5 h-5") ?>
                        <div class="flex flex-col gap-2 items-start justify-center text-black/80 ">
                            <p class="font-medium text-sm">
                                Alasan Pembatalan:
                            </p>
                            <p class="text-sm text-black/80 "><?= !empty($data['detailCancel']->reason) ? $data['detailCancel']->reason : "Pembatalan otomatis dari system, karena peminjam tidak melakukan check in" ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (($bookingDetail['status'] == $statusEnum["created"] || $bookingDetail['status'] == $statusEnum["checked_in"]) && $authUser->user['id'] === $data['booking']->pic_id): ?>

                <?= Button::button(label: 'Cancel', type: 'button', color: 'red', class: 'w-full py-2 rounded-full!', alpineClick: "onModalShow=true") ?>
            <?php endif; ?>

            <?php if ($bookingDetail['status'] == $statusEnum['selesai'] && !$data['feedback']): ?>
                <?= Button::buttonGradient(label: 'Send Feedback', type: 'button', class: 'w-full py-2 rounded-full!', alpineClick: "showFeedback=true") ?>
            <?php endif; ?>
        </div>

    </div>

    <!-- cancel dialog -->
    <?php
    ob_start();
    ?>
    <form action="<?= URL ?>/user/booking/cancel_booking/<?= $bookingDetail['id'] ?>" method="POST" class="w-full flex flex-col gap-2">
        <?= FormInput::textarea(id: 'reason', name: 'reason', required: true, label: 'Alasan:', class: 'h-18', maxlength: 100) ?>
        <div class="flex gap-4 w-full ">
            <?php
            Button::button(label: 'Iya', color: 'red', type: 'submit', class: 'w-full py-3');
            Button::button(label: 'Tidak', color: 'white', type: 'button', alpineClick: "onModalShow=false", class: 'w-full py-3');
            ?>
        </div>
    </form>
    <?php $content = ob_get_clean(); ?>
    <?= Modal::render(
        title: 'Yakin ingin membatalkan booking?',
        color: 'red',
        message: 'Pembatalan booking akan menambah suspend point. Jika total suspend point Anda lebih dari 3, Anda akan diblokir dari peminjaman ruangan selama 2 minggu.',
        customContent: $content,
        alpineShow: 'onModalShow',
        height: 'h-[24rem]'
    ) ?>

    <!-- send feedback dialog -->

    <?php
    ob_start();
    ?>
    <form action="<?= URL ?>/user/booking/send_feedback/<?= $bookingDetail['id'] ?>" method="POST" class="w-full flex flex-col gap-6" x-data="{ rating: 0 }">
        <!-- Booking Information -->
        <div class="w-full flex flex-col gap-3 text-left font-medium text-black/80">
            <h3 class="text-2xl font-medium text-primary">Kode Booking: <span class="text-secondary">#<?= $bookingDetail['code'] ?></span></h3>
            <div class="flex flex-col gap-1">
                <span class="text-sm ">
                    Tempat: <span class="text-secondary font-medium"><?= $bookingDetail['room'] ?></span>, Perpustakaan PNJ, LT. <?= $bookingDetail['floor'] ?>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-sm ">
                    Tanggal: <?= $bookingDetail['date'] ?>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-sm ">
                    Jam: <?= $bookingDetail['time'] ?>
                </span>
            </div>
        </div>

        <!-- Star Rating -->
        <div class="w-full flex flex-col gap-3 items-center">
            <div class="flex gap-2 justify-center">
                <template x-for="star in 5" :key="star">
                    <button
                        type="button"
                        @click="rating = star"
                        class="focus:outline-none transition-transform hover:scale-110">
                        <svg
                            class="w-12 h-12 transition-colors duration-200"
                            :class="star <= rating ? 'text-primary' : 'text-gray-300'"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </button>
                </template>
            </div>
            <input type="hidden" name="rating" :value="rating" required>
        </div>

        <!-- Textarea for feedback -->
        <div class="w-full">
            <?=
            FormInput::textarea(
                label: 'Alasan',
                name: 'feedback',
                maxlength: 500,
                rows: 4,
                placeholder: 'masukkan deskripsi',
                required: true,
            );
            ?>
        </div>
        <!-- Hidden input for booking ID -->
        <!-- <input type="hidden" name="booking_id" x-bind:value="bookingId" /> -->

        <!-- Submit Button -->
        <?= Button::buttonGradient(label: 'submit', type: 'submit') ?>
    </form>

    <?php
    $feedbackContent = ob_get_clean();
    ?>

    <?= Modal::render(
        title: 'Feedback',
        color: 'primary',
        message: '',
        customContent: $feedbackContent,
        alpineShow: 'showFeedback',
        class: 'max-w-2xl p-8',
        height: 'h-fit'
    ) ?>

</div>