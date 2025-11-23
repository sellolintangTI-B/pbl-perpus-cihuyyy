<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\FormInput;
?>

<div class="flex-1 w-full overflow-y-auto">
    <div class="flex items-center justify-center w-full max-w-5xl mx-auto">
        <form
            class="w-full max-w-3xl flex flex-col gap-2"
            action="<?= URL ?>/admin/booking/store/<?= $data['data']->id ?>"
            method="post"
            enctype="multipart/form-data"
            x-data="formAnggota()"
            @submit="prepareData($event)">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 bg-white rounded-xl border border-gray-400">
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
                    classGlobal: 'sm:col-span-2',
                    readonly: true
                );

                FormInput::input(
                    id: 'datetime',
                    name: 'datetime',
                    type: 'date',
                    label: 'Tanggal Peminjaman',
                    placeholder: 'Masukkan tanggal peminjaman',
                    required: true,
                    classGlobal: 'sm:col-span-2'
                );

                FormInput::input(
                    id: 'start_time',
                    name: 'start_time',
                    type: 'time',
                    label: 'Waktu Mulai',
                    placeholder: 'Masukkan jam mulai peminjaman',
                    required: true
                );

                FormInput::input(
                    id: 'end_time',
                    name: 'end_time',
                    type: 'time',
                    label: 'Waktu Berakhir',
                    placeholder: 'Masukkan jam peminjaman berakhir',
                    required: true
                );
                ?>

                <?php if ($data['data']->requires_special_approval): ?>
                    <!-- Special Approval: File Upload -->
                    <div class="sm:col-span-2 mt-4">
                        <?php
                        FormInput::fileInput(
                            id: 'file_upload',
                            name: 'file',
                            label: 'Upload Surat Peminjaman',
                            required: true,
                            classGlobal: 'sm:col-span-2',
                            accept: 'image/*'
                        );
                        ?>
                    </div>
                <?php else: ?>
                    <!-- Regular Booking: Members List -->
                    <div class="sm:col-span-2">
                        <label class="block text-xl text-primary mb-4">Anggota</label>
                        <div class="flex flex-col gap-2 items-start">
                            <!-- List of Added Members -->
                            <template x-for="(anggota, index) in listAnggota" :key="index">
                                <div class="flex items-center justify-between w-full">
                                    <span
                                        x-text="`${index + 1}. ${anggota.name} (${index === 0 ? 'PJ' : 'Partisipan'})`"
                                        class="text-gray-700 text-sm">
                                    </span>
                                    <button
                                        type="button"
                                        @click="deleteAnggota(index)"
                                        class="text-red-500 text-xs hover:underline"
                                        x-show="index !== 0">
                                        hapus
                                    </button>
                                </div>
                            </template>

                            <!-- Add Member Input -->
                            <div class="w-full flex items-center justify-center h-12 gap-2 mt-12">
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
                                    btn_icon_size: 'w-4 h-4',
                                    alpineClick: 'tambahAnggota()'
                                )
                                ?>
                            </div>

                            <!-- Error Message -->
                            <p x-show="message" x-text="message" class="text-xs text-red-500 mt-1"></p>

                            <!-- Hidden Input for PHP Submission -->
                            <input type="hidden" name="list_anggota" :value="JSON.stringify(listAnggota)">
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="sm:col-span-2 mt-4">
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