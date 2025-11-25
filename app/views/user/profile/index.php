<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\Badge;
use App\Components\FormInput;
use App\Components\Modal;


$roleOptions = [
    [
        "display" => "Admin",
        "value" => "Admin"
    ],
    [
        "display" => "Mahasiswa",
        "value" => "Mahasiswa"
    ],
    [
        "display" => "Dosen",
        "value" => "Dosen"
    ],
];
?>

<!-- show modal update data akun -->
<?php ob_start() ?>
<div class="w-full flex gap-4">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-3',
        type: 'button',
        alpineClick: "submitUpdateForm()",
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
<?php $updateAccountContent = ob_get_clean() ?>

<!-- show modal ganti password -->
<?php ob_start() ?>
<div class="flex gap-4 w-full">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-3',
        alpineClick: "submitPasswordForm()",
        type: 'button',
        color: 'red',
    ) ?>
    <?= Button::button(
        label: 'tidak',
        type: 'button',
        alpineClick: 'updatePasswordAlert = false',
        class: 'w-full py-3',
        color: 'white',
    ) ?>
</div>
<?php $updatePasswordContent = ob_get_clean() ?>
<div class="w-full h-full">
    <div class="max-w-6xl mx-auto flex flex-col gap-4" x-data="updateUserForm()">
        <h1 class="text-2xl text-black/80 font-medium">
            Tentang Saya
        </h1>
        <div class="w-full h-56 bg-white rounded-lg shadow-sm shadow-black/40 overflow-hidden relative">
            <div class="h-1/2 bg-linear-120 from-primary to-secondary">

            </div>
            <div class="flex justify-end items-center p-4">
                <?= Badge::badge(label: 'Suspend Point: 1 point', color: 'secondary', class: 'px-2! py-1!') ?>
            </div>
            <div class="absolute p-4 inset-0 left-18 flex flex-col items-start justify-start gap-4">
                <div class="flex flex-col items-center gap-2">
                    <div class="h-28 w-28 rounded-full bg-white p-1">
                        <div class="h-full w-full rounded-full bg-black"></div>
                    </div>
                    <h1 class="text-xl font-medium text-primary">
                        Nugroho Nur Cahyo
                    </h1>
                    <p class="text-gray-700">
                        Mahasiswa
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col gap-4 p-6 h-fit bg-white rounded-lg shadow-sm shadow-black/40 overflow-hidden relative">
            <div class="flex justify-between items-center ">
                <h1 class="text-2xl font-medium text-black/80">
                    Data Pribadi
                </h1>
                <button
                    @click="toggleEdit()"
                    class=" text-baseColor px-3 py-1 rounded-full flex gap-2 items-center justify-center border-2  transition-all duration-500 shadow-md shadow-black/25 font-medium cursor-pointer" :class="isEdit?'bg-red border-red hover:text-red hover:bg-red/5':'bg-primary border-primary hover:text-primary hover:bg-primary/5'">
                    <div class=" gap-2 items-center" :class="isEdit?'hidden':'flex'">
                        <?= Icon::pencil('w-5 h-5') ?>
                        Edit Profile
                    </div>
                    <div class=" gap-2 items-center" :class="isEdit?'flex':'hidden'">
                        <?= Icon::cross('w-3 h-3') ?>
                        Batal
                    </div>
                </button>
            </div>
            <form
                id="updateUserForm"
                class="w-full grid grid-cols-1 sm:grid-cols-2 gap-6"
                @submit.prevent="validateAndShowUpdateAlert"
                action="<?= URL ?>/admin/user/update/?"
                method="post"
                enctype="multipart/form-data">
                <?php
                FormInput::input(
                    id: 'first_name',
                    name: 'first_name',
                    label: 'Nama Depan',
                    // value: $data->first_name,
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'last_name',
                    name: 'last_name',
                    label: 'Nama Belakang',
                    alpine_disabled: '!isEdit'
                    // value: $data->last_name ?? ""
                );

                FormInput::input(
                    id: 'id_number',
                    name: 'id_number',
                    label: 'NIM/NIP',
                    // value: $data->id_number,
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'email',
                    name: 'email',
                    type: 'email',
                    label: 'Email',
                    // value: $data->email,
                    required: true,
                    alpine_disabled: '!isEdit'
                );
                FormInput::select(
                    id: 'jurusan',
                    name: 'major',
                    label: 'Jurusan',
                    required: true,
                    alpine_disabled: '!isEdit'
                    // value: $data->major
                );
                FormInput::select(
                    id: 'prodi',
                    name: 'study_program',
                    label: 'Program Studi',
                    placeholder: 'Pilih Jurusan terlebih dahulu',
                    required: true,
                    // value: $data->study_program,
                    // options: []
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'phone_number',
                    name: 'phone_number',
                    type: 'tel',
                    label: 'Nomor Whatsapp',
                    // value: $data->phone_number,
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'institution',
                    name: 'institution',
                    label: 'Institusi',
                    // value: $data->institution,
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::select(
                    id: 'role',
                    name: 'role',
                    label: 'Jenis Civitas',
                    options: $roleOptions,
                    // selected: $data->role,
                    required: true,
                    alpine_disabled: '!isEdit'
                );
                FormInput::select(
                    id: 'status',
                    name: 'status',
                    label: 'Status',
                    options: [
                        ["display" => "Aktif", "value" => 1],
                        ["display" => "Inactive", "value" => 0]
                    ],
                    // selected: $data->is_active,
                    required: true,
                    alpine_disabled: '!isEdit'
                );
                FormInput::fileInput(
                    id: 'image',
                    name: 'image',
                    label: 'Image',
                    required: false,
                    classGlobal: 'col-span-2',
                    alpine_disabled: '!isEdit'
                );
                ?>

                <div class="sm:col-span-2 mt-4" x-show="isEdit">
                    <button
                        type="submit"
                        class="w-full bg-primary text-white px-4 py-3 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary transition-all duration-300 font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <!-- Form Ganti Password -->
        <div class=" w-full flex flex-col gap-4 p-6 h-fit bg-white rounded-lg shadow-sm shadow-black/40 overflow-hidden relative">
            <h2 class="text-2xl font-medium text-gray-800 mb-4">Keamanan Akun</h2>
            <form
                id="updatePasswordForm"
                class="w-full grid grid-cols-1 gap-6"
                @submit.prevent="validateAndShowPasswordAlert"
                action="<?= URL ?>/admin/user/reset_password/?"
                method="post">
                <?php
                FormInput::input(
                    id: 'password',
                    name: 'password',
                    type: 'password',
                    label: 'Password Baru',
                    placeholder: 'Masukkan password baru',
                    required: true,
                );

                FormInput::input(
                    id: 'password_confirmation',
                    name: 'password_confirmation',
                    type: 'password',
                    label: 'Konfirmasi Password',
                    placeholder: 'Ulangi password baru',
                    required: true
                );
                ?>

                <div class="mt-4">
                    <?= Button::button(label: 'Ganti Password', class: 'px-4 py-3 w-full', type: 'submit', color: 'red') ?>
                </div>
            </form>
        </div>
        <!-- modal -->
        <?= Modal::render(
            title: 'Yakin ingin menyimpan perubahan?',
            color: 'secondary',
            message: 'Perubahan akan langsung tersimpan di database. Tidak ada riwayat edit, jadi harap berhati-hati.',
            customContent: $updateAccountContent,
            alpineShow: 'updateAlert',
        ) ?>
        <?= Modal::render(
            title: 'Yakin ingin mengubah password?',
            color: 'red',
            message: 'Perubahan password akan langsung diterapkan. Gunakan password yang kuat dan mudah diingat.',
            customContent: $updatePasswordContent,
            alpineShow: 'updatePasswordAlert',
        ) ?>
    </div>
</div>
<script src="<?= URL ?>/public/js/select-jurusan.js"></script>
<script src="<?= URL ?>/public/js/update-user.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dbJurusan = "Administrasi Niaga";
        const dbProdi = "Administrasi Bisnis Terapan";

        if (dbJurusan) {
            setInitialJurusan(dbJurusan);
        }

        if (dbProdi) {
            setTimeout(() => {
                setProdiValue(dbProdi);
            }, 100);
        }
    });
</script>