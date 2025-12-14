<?php

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\Badge;
use Carbon\Carbon;


?>
<div class="w-full h-full flex flex-col gap-4 " x-data="formAnggota()">
    <h1 class="text-2xl font-medium text-primary">
        Detail Peminjaman
    </h1>
    <div class="flex-1 flex flex-col gap-4 items-start justify-start w-full h-full p-6 rounded-xl border border-gray-200 overflow-hidden bg-white shadow-lg shadow-black/20">
        <button class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" onclick="history.back()">
            <?= Icon::arrowLeft('w-4 h-4') ?>
            Back
        </button>
        <div class="w-full h-full overflow-y-auto overflow-hidden">
            <div class="flex flex-col items-start justify-start gap-6 w-full max-w-5xl mx-auto px-2">
                <!-- informasi ruangan -->
                <div class="w-full h-fit flex flex-col gap-6">
                    <!-- gambar -->
                    <div class="relative h-80 w-full shrink-0 self-stretch">
                        <img
                            src="<?= URL . "/public/" . $data['booking']->room_img_url ?>"
                            alt="Ruang Perancis"
                            class="w-full h-full object-cover rounded-lg shadow-sm" />
                    </div>

                    <!-- detail ruangan  -->
                    <div class="p-6 flex flex-col gap-4 items-start justify-start flex-1 w-full border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                        <div class="w-full flex justify-between items-start">
                            <h1 class="text-xl font-medium text-primary flex gap-2">
                                Kode Booking:
                                <span class="text-secondary">
                                    #<?= $data['booking']->booking_code ?? '-' ?>
                                </span>
                            </h1>
                            <!-- badge tipe ruangan dan beroperasi -->
                            <div class="flex items-center gap-2">
                                <?php
                                if ($data['booking']->requires_special_approval ?? false) {
                                    Badge::badge(label: "Ruangan Khusus", color: "secondary", class: 'border-none!');
                                }
                                ?>
                            </div>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::location("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Locations:
                                <span>
                                    <?= $data['booking']->room_name ?? '-' ?>
                                </span>
                                , Perpustakaan PNJ, LT. <?= $data['booking']->floor ?? '-' ?>
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::people("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Penanggung jawab: <?= $data['booking']->pic_name ?>
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::calendar_pencil("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Tanggal Booking: <?= Carbon::parse($data['booking']->start_time)->translatedFormat('l, d F Y') ?>
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::clock("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Jam Booking: <?= Carbon::parse($data['booking']->start_time)->toTimeString() . ' - ' . Carbon::parse($data['booking']->end_time)->toTimeString() ?>
                            </p>
                        </div>

                        <?php
                        if ($data['detailFinished']) {
                        ?>
                            <div class="flex gap-2 items-center justify-start text-black/80">
                                <?= Icon::clock("w-5 h-5") ?>
                                <p class="font-medium text-sm">

                                    <?php
                                    foreach ($data['detailFinished'] as $detail): ?>
                                        <?= $detail->status == 'checked_in' ? 'Check In' : ' &bull; Check Out' ?>:
                                        <?= Carbon::parse($detail->created_at)->translatedFormat(' H:i A') ?>
                                    <?php endforeach ?>
                                </p>
                            </div>
                        <?php
                        }
                        ?>

                        <?php if ($data['booking']->requires_special_approval ?? false): ?>
                            <!-- PDF Viewer untuk Ruangan Khusus -->
                            <div class="max-w-full w-full mt-4">
                                <div class="w-full flex justify-between items-center mb-4">
                                    <label class="block text-lg font-medium text-primary">Dokumen Persetujuan Khusus</label>
                                </div>
                                <div class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm bg-gray-50">
                                    <iframe
                                        src="<?= URL ?>/public/storage/booking/<?= $data['booking']->special_requirement_attachments_url ?? '' ?>"
                                        class="w-full h-[32rem]"
                                        frameborder="0">
                                    </iframe>
                                    <div class="p-3 bg-white border-t border-gray-300">
                                        <a
                                            href="<?= URL ?>/public/storage/booking/<?= $data['booking']->approval_document_url ?? '' ?>"
                                            target="_blank"
                                            class="text-secondary hover:underline text-sm flex items-center gap-2">
                                            <?= Icon::download("w-5 h-5") ?>
                                            Download Dokumen
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Daftar Anggota untuk Ruangan Biasa -->
                            <div class="max-w-xl w-full mt-4">
                                <div class="w-full flex justify-between items-center">
                                    <label class="block text-lg font-medium text-primary mb-2">Anggota</label>
                                </div>
                                <!-- Anggota -->
                                <div class="flex flex-col gap-2 rounded-xl items-start w-full justify-start">
                                    <template x-for="(a, index) in listAnggota" :key="index" class="">
                                        <ul
                                            class="hover:bg-gray-50 transition-colors duration-150 text-start flex flex-col gap-1">
                                            <li x-text=" `&bull; ${a.name} (${a.role})` " class="text-black/80 font-medium text-sm text-start ">
                                            </li>
                                        </ul>
                                    </template>

                                    <!-- Hidden input untuk mengirim data ke PHP -->
                                    <input type="hidden" name="list_anggota" :value="JSON.stringify(listAnggota)">
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($data['detailCancel']): ?>
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
                                        <p class="text-sm text-black/80">
                                            <?= !empty($data['detailCancel']->reason) ? $data['detailCancel']->reason : "Pembatalan otomatis dari system, karena peminjam tidak melakukan check in" ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- action buttons -->
                    <?php if (!($data['booking']->current_status == 'finished' || $data['booking']->current_status == 'cancelled' || $data['booking']->current_status == 'checked_in')): ?>
                        <?= Button::anchor(label: 'Edit Data Peminjaman', color: 'primary', class: 'w-full py-3 px-6', href: "/admin/booking/edit/" . htmlspecialchars($data['booking']->booking_id)) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function formAnggota() {
            return {
                identifier: '',
                listAnggota: <?php
                                if ($data['bookingParticipants']) {
                                    echo json_encode($data['bookingParticipants']);
                                } else {
                                    if ($authUser->user) {
                                        echo json_encode([[
                                            'id' => $authUser->user['id'],
                                            'name' => $authUser->user['username'],
                                            'role' => $authUser->user['role']
                                        ]]);
                                    } else {
                                        echo '[]';
                                    }
                                }
                                ?>,
                message: '',
            }
        }
    </script>