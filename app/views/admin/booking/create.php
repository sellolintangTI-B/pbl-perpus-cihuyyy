<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;
?>
<div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Peminjaman
        </h1>
    </div>
    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center">
        <div class="w-full h-10 flex items-center justify-start">
            <a class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/booking/index" ?>">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </a>
        </div>
        <div class="flex-1 w-full overflow-y-auto">
            <div class="flex items-center justify-center  w-full max-w-5xl mx-auto">
                <form class="w-full max-w-3xl grid grid-cols-1 sm:grid-cols-2 gap-6" action="<?= URL . "/admin/room/store" ?>" method="post" enctype="multipart/form-data" x-data="formAnggota()">
                    <?php
                    FormInput::select(
                        id: 'room',
                        name: 'room',
                        label: 'Ruangan',
                        placeholder: "Pilih Ruangan",
                        required: true,
                        options: [
                            ['display' => 'ruang baru', 'value' => 'id_ruangan']
                        ]
                    );
                    FormInput::input(id: 'pic', name: 'pic_id', type: 'text', label: 'Penanggung Jawab', placeholder: "Masukkan NIM/NIP dari penanggung jawab", required: true);
                    FormInput::input(id: 'datetime', name: 'datetime', type: 'datetime-local', label: 'Tanggal Peminjaman', placeholder: 'Masukkan tanggal peminjaman', required: true);
                    FormInput::input(id: 'duration', name: 'duration', type: 'time', label: 'Durasi', placeholder: 'Masukkan durasi peminjaman',  required: true);
                    ?>

                    <?php
                    // kondisi apakah ini peminjaman untuk ruangan khusus atau bukan
                    if (false):
                    ?>
                        <div class="sm:col-span-2 mt-4">
                            <?php
                            FormInput::fileInput(
                                id: 'file_upload',
                                name: 'file',
                                label: 'Upload Surat Peminjaman ',
                                required: true,
                                classGlobal: 'sm:col-span-2',
                                accept: 'image/*'
                            );
                            ?>
                        </div>
                    <?php
                    else:
                    ?>
                        <div class="sm:col-span-2">
                            <label class="block text-xl text-primary mb-2">Anggota</label>
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
                        </div>

                    <?php
                    endif;
                    ?>
                    <div class="sm:col-span-2 mt-4">
                        <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                            Tambah Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function formAnggota() {
        // inisialisasikan anggotanya disini terlebih dahulu
        return {
            identifier: '',
            listAnggota: [{
                id: '1',
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