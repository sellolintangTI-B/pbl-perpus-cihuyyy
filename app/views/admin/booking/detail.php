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
        <a class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/booking/index" ?>">
            <?= Icon::arrowLeft('w-4 h-4') ?>
            Back
        </a>
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
                                    <?= $data['booking']->name ?? '-' ?>
                                </span>
                                , Perpustakaan PNJ, LT. <?= $data['booking']->floor ?? '-' ?>
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::people("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Penanggung jawab: <?= $data['booking']->pic ?>
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
                                        <?= Carbon::parse($detail->created_at)->translatedFormat(' H:i:A') ?>
                                    <?php endforeach ?>
                                </p>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="max-w-xl w-full mt-4">
                            <div class="w-full flex justify-between items-center">
                                <label class="block text-lg font-medium text-primary mb-2">Anggota</label>
                                <!-- <button type="button" @click="" class="text-white bg-primary hover:bg-primary/20 text-xs hover:underline px-2 py-1 rounded-md cursor-pointer">edit</button> -->
                            </div>
                            <!-- Anggota -->
                            <div class="flex flex-col gap-2 rounded-xl items-start w-full justify-start">
                                <template x-for="(a, index) in listAnggota" :key="index" class="">
                                    <ul
                                        class="hover:bg-gray-50 transition-colors duration-150 text-start flex flex-col gap-1">
                                        <li x-text=" `&bull; ${a.name} (${a.role})` " class="text-black/80 font-medium text-sm text-start ">
                                        </li>
                                        <!-- action for delete anggota -->
                                        <!-- <button type="button" @click="deleteAnggota(index)" class="text-red text-xs hover:underline p-2 rounded-full hover:bg-red/5 cursor-pointer">
                                                        <?php
                                                        Icon::trash('w-5 h-5')
                                                        ?>
                                                    </button> -->
                                    </ul>
                                </template>

                                <!-- Input tambah anggota -->
                                <!-- <input type="text"
                                    x-model="identifier"
                                    placeholder="Masukkan NIM/NIP atau Email"
                                    class="w-full rounded-xl shadow-md p-3 bg-baseColor text-gray-600 border border-gray-400 hover:border-secondary outline-none text-sm transition-shadow duration-300"> -->
                                <!-- Pesan error -->
                                <!-- <p x-text="message" class="text-xs text-red mt-1"></p> -->

                                <!-- <div class="w-full flex items-center justify-center">
                                    <button type="button"
                                        @click="tambahAnggota"
                                        class="bg-primary text-white w-8 h-8 cursor-pointer rounded-full hover:bg-primary/90 transition-all">
                                        +
                                    </button>
                                </div> -->

                                <!-- Hidden input untuk mengirim data ke PHP -->
                                <input type="hidden" name="list_anggota" :value="JSON.stringify(listAnggota)">
                            </div>
                        </div>

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
                    <?php if (!($data['booking']->status == 'finished' || $data['booking']->status == 'cancelled')): ?>
                        <?= Button::anchor(label: 'Edit Data Peminjaman', color: 'primary', class: 'w-full py-3 px-6') ?>
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
                async tambahAnggota() {
                    if (this.identifier.trim() === '') {
                        this.message = '* NIM/NIP atau Email tidak boleh kosong';
                        return;
                    }
                    let isExist = this.listAnggota.find(anggota => anggota.id_number === this.identifier)

                    if (isExist) {
                        this.message = '* Anggota sudah ditambahkan';
                        return;
                    }
                    try {
                        // request ke server untuk validasi NIM
                        let res = await fetch(`<?= URL ?>/user/booking/search_user/${this.identifier}`);
                        let data = await res.json();
                        console.log(data);

                        if (data.success) {
                            this.listAnggota.push({
                                id: data.data.id,
                                name: data.data.first_name + " " + data.data.last_name
                            });
                            this.identifier = '';
                            this.message = '';
                        } else {
                            this.message = '* Data tidak ditemukan!';
                        }
                    } catch (err) {
                        console.log(err);
                        this.message = '* Terjadi kesalahan server.';
                    }
                },

                deleteAnggota(index) {
                    if (index >= 0) this.listAnggota.splice(index, 1);
                },

                prepareData(event) {
                    // const min_capacity = <?php /*echo $data['detail']["min_capacity"]; */ ?>;
                    // if (this.listAnggota.length < min_capacity) {
                    //     event.preventDefault();
                    //     this.message = `Minimal ${min_capacity} anggota diperlukan.`;
                    // }
                }
            }
        }
    </script>