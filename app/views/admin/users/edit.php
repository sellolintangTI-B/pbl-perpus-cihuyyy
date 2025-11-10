<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;

$options = [
    [
        "display" => "Teknik Sipil",
        "value" => "Teknik Sipil"
    ],
    [
        "display" => "Teknik Mesin",
        "value" => "Teknik Mesin"
    ],
    [
        "display" => "Teknik Elektro",
        "value" => "Teknik Elektro"
    ],
    [
        "display" => "Teknik Informatika dan Komputer",
        "value" => "Teknik Informatika dan Komputer"
    ],
    [
        "display" => "Akuntansi",
        "value" => "Akuntansi"
    ],
    [
        "display" => "Administrasi Niaga",
        "value" => "Administrasi Niaga"
    ],
    [
        "display" => "Teknik Grafika dan Penerbitan",
        "value" => "Teknik Grafika dan Penerbitan"
    ],
];

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
<div class="w-full h-full flex flex-col items-start justify-start gap-5">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Edit Akun
        </h1>
    </div>

    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full flex-1 border border-gray-200 overflow-hidden flex flex-col items-start justify-start">
        <!-- Back Button -->
        <div class="w-full flex-shrink-0 flex items-center justify-start mb-4">
            <a class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/user/index" ?>">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </a>
        </div>

        <!-- Forms Container -->
        <div class="flex-1 flex flex-col gap-8 w-full overflow-y-auto p-4">
            <!-- Form Data Pengguna -->
            <div class="w-full">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Informasi Pengguna</h2>
                <div class="w-full p-6 shadow-md border border-gray-300 rounded-xl bg-gray-50">
                    <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-6" action="<?= URL ?>/admin/user/update/<?= $data->id ?>" method="post" enctype="multipart/form-data">
                        <?php
                        FormInput::input(
                            id: 'id_number',
                            name: 'id_number',
                            label: 'NIM/NIP',
                            value: $data->id_number,
                            required: false
                        );

                        FormInput::input(
                            id: 'email',
                            name: 'email',
                            type: 'email',
                            label: 'Email',
                            value: $data->email,
                            required: false
                        );

                        FormInput::input(
                            id: 'first_name',
                            name: 'first_name',
                            label: 'Nama Depan',
                            value: $data->first_name,
                            required: false
                        );

                        FormInput::input(
                            id: 'last_name',
                            name: 'last_name',
                            label: 'Nama Belakang',
                            value: $data->last_name ?? ""
                        );

                        FormInput::select(
                            id: 'major',
                            name: 'major',
                            label: 'Jurusan',
                            options: $options,
                            selected: $data->major ?? "",
                            required: false
                        );

                        FormInput::input(
                            id: 'phone_number',
                            name: 'phone_number',
                            type: 'tel',
                            label: 'Nomor Whatsapp',
                            value: $data->phone_number,
                            required: false
                        );

                        FormInput::input(
                            id: 'institution',
                            name: 'institution',
                            label: 'Institusi',
                            value: $data->institution,
                            required: false
                        );

                        FormInput::select(
                            id: 'role',
                            name: 'role',
                            label: 'Jenis Civitas',
                            options: $roleOptions,
                            selected: $data->role,
                            required: false
                        );
                        FormInput::fileInput(
                            id: 'image',
                            name: 'image',
                            label: 'Image',
                            required: false,
                            classGlobal: 'col-span-2'
                        );
                        ?>

                        <div class="sm:col-span-2 mt-4">
                            <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-3 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary transition-all duration-300 font-medium text-baseColor">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Ganti Password -->
            <div class="w-full">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Keamanan Akun</h2>
                <div class="w-full p-6 shadow-md border border-gray-300 rounded-xl bg-gray-50">
                    <form class="w-full grid grid-cols-1 gap-6" action="<?= URL ?>/admin/user/reset_passwod/<?= $data->id ?>" method="post">
                        <?php
                        FormInput::input(
                            id: 'password',
                            name: 'password',
                            type: 'password',
                            label: 'Password Baru',
                            placeholder: 'Masukkan password baru',
                            required: false,
                        );

                        FormInput::input(
                            id: 'password_confirmation',
                            name: 'password_confirmation',
                            type: 'password',
                            label: 'Konfirmasi Password',
                            placeholder: 'Ulangi password baru',
                            required: false
                        );
                        ?>

                        <div class="mt-4">
                            <button type="submit" name="change_password" class="w-full bg-red text-white px-4 py-3 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-red-300 transition-all duration-300 font-medium text-baseColor">
                                Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>