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
?>
<div class="w-full h-full max-h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Akun Admin
        </h1>
    </div>
    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center">
        <div class="w-full h-10 flex items-center justify-start">
            <a class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/user/index" ?>">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </a>
        </div>
        <div class="h-full w-full flex-1 overflow-y-auto">
            <form class="w-full max-w-3xl grid grid-cols-1 sm:grid-cols-2 gap-6 mx-auto" action=<?= URL . "/admin/user/store_admin" ?> method="post" enctype="multipart/form-data">
                <?php
                FormInput::input(id: 'id_number', name: 'id_number', label: 'NIM/NIP', required: true);
                FormInput::input(id: 'email', name: 'email', type: 'email', label: 'Email', required: true);
                FormInput::input(id: 'first_name', name: 'first_name', label: 'Nama Depan', required: true);
                FormInput::input(id: 'last_name', name: 'last_name', label: 'Nama Belakang');
                FormInput::select(
                    id: 'jurusan',
                    name: 'jurusan',
                    label: 'Jurusan',
                    placeholder: 'Jurusan',
                    required: true,
                    options: $options
                );
                FormInput::input(id: 'phone_number', name: 'phone_number', type: 'tel', label: 'Nomor Whatsapp', required: true);
                FormInput::input(id: 'password', name: 'password', type: 'password', label: 'Password', required: true);
                FormInput::input(id: 'password_confirmation', name: 'password_confirmation', type: 'password', label: 'Konfirmasi Password', required: true);
                FormInput::select(
                    id: 'role',
                    name: 'role',
                    label: 'Jenis Civitas',
                    required: true,
                    classGlobal: 'sm:col-span-2',
                    placeholder: "Pilih jenis civitas",
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
                ?>
                <div class="sm:col-span-2 mt-4">
                    <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                        Tambah Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>