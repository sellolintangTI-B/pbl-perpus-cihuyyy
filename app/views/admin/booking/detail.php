<?php

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\Badge;
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
                            src="<?= URL . "/public/storage/images/ruang-dummy.jpg" ?>"
                            alt="Ruang Perancis"
                            class="w-full h-full object-cover rounded-lg shadow-sm" />
                    </div>

                    <!-- detail ruangan  -->
                    <div class="p-6 flex flex-col gap-4 items-start justify-start flex-1 w-full border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                        <div class="w-full flex justify-between items-start">
                            <h1 class="text-xl font-medium text-primary flex gap-2">
                                Kode Booking:
                                <span class="text-secondary">
                                    #AA682358
                                </span>
                            </h1>
                            <!-- badge tipe ruangan dan beroperasi -->
                            <?php
                            if (true) {
                                Badge::badge(label: "Ruangan Khusus", color: "secondary", class: 'border-none!');
                            }
                            ?>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::location("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Locations:
                                <span>
                                    Nama: Ruang Perancis
                                </span>
                                , Perpustakaan PNJ, LT. 4
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::people("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Penanggung jawab: Farrel Maahira Agraprana Nugraha
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::calendar_pencil("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Tanggal Booking: 8 - 11 - 2025
                            </p>
                        </div>

                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::clock("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Jam Booking: 13.00 - 15.00
                            </p>
                        </div>
                        <div class="flex gap-2 items-center justify-start text-black/80">
                            <?= Icon::clock("w-5 h-5") ?>
                            <p class="font-medium text-sm">
                                Check In: 13.10 &bull; Check Out: 15.15
                            </p>
                        </div>

                        <div class="max-w-xl w-full">
                            <div class="w-full flex justify-between items-center">
                                <label class="block text-lg font-medium text-primary mb-2">Anggota</label>
                                <button type="button" @click="" class="text-white bg-primary hover:bg-primary/20 text-xs hover:underline px-2 py-1 rounded-md cursor-pointer">edit</button>
                            </div>
                            <!-- Anggota -->
                            <div class="flex flex-col gap-2 rounded-xl items-start w-full justify-start">
                                <!-- List anggota yang sudah ditambahkan -->
                                <table class="table-auto text-left border-collapse w-full">
                                    <!-- Header -->
                                    <thead class="text-primary">
                                        <tr class="border-b border-gray-200 ">
                                            <th class="px-3 py-3 text-xs font-semibold text-start">Nama</th>
                                            <th class="px-3 py-3 text-xs font-semibold text-start">Role</th>
                                            <th class="px-3 py-3 text-xs font-semibold text-start"></th>
                                        </tr>
                                    </thead>
                                    <!-- Body -->
                                    <tbody class="text-primary divide-y divide-gray-100">
                                        <template x-for="(a, index) in listAnggota" :key="index">
                                            <tr
                                                class="hover:bg-gray-50 transition-colors duration-150 text-start">
                                                <td x-text="`${a.name}`" class="text-gray-700 px-3 py-3 text-xs text-start "></td>
                                                <td x-text="`${a.role}`" class="text-gray-700 px-3 py-3 text-xs text-start"></td>
                                                <td class="px-3 py-3">
                                                    <!-- action for delete anggota -->
                                                    <button type="button" @click="deleteAnggota(index)" class="text-red text-xs hover:underline p-2 rounded-full hover:bg-red/5 cursor-pointer">
                                                        <?php
                                                        Icon::trash('w-5 h-5')
                                                        ?>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                <!-- Input tambah anggota -->
                                <input type="text"
                                    x-model="identifier"
                                    placeholder="Masukkan NIM/NIP atau Email"
                                    class="w-full rounded-xl shadow-md p-3 bg-baseColor text-gray-600 border border-gray-400 hover:border-secondary outline-none text-sm transition-shadow duration-300">
                                <!-- Pesan error -->
                                <p x-text="message" class="text-xs text-red mt-1"></p>

                                <div class="w-full flex items-center justify-center">
                                    <button type="button"
                                        @click="tambahAnggota"
                                        class="bg-primary text-white w-8 h-8 cursor-pointer rounded-full hover:bg-primary/90 transition-all">
                                        +
                                    </button>
                                </div>

                                <!-- Hidden input untuk mengirim data ke PHP -->
                                <input type="hidden" name="list_anggota" :value="JSON.stringify(listAnggota)">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- action buttons -->
                <div class="w-full flex flex-col gap-3">
                    <?= Button::anchor(label: 'Edit Data Peminjaman', color: 'primary', class: 'w-full py-3 px-6') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formAnggota() {
        return {
            identifier: '',
            listAnggota: [{
                id: 'A10028',
                name: 'Nugroho Nur Cahyo',
                role: 'Mahasiswa'
            }],
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