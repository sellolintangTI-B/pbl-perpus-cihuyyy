<?php

use App\Components\FormInput;
use App\Components\Icon\Icon;
use Carbon\Carbon;
use App\Utils\Authentication;
use App\Components\Button;

$authUser = new Authentication;

if (isset($_SESSION['old_booking'])) {
    $oldData = $_SESSION['old_booking'];
}

?>

<div class="max-w-6xl mx-auto p-4 justify-center items-start flex flex-col gap-6" x-data="formAnggota()">

    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="javascript:history.back()" class="text-primary">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-medium text-primary"><?= $data['detail']->name ?></h1>
    </div>

    <img src="<?= URL ?>/public/<?= $data['detail']->room_img_url ?>" alt="Ruang Perancis" class="w-full h-80 object-cover rounded-lg shadow-md">
    <div class="grid grid-cols-5 gap-4">
        <div class="col-span-3 h-28">
            <div class="bg-linear-to-r from-primary to-secondary flex items-center justify-center rounded-xl p-4 shadow-lg w-full h-full">
                <div class="flex items-center gap-3 text-white">
                    <div class=" p-2 rounded-full">
                        <?= ($data['detail']->requires_special_approval)
                            ?  Icon::group('w-10 h-10')
                            :  Icon::global('w-10 h-10') ?>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-lg mb-1"><?= ($data['detail']->requires_special_approval) ? "Ruangan Khusus" : "Ruangan Umum"  ?></h3>
                        <p class="text-sm opacity-90"><?= ($data['detail']->requires_special_approval) ? "Ruangan ini hanya bisa dipinjam dengan menggunakan surat dari admin PNJ. baca panduan untuk detail lebih lanjut." : "Ruangan ini bisa dipinjam tanpa menggunakan surat khusus, cukup patuhi aturan yang tertera di panduan."  ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-2 h-28">
            <div class="flex gap-8 p-4 bg-white rounded-xl items-center justify-center shadow-md text-center w-full h-full">
                <div class="text-center flex flex-col items-center justify-center gap-4 w-full">
                    <div class="flex items-center justify-center gap-1 text-primary">
                        <span class="text-3xl font-bold">4.75</span>
                    </div>
                    <div class="flex justify-center gap-1">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <svg class="w-4 h-4 <?= $i < 4 ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="h-1/2 w-[1px] bg-gray-400 rounded-full">

                </div>
                <div class="text-center flex flex-col items-center justify-center gap-4 w-full">
                    <div class="text-3xl font-bold text-primary">63</div>
                    <div class="text-sm text-gray-600">Ulasan</div>
                </div>
            </div>
        </div>

        <div class="col-span-3">
            <div class="flex flex-col gap-4 justify-start items-start bg-white rounded-xl shadow-md p-4 w-full">
                <!-- Capacity -->
                <div class="flex items-center gap-2 text-gray-700 text-sm w-full">
                    <?= Icon::people('w-6 h-6 text-black/80') ?>
                    <span class="font-medium font-black/80 text-lg">Minimal <?= $data['detail']->min_capacity ?> orang - Maksimal <?= $data['detail']->max_capacity ?> orang</span>
                </div>

                <!-- Location -->
                <div class="flex items-center gap-2 text-gray-700 text-sm w-full">
                    <?= Icon::location('w-6 h-6 text-black/80') ?>
                    <span class="font-medium font-black/80 text-lg">Tempat: Perpustakaan PNJ, LT. <?= $data['detail']->floor ?></span>
                </div>

                <!-- Description -->
                <p class="text-sm text-gray-600 leading-relaxed text-justify">
                    <?= $data['detail']->description ?>
                </p>
                <!-- jadwal perpustakaan -->
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="text-lg font-medium text-black/80">Jadwal buka perpustakaan</h3>
                    <div class="w-full h-px bg-gray-400 rounded-full">
                    </div>
                </div>
                <div class="rounded-lg overflow-hidden w-full">
                    <table class="w-full text-sm text-black/80">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left font-medium ">Hari</th>
                                <th class="px-4 py-2 text-left font-medium ">Jam</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr>
                                <td class="px-4 py-3 ">Senin - Kamis</td>
                                <td class="px-4 py-3 ">08.00 - 12.00 &bull; 13.00 - 15.50</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 ">Jumat</td>
                                <td class="px-4 py-3 ">08.00 - 11.00 &bull; 13.00 - 16.00</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 ">Sabtu - Minggu</td>
                                <td class="px-4 py-3 text-red">Libur</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 ">tanggal merah</td>
                                <td class="px-4 py-3 text-red">Libur</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="text-lg font-medium text-black/80">Waktu terpakai</h3>
                    <div class="w-full h-px bg-gray-400 rounded-full">
                    </div>
                </div>
                <!-- Date Input -->
                <form class="w-full flex justify-between items-center h-8" method="get">
                    <div class="flex items-center shrink gap-2 h-full">
                        <label class="block text-lg  text-black/80">Tanggal:</label>
                        <?php FormInput::input(
                            id: "date_check",
                            name: "date_check",
                            type: "date",
                            required: true,
                            value: $oldData['date'] ?? (isset($_GET['date']) ? $_GET['date'] : null),
                            classGlobal: 'h-full p-0! bg-transparent!',
                            class: 'h-full text-lg! bg-transparent! rounded-none! border-none! p-0! focus:ring-0! focus:border-0! focus:bg-transparent!',
                        ); ?>
                    </div>
                    <button
                        type="submit"
                        class=" bg-primary text-white px-4 max-h-full h-full rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors">
                        Cek
                    </button>
                </form>

                <!-- Schedule Table -->
                <div class=" rounded-lg overflow-hidden w-full">
                    <table class="w-full text-sm text-black/80">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left font-medium ">Jam</th>
                                <th class="px-4 py-2 text-left font-medium ">Peminjam</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($data['schedule'] as $schedule) : ?>
                                <tr>
                                    <td class="px-4 py-3 "><?= Carbon::parse($schedule->start_time)->toTimeString() ?> - <?= Carbon::parse($schedule->end_time)->toTimeString() ?></td>
                                    <td class="px-4 py-3 "><?= $schedule->pic_name ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-span-2">
            <div class="bg-white rounded-xl p-4 shadow-md w-full">
                <?php if ($data['detail']->requires_special_approval): ?>
                    <div class="flex flex-col gap-4">
                        <p class=" text-lg text-primary flex flex-col gap-2 font-medium">
                            Panduan Peminjaman Ruang Rapat:
                        </p>
                        <ul class="text-sm space-y-2">
                            <li> 1. Siapkan surat resmi peminjaman ruang rapat sesuai format yang berlaku.</li>
                            <li> 2. Serahkan surat tersebut kepada Admin Perpustakaan.</li>
                            <li> 3. Admin Perpustakaan akan memproses dan menginformasikan hasil peminjaman.</li>
                        </ul>
                        <p class="text-sm text-red italic">
                            Catatan: Format surat resmi dapat diminta langsung kepada Admin Perpustakaan
                        </p>
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?= URL ?>/user/booking/store/<?= $data['detail']->id ?>" @submit="prepareData" enctype="multipart/form-data" class="space-y-4 w-full">
                        <!-- tanggal -->
                        <div>
                            <label class="block text-sm font-medium text-primary mb-2">Kapan</label>
                            <?php FormInput::input(id: "date", name: "date", type: "date", required: true, value: $oldData['date'] ?? (isset($_GET['date']) ? $_GET['date'] : null)); ?>
                        </div>

                        <!-- start time -->
                        <div>
                            <label class="block text-sm font-medium text-primary mb-2">Waktu mulai</label>
                            <?php FormInput::input(id: "start_time", name: "start_time", type: "time", required: true, value: $oldData['start_time'] ?? (isset($_GET['start_time']) ? $_GET['start_time'] : null)); ?>
                        </div>
                        <!-- end time -->
                        <div>
                            <label class="block text-sm font-medium text-primary mb-2">Waktu berakhir</label>
                            <?php FormInput::input(id: "end_time", name: "end_time", type: "time", required: true, value: $oldData['end_time'] ?? (isset($_GET['end_time']) ? $_GET['end_time'] : null)); ?>
                        </div>
                        <!-- Anggota -->
                        <label class="block text-sm font-medium text-primary mb-2">Anggota</label>
                        <div class="flex flex-col gap-2 p-4 bg-white border border-gray-400 rounded-xl items-start">
                            <!-- List anggota yang sudah ditambahkan -->
                            <template x-for="(a, index) in listAnggota" :key="index">
                                <div class="flex items-center justify-between w-full">
                                    <span x-text="`${index + 1}. ${a.name} (${index == 0?'PJ':'Partitipants'})`" class="text-gray-700 text-sm"></span>
                                    <button type="button" @click="deleteAnggota(index)" class="text-red text-xs hover:underline cursor-pointer" :class="index==0?'hidden':'block'">
                                        <?= Icon::trash('w-5 h-5') ?>
                                    </button>
                                </div>
                            </template>
                            <!-- Input tambah anggota -->
                            <div class="w-full flex items-center justify-center h-12 gap-2 mt-4">
                                <?php
                                FormInput::input(
                                    id: 'anggota_input',
                                    name: 'anggota_input',
                                    type: 'text',
                                    placeholder: 'Masukkan NIM/NIP atau Email',
                                    classGlobal: 'w-full',
                                    alpine_xmodel: 'identifier',
                                );
                                ?>
                                <?php
                                Button::button(
                                    type: 'button',
                                    icon: 'plus',
                                    color: 'primary',
                                    class: 'h-full w-16 flex items-center justify-center text-sm font-medium',
                                    btn_icon_size: 'w-5 h-5',
                                    alpineClick: 'tambahAnggota()'
                                )
                                ?>
                            </div>
                            <!-- Pesan error -->
                            <p x-text="message" class="text-xs text-red-500 mt-1"></p>

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

                        <!-- Upload surat resmi 
                        <div>
                            <label class="block text-sm font-medium text-primary mb-2">Upload Surat Resmi</label>
                            <?php //FormInput::fileInput(id: "surat", name: "file_surat", placeholder: "Surat Izin Peminjaman", accept: 'image/*', required: true)
                            ?>
                        </div> -->
                        <!-- Tombol submit -->
                        <?=
                        Button::buttonGradient(label: 'Booking Ruangan Ini', class: 'w-full py-3 rounded-xl', type: 'submit')
                        ?>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function formAnggota() {
        const min_capacity = <?= $data['detail']->min_capacity ?? 1 ?>;
        const max_capacity = <?= $data['detail']->max_capacity ?>;
        return {
            identifier: '',
            listAnggota: <?php
                            if (!empty($oldData['list_anggota'])) {
                                echo $oldData['list_anggota'];
                            } else {
                                if ($authUser->user) {
                                    echo json_encode([[
                                        'id' => $authUser->user['id'],
                                        'name' => $authUser->user['username'],
                                        'id_number' => $authUser->user['id_number'] ?? $authUser->user['email'] ?? ''
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
                if (this.listAnggota.length >= max_capacity) {
                    event.preventDefault();
                    this.message = `* Maksimal ${max_capacity} anggota diperbolehkan.`;
                    return false;
                }
                let isExist = this.listAnggota.find(anggota =>
                    anggota.id_number === this.identifier ||
                    anggota.id === this.identifier
                );

                if (isExist) {
                    this.message = '* Anggota sudah ditambahkan';
                    return;
                }

                try {
                    let res = await fetch(`<?= URL ?>/user/booking/search_user/${encodeURIComponent(this.identifier)}`);

                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }

                    let data = await res.json();

                    if (data.success) {
                        this.listAnggota.push({
                            id: data.data.id,
                            name: data.data.first_name + " " + data.data.last_name,
                            id_number: this.identifier
                        });
                        this.identifier = '';
                        this.message = '';
                    } else {
                        this.message = data.message || '* Data tidak ditemukan!';
                    }
                } catch (err) {
                    console.error('Error:', err);
                    this.message = '* Terjadi kesalahan server.';
                }
            },

            deleteAnggota(index) {
                if (index > 0 && index < this.listAnggota.length) {
                    this.listAnggota.splice(index, 1);
                }
            },

            prepareData(event) {
                console.log(max_capacity)
                <?php if (!($data['detail']->requires_special_approval)): ?>
                    if (this.listAnggota.length < min_capacity) {
                        event.preventDefault();
                        this.message = `* Minimal ${min_capacity} anggota diperlukan.`;
                        return false;
                    }
                    if (this.listAnggota.length > max_capacity) {
                        event.preventDefault();
                        this.message = `* Maksimal ${max_capacity} anggota diperbolehkan.`;
                        return false;
                    }
                <?php endif; ?>

                return true;
            }
        }
    }
</script>