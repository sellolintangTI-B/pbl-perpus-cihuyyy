<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\FormInput;
?>

<div class="w-full h-full grid sm:grid-cols-5 grid-cols-1 gap-4 overflow-hidden">
    <!-- form peminjaman ruangan di sebelah kiri -->
    <div class="sm:col-span-3 h-full bg-white rounded-lg overflow-hidden flex flex-col">
        <div class="w-full h-full overflow-y-auto p-6">
            <div class="flex flex-col items-start gap-4 w-full">
                <h1 class="font-medium text-black/80 text-xl">
                    Form Peminjaman Ruangan
                </h1>
                <form
                    class="w-full flex flex-col gap-6"
                    action="<?= URL ?>/admin/booking/store/<?= $data['data']->id ?>"
                    method="post"
                    enctype="multipart/form-data"
                    x-data="formAnggota()"
                    @submit="prepareData($event)">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php
                        // Room Select Options
                        $options = [];
                        foreach ($data['roomList'] as $value) {
                            $options[] = [
                                'display' => $value->name,
                                'value' => $value->id,
                            ];
                        }

                        FormInput::select(
                            id: 'room',
                            name: 'room',
                            label: 'Ruangan',
                            placeholder: "Pilih Ruangan",
                            disabled: true,
                            required: true,
                            options: $options,
                            value: $data['data']->id,
                            classGlobal: 'md:col-span-2',
                            readonly: true
                        );

                        FormInput::input(
                            id: 'datetime',
                            name: 'datetime',
                            type: 'date',
                            label: 'Tanggal Peminjaman',
                            placeholder: 'Masukkan tanggal peminjaman',
                            required: true,
                            classGlobal: 'md:col-span-2'
                        );

                        FormInput::input(
                            id: 'start_time',
                            name: 'start_time',
                            type: 'time',
                            label: 'Waktu Mulai',
                            placeholder: 'Masukkan jam mulai peminjaman',
                            required: true,
                            classGlobal: 'col-span-1'
                        );

                        FormInput::input(
                            id: 'end_time',
                            name: 'end_time',
                            type: 'time',
                            label: 'Waktu Berakhir',
                            placeholder: 'Masukkan jam peminjaman berakhir',
                            required: true,
                            classGlobal: 'col-span-1'
                        );
                        ?>
                    </div>

                    <?php if ($data['data']->requires_special_approval): ?>
                        <!-- Special Approval: File Upload -->
                        <div class="w-full">
                            <?php
                            FormInput::fileInput(
                                id: 'file_upload',
                                name: 'file',
                                label: 'Upload Surat Peminjaman',
                                required: true,
                                accept: 'image/*'
                            );
                            ?>
                        </div>
                    <?php else: ?>
                        <!-- Regular Booking: Members List -->
                        <div class="w-full">
                            <label class="block text-xl text-primary mb-4">Anggota</label>
                            <div class="flex flex-col gap-3">
                                <!-- List of Added Members -->
                                <div class="flex flex-col gap-2 max-h-64 overflow-y-auto">
                                    <template x-for="(anggota, index) in listAnggota" :key="index">
                                        <div class="flex items-center justify-between w-full p-2 bg-gray-50 rounded-md">
                                            <span
                                                x-text="`${index + 1}. ${anggota.name} (${index === 0 ? 'PJ' : 'Partisipan'})`"
                                                class="text-gray-700 text-sm">
                                            </span>
                                            <button
                                                type="button"
                                                @click="deleteAnggota(index)"
                                                class="text-red hover:text-red/80 text-xs font-medium transition-colors"
                                                x-show="index !== 0">
                                                Hapus
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <!-- Add Member Input -->
                                <div class="w-full flex items-end gap-2 mt-4">
                                    <?php
                                    FormInput::input(
                                        id: 'anggota_input',
                                        name: 'anggota_input',
                                        type: 'text',
                                        placeholder: 'Masukkan NIM/NIP atau Email',
                                        classGlobal: 'flex-1',
                                        alpine_xmodel: 'identifier',
                                    );
                                    ?>
                                    <?php
                                    Button::button(
                                        type: 'button',
                                        icon: 'plus',
                                        color: 'primary',
                                        class: 'h-12 w-12 flex items-center justify-center',
                                        btn_icon_size: 'w-5 h-5',
                                        alpineClick: 'tambahAnggota()'
                                    )
                                    ?>
                                </div>

                                <!-- Error Message -->
                                <p x-show="message" x-text="message" class="text-xs text-red mt-1" x-cloak></p>

                                <!-- Hidden Input for PHP Submission -->
                                <input type="hidden" name="list_anggota" :value="JSON.stringify(listAnggota)">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <div class="w-full">
                        <?php
                        Button::button(
                            type: 'submit',
                            label: 'Tambah Peminjaman',
                            color: 'primary',
                            class: 'w-full py-3',
                        )
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- detail ruangan  -->
    <div class="sm:col-span-2 h-full w-full bg-white rounded-lg overflow-hidden flex flex-col ">
        <div class="flex flex-col gap-4 w-full p-6">
            <!-- foto ruangan -->
            <div class="w-full h-48 rounded-lg overflow-hidden shrink-0">
                <img
                    src="<?= URL ?>/public/storage/images/login-image.jpg"
                    alt="Foto Ruangan"
                    class="w-full h-full object-cover" />
            </div>
            <h2 class="font-medium text-black/80 text-xl">
                Ruangan Terpakai
            </h2>
            <!-- Informasi ruangan -->
            <div class="w-full flex-1 h-full">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <span class="font-medium text-sm text-gray-800">Nama Ruangan:</span>
                        <span class="text-sm text-gray-600"><?= $data['data']->name ?></span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-medium text-sm text-gray-800">Kapasitas:</span>
                        <span class="text-sm text-gray-600"><?= $data['data']->min_capacity ?> - <?= $data['data']->max_capacity ?> orang</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-medium text-sm text-gray-800">Lantai:</span>
                        <span class="text-sm text-gray-600">Lantai <?= $data['data']->floor ?></span>
                    </div>

                    <?php if ($data['data']->requires_special_approval): ?>
                        <div class="flex flex-col gap-1">
                            <span class="font-medium text-sm text-gray-800">Status:</span>
                            <span class="px-3 py-1.5 bg-yellow/20 text-yellow text-xs rounded-md w-fit font-medium">
                                Memerlukan Persetujuan Khusus
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($data['data']->description) && !empty($data['data']->description)): ?>
                        <div class="flex flex-col gap-1">
                            <span class="font-medium text-sm text-gray-800">Deskripsi:</span>
                            <p class="text-sm text-gray-600"><?= $data['data']->description ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Fasilitas jika ada -->
                    <?php if (isset($data['data']->facilities) && !empty($data['data']->facilities)): ?>
                        <div class="flex flex-col gap-2">
                            <span class="font-medium text-sm text-gray-800">Fasilitas:</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach (explode(',', $data['data']->facilities) as $facility): ?>
                                    <span class="px-2 py-1 bg-primary/10 text-primary text-xs rounded-md">
                                        <?= trim($facility) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function formAnggota() {
        const minCapacity = <?= $data['data']->min_capacity ?? 1 ?>;
        const maxCapacity = <?= $data['data']->max_capacity ?>;
        const requiresSpecialApproval = <?= $data['data']->requires_special_approval ? 'true' : 'false' ?>;

        return {
            identifier: '',
            listAnggota: [],
            message: '',

            async tambahAnggota() {
                this.message = '';

                if (this.identifier.trim() === '') {
                    this.message = '* NIM/NIP atau Email tidak boleh kosong';
                    return;
                }

                if (this.listAnggota.length >= maxCapacity) {
                    this.message = `* Maksimal ${maxCapacity} anggota diperbolehkan.`;
                    return;
                }

                const isExist = this.listAnggota.find(anggota =>
                    anggota.id_number === this.identifier ||
                    anggota.id === this.identifier
                );

                if (isExist) {
                    this.message = '* Anggota sudah ditambahkan';
                    return;
                }

                try {
                    const response = await fetch(`<?= URL ?>/admin/booking/search_user/${encodeURIComponent(this.identifier)}`);

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.success) {
                        this.listAnggota.push({
                            id: data.data.id,
                            name: `${data.data.first_name} ${data.data.last_name}`,
                            id_number: this.identifier
                        });
                        this.identifier = '';
                        this.message = '';
                    } else {
                        this.message = data.message || '* Data tidak ditemukan!';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.message = '* Terjadi kesalahan server.';
                }
            },

            deleteAnggota(index) {
                if (index > 0 && index < this.listAnggota.length) {
                    this.listAnggota.splice(index, 1);
                    this.message = '';
                }
            },

            prepareData(event) {
                if (!requiresSpecialApproval) {
                    if (this.listAnggota.length < minCapacity) {
                        event.preventDefault();
                        this.message = `* Minimal ${minCapacity} anggota diperlukan.`;
                        return false;
                    }

                    if (this.listAnggota.length > maxCapacity) {
                        event.preventDefault();
                        this.message = `* Maksimal ${maxCapacity} anggota diperbolehkan.`;
                        return false;
                    }
                }

                return true;
            }
        }
    }
</script>