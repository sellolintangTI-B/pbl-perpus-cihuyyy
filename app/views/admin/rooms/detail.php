<?php

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\Badge;


?>
<div class="w-full h-full flex flex-col gap-4 ">
    <h1 class="text-2xl font-medium text-primary">
        Detail Ruangan
    </h1>
    <div class="flex-1 flex flex-col gap-4 items-start justify-start w-full h-full p-6 rounded-xl border border-gray-200 overflow-hidden bg-white shadow-lg shadow-black/20">
        <a class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/room/index" ?>">
            <?= Icon::arrowLeft('w-4 h-4') ?>
            Back
        </a>
        <div class="w-full h-full overflow-y-auto overflow-hidden">
            <div class="flex flex-col items-start justify-start w-full max-w-5xl mx-auto gap-6 px-2">
                <!-- informasi ruangan -->
                <div class="w-full h-fit flex gap-6">
                    <!-- gambar -->
                    <div class="relative h-80 w-96 shrink-0 self-stretch">
                        <img
                            src="<?= URL . "/public/" . $data->room_img_url ?>"
                            alt="Ruang Perancis"
                            class="w-full h-full object-cover rounded-lg shadow-sm" />
                    </div>

                    <!-- detail ruangan  -->
                    <div class="p-6 flex flex-col gap-4 items-start justify-start flex-1 w-full border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                        <div class="w-full flex justify-between items-start">
                            <h1 class="text-xl font-medium text-primary">
                                <?= $data->name ?>
                            </h1>
                            <!-- badge tipe ruangan dan beroperasi -->
                            <div class="flex gap-2">
                                <?php
                                if ($data->requires_special_approval) {
                                    Badge::badge(label: "Ruangan Khusus", color: "secondary", class: 'border-none!');
                                }
                                Badge::badge(label: $data->is_operational ? "Beroperasi" : "Tidak Beroperasi", color: $data->is_operational ? "secondary" : "red", class: 'border-none!');
                                ?>
                            </div>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::location("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Lantai: <?= $data->floor ?>
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::people("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Kapasitas Minimal: <?= $data->min_capacity ?> Orang
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::people("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Kapasitas Maksimal: <?= $data->max_capacity ?> Orang
                            </p>
                        </div>

                        <div class="flex gap-2 items-start justify-start text-black/80 mt-2">
                            <span>
                                <?= Icon::file("w-5 h-5") ?>
                            </span>
                            <div class="flex flex-col gap-2" x-data="{openDesc: false}">
                                <p class="font-medium text-sm">
                                    Deskripsi:
                                </p>
                                <p class="text-sm text-black/60 leading-relaxed cursor-pointer" :class="openDesc?'line-clamp-none':'line-clamp-3'" @click="openDesc = !openDesc">
                                    <?= $data->description ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- waktu terpakai -->
                <div class="p-6 flex flex-col gap-4 items-start justify-start w-full border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                    <div class="w-full flex justify-between items-center">
                        <h1 class="text-xl font-medium text-primary">
                            Waktu Terpakai
                        </h1>
                    </div>

                    <!-- date picker -->
                    <form class="w-full flex gap-2 items-center justify-between" method="GET">
                        <div class="flex gap-2 items-center justify-start">
                            <label class="text-sm text-black/80 font-medium">Tanggal:</label>
                            <input
                                type="date"
                                name="date_check"
                                value="<?= $_GET['date_check'] ?? null ?>"
                                class="px-3 py-1.5 border-none custom-input-icon text-sm focus:outline-none focus:border-primary"
                                placeholder="YYYY-MM-DD" />
                        </div>
                        <button type="submit" class="px-4 py-1.5 bg-primary text-white text-xs cursor-pointer font-medium rounded-lg hover:bg-primary/90 transition-all duration-300">
                            Cek
                        </button>
                    </form>

                    <!-- tabel waktu -->
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-medium text-black/80">Jam</th>
                                    <th class="text-left py-3 px-4 font-medium text-black/80">Peminjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-black/70">08:00 - 11:00</td>
                                    <td class="py-3 px-4 text-black/70">Badrul Simanjuntak</td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-black/70">13:00 - 14:00</td>
                                    <td class="py-3 px-4 text-black/70">Nujorono Nur Cahyo</td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-black/70">14:00 - 16:30</td>
                                    <td class="py-3 px-4 text-black/70">Budiarto Sinagar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- action buttons -->
                <div class="w-full flex flex-col gap-3">
                    <?= Button::anchor(label: 'Edit Ruangan', color: 'secondary', class: 'w-full py-3 px-6', href: "/admin/room/edit/" . $data->id) ?>
                    <?= Button::button(label: 'Nonaktifkan Ruangan', color: 'red', class: 'w-full py-3 px-6') ?>
                </div>
            </div>
        </div>
    </div>
</div>