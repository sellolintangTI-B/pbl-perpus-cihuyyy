<?php

use App\Components\FormInput;
use App\Components\Icon\Icon;
use Carbon\Carbon;
use App\Utils\Authentication;

$authUser = new Authentication;
var_dump($data['date']);

if (isset($_SESSION['old_input'])) {
    $oldData = $_SESSION['old_input'];
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
    <div class="flex gap-4 items-center justify-center w-full h-32">
        <div class="bg-linear-to-r from-primary to-secondary flex items-center justify-center rounded-xl p-4 shadow-lg flex-3 h-full">
            <div class="flex items-center gap-3 text-white">
                <div class="bg-white/20 p-2 rounded-full">
                    <?= Icon::global('w-10 h-10') ?>
                </div>
                <div class="flex-1">
                    <h3 class="font-medium text-lg mb-1"><?= ($data['detail']->requires_special_approval) ? "Ruangan Khusus" : "Ruangan Umum"  ?></h3>
                    <p class="text-sm opacity-90">Lorem ipsum dolor sit amet consdtaectetur adipisicing elit. Quod ad, nostrum dicta doloremque totam pariatur officia doloribus id soluta ea?</p>
                </div>
            </div>
        </div>
        <div class="flex-2 flex gap-8 p-4 bg-white rounded-xl items-center justify-center shadow-md text-center h-full">
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

    <!-- main information -->
    <div class="flex gap-8 items-start justify-start w-full">
        <!-- informasi kiri -->
        <div class="flex-3 flex flex-col gap-4 justify-start items-start">
            <!-- Capacity -->
            <div class="flex items-center gap-2 text-gray-700 text-sm w-full">
                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                <span>Minimal <?= $data['detail']->min_capacity ?> orang - Maksimal <?= $data['detail']->max_capacity ?> orang</span>
            </div>

            <!-- Location -->
            <div class="flex items-center gap-2 text-gray-700 text-sm w-full">
                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <span>Tempat: Perpustakaan PNJ, LT. <?= $data['detail']->floor ?></span>
            </div>

            <!-- Description -->
            <p class="text-sm text-gray-600 leading-relaxed text-justify">
                <?= $data['detail']->description ?>
            </p>

            <h3 class="text-lg font-medium text-primary">Waktu terpakai</h3>
            <!-- Date Input -->
            <form class="w-full flex justify-between items-center h-8" method="get">
                <div class="flex items-center shrink gap-2 h-full">
                    <label class="block text-sm font-medium text-primary">Tanggal:</label>
                    <input type="date"
                        name="date"
                        x-model="tanggal"
                        class="w-full h-full rounded-xl p-2 text-gray-600 outline-none border-none"
                        value="<?= $data['date'] ?>"
                        required>
                </div>
                <button
                    type="submit"
                    class=" bg-primary text-white px-4 max-h-full h-full rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors">
                    Cek
                </button>
            </form>

            <!-- Schedule Table -->
            <div class="border border-gray-200 rounded-lg overflow-hidden w-full">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Jam</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Peminjam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($data['schedule'] as $schedule) : ?>
                            <tr>
                                <td class="px-4 py-3 text-gray-600"><?= Carbon::parse($schedule->start_time)->toTimeString() ?> - <?= Carbon::parse($schedule->end_time)->toTimeString() ?></td>
                                <td class="px-4 py-3 text-gray-600"><?= $schedule->pic_name ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- form kanan -->
        <div class="flex-2 flex flex-col gap-4 justify-start items-center">
            <!-- Form Section -->
            <div class="bg-white rounded-xl p-4 shadow-md w-full">
                <form method="POST" action="<?= URL ?>/user/booking/store/<?= $data['detail']->id ?>" @submit="prepareData" enctype="multipart/form-data" class="space-y-4 w-full">
                    <!-- Kapan -->
                    <div>
                        <label class="block text-sm font-medium text-primary mb-2">Kapan</label>
                        <?php FormInput::input(id: "date", name: "datetime", type: "datetime-local", required: true, value: $oldData['datetime'] ?? null); ?>
                    </div>

                    <!-- Durasi -->
                    <div>
                        <label class="block text-sm font-medium text-primary mb-2">Durasi</label>
                        <?php FormInput::input(id: "duration", name: "duration", type: "time", required: true, value: $oldData['duration'] ?? null); ?>
                    </div>

                    <?php if ($data['detail']->requires_special_approval): ?>
                        <!-- Upload surat resmi  -->
                        <div>
                            <label class="block text-sm font-medium text-primary mb-2">Upload Surat Resmi</label>
                            <?php FormInput::fileInput(id: "surat", name: "file_surat", placeholder: "Surat Izin Peminjaman", accept: 'image/*', required: true)
                            ?>
                        </div>
                    <?php else: ?>
                        <label class="block text-sm font-medium text-primary mb-2">Anggota</label>
                        <!-- Anggota -->
                        <div class="flex flex-col gap-2 p-4 bg-white border border-gray-400 rounded-xl items-start">
                            <!-- List anggota yang sudah ditambahkan -->
                            <template x-for="(a, index) in listAnggota" :key="index">
                                <div class="flex items-center justify-between w-full">
                                    <span x-text="`${index + 1}. ${a.name} (${index == 0?'PJ':'Partitipants'})`" class="text-gray-700 text-sm"></span>
                                    <button type="button" @click="deleteAnggota(index)" class="text-red-500 text-xs hover:underline" :class="index==0?'hidden':'block'">hapus</button>
                                </div>
                            </template>
                            <!-- Input tambah anggota -->
                            <input type="text"
                                x-model="identifier"
                                placeholder="Masukkan NIM/NIP atau Email"
                                class="w-full rounded-xl shadow-md p-3 bg-baseColor text-gray-600 border border-gray-400 hover:border-secondary outline-none text-sm transition-shadow duration-300">
                            <!-- Pesan error -->
                            <p x-text="message" class="text-xs text-red-500 mt-1"></p>

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
                    <?php endif; ?>
                    <!-- Tombol submit -->
                    <button type="submit"
                        class="w-full bg-linear-to-r from-primary to-secondary text-white py-3 rounded-xl font-medium text-sm hover:shadow-lg transition-all duration-300">
                        Booking Ruangan Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function formAnggota() {
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
            tanggal: '<?= $_GET['date'] ?? '' ?>',

            async tambahAnggota() {
                if (this.identifier.trim() === '') {
                    this.message = '* NIM/NIP atau Email tidak boleh kosong';
                    return;
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
                const min_capacity = <?= $data['detail']->min_capacity ?? 1 ?>;

                <?php if (!$data['detail']->requires_special_approval): ?>
                    if (this.listAnggota.length < min_capacity) {
                        event.preventDefault();
                        this.message = `* Minimal ${min_capacity} anggota diperlukan.`;
                        return false;
                    }
                <?php endif; ?>

                return true;
            }
        }
    }
</script>