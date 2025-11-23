<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;
use App\Components\Modal;
use App\Components\Button;
?>
<!-- button action modal simpan perubahan -->
<?php ob_start() ?>
<div class="w-full flex gap-4">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-3',
        type: 'submit',
        alpineClick: 'submitUpdateForm()',
        color: 'secondary',
    ) ?>
    <?= Button::button(
        label: 'tidak',
        type: 'button',
        alpineClick: 'updateAlert = false',
        class: 'w-full py-3',
        color: 'white',
    ) ?>
</div>
<?php $updateRoomContent = ob_get_clean() ?>
<div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Edit Ruangan
        </h1>
    </div>
    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center">
        <div class="w-full h-10 flex items-center justify-start">
            <a class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/room/index" ?>">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </a>
        </div>

        <div class="flex-1 w-full overflow-y-auto">
            <div class="flex items-center justify-center  w-full max-w-5xl mx-auto">
                <form class="w-full max-w-3xl grid grid-cols-1 sm:grid-cols-2 gap-6" id="updateRoomForm" x-data="updateRoomForm()" @submit.prevent="validateAndShowUpdateAlert" action="<?= URL . "/admin/room/update/" . $data->id ?>" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(id: 'nama', name: 'name', label: 'Nama', placeholder: "masukkan nama ruangan", required: true, value: $data->name);
                    FormInput::input(id: 'lantai', name: 'floor', type: 'number', label: 'Lantai', placeholder: "contoh: 1", required: true, value: $data->floor);
                    FormInput::input(id: 'kapasitas_minimal', name: 'min', type: 'number', label: 'Kapasitas Minimal', placeholder: 'contoh: 2', required: true, value: $data->min_capacity);
                    FormInput::input(id: 'kapasitas_maximal', name: 'max', type: 'number', label: 'Kapasitas Maximal', placeholder: 'contoh: 4',  required: true, value: $data->max_capacity);
                    ?>
                    <div class="sm:col-span-2 mt-4">
                        <?php
                        FormInput::fileInput(
                            id: 'file_upload',
                            name: 'file_upload',
                            label: 'Upload foto ruangan',
                            classGlobal: 'sm:col-span-2',
                            accept: 'image/*',
                        );
                        ?>
                    </div>
                    <div class="sm:col-span-2 mt-4">
                        <?php
                        FormInput::textarea(
                            id: 'deskripsi',
                            name: 'description',
                            label: 'Deskripsi',
                            placeholder: "masukkan deskripsi ruangan",
                            required: true,
                            rows: 4,
                            value: $data->description
                        );
                        ?>
                    </div>
                    <?php
                    FormInput::checkbox(id: 'jenis_ruangan', name: 'isSpecial', label: 'Ruangan special', checked: $data->requires_special_approval == 1);
                    FormInput::checkbox(id: 'isOperational', name: 'isOperational', label: 'Ruangan Beroperasi', checked: $data->is_operational == 1);
                    ?>
                    <div class="sm:col-span-2 mt-4">
                        <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                            Simpan Perubahan
                        </button>
                    </div>
                    <!-- modal -->
                    <?= Modal::render(
                        title: 'Yakin ingin menyimpan perubahan?',
                        color: 'secondary',
                        message: 'Perubahan akan langsung tersimpan di database. Tidak ada riwayat edit, jadi harap berhati-hati.',
                        customContent: $updateRoomContent,
                        alpineShow: 'updateAlert',
                    ) ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function updateRoomForm() {
        return {
            updateAlert: false,
            validateAndShowUpdateAlert(event) {
                const form = event.target;
                if (form.checkValidity()) {
                    this.updateAlert = true;
                } else {
                    form.reportValidity();
                }
            },

            submitUpdateForm() {
                document.getElementById('updateRoomForm').submit();
            },
        }
    }
</script>