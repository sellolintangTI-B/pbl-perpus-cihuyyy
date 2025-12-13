<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;

$oldUsers = $_SESSION['old_users'] ?? []
?>

<div class="w-full h-full max-h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Akun Pengguna
        </h1>
    </div>
    <div class="p-6 gap-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center">
        <div class="w-full h-10 flex items-center justify-start">
            <button class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" onclick="history.back()">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </button>
        </div>
        <div class="h-full w-full flex-1 overflow-y-auto py-2">
            <form id="CreateForm" class="w-full max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-md grid grid-cols-1 sm:grid-cols-2 gap-6 mx-auto" action=<?= URL . "/admin/user/store" ?> method="post" enctype="multipart/form-data">
                <?php
                // ID Number (NIM/NIP)
                FormInput::input(
                    id: 'id_number',
                    name: 'id_number',
                    label: 'NIM/NIP',
                    placeholder: 'masukkan NIM/NIP',
                    required: true,
                    value: $oldUsers['id_number'] ?? ''
                );

                // Email
                FormInput::input(
                    id: 'email',
                    name: 'email',
                    type: 'email',
                    label: 'Email',
                    placeholder: 'masukkan email',
                    required: true,
                    value: $oldUsers['email'] ?? ''
                );

                // First Name
                FormInput::input(
                    id: 'first_name',
                    name: 'first_name',
                    label: 'Nama Depan',
                    placeholder: 'masukkan nama depan',
                    required: true,
                    value: $oldUsers['first_name'] ?? ''
                );

                // Last Name
                FormInput::input(
                    id: 'last_name',
                    name: 'last_name',
                    label: 'Nama Belakang',
                    placeholder: 'masukkan nama belakang',
                    value: $oldUsers['last_name'] ?? ''
                );
                FormInput::select(
                    id: 'jurusan',
                    name: 'major',
                    label: 'Jurusan',
                    placeholder: 'Jurusan',
                    value: $oldUsers['major'] ?? ''
                );

                FormInput::select(
                    id: 'prodi',
                    name: 'prodi',
                    label: 'Program Studi',
                    placeholder: 'Pilih Jurusan terlebih dahulu',
                    value: $oldUsers['prodi'] ?? ''
                );

                // Phone Number
                FormInput::input(
                    id: 'phone_number',
                    name: 'phone_number',
                    type: 'tel',
                    label: 'Nomor Whatsapp',
                    placeholder: 'masukkan nomor whatsapp',
                    required: true,
                    value: $oldUsers['phone_number'] ?? ''
                );

                // Role (Select)
                FormInput::select(
                    id: 'role',
                    name: 'role',
                    label: 'Jenis Civitas',
                    required: true,
                    placeholder: "Pilih jenis civitas",
                    value: $oldUsers['role'] ?? '',
                    options: [
                        [
                            "display" => "Mahasiswa",
                            "value" => "Mahasiswa"
                        ],
                        [
                            "display" => "Dosen",
                            "value" => "Dosen"
                        ],
                        [
                            "display" => "Admin",
                            "value" => "Admin"
                        ],
                    ]
                );
                FormInput::input(id: 'password', name: 'password', type: 'password', label: 'Password', required: true, placeholder: 'masukkan password');
                FormInput::input(id: 'password_confirmation', name: 'password_confirmation', type: 'password', label: 'Konfirmasi Password', required: true, placeholder: 'masukkan konfirmasi password');
                ?>

                <div class="sm:col-span-2 mt-4">
                    <div class="sm:col-span-2 px-4">
                        <ul class="text-xs text-start list-disc hidden text-red" id="text_alert"></ul>
                        <ul class="text-xs text-start list-disc hidden text-red" id="match_alert"></ul>
                    </div>
                </div>
                <div class="sm:col-span-2 mt-4">
                    <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                        Tambah Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= URL ?>/public/js/select-jurusan.js"></script>
<script src="<?= URL ?>/public/js/password-validator.js"></script>
<script>
    const createForm = document.getElementById("CreateForm")
    if (createForm) {
        createForm.addEventListener('submit', formSubmitCheck);
    }
</script>