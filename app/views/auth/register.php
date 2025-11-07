<?php

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
<div class="h-screen w-full  flex justify-center items-center p-4">
    <div class="max-w-7xl h-[90vh] w-full flex items-center justify-center overflow-hidden rounded-xl shadow-md shadow-gray-400 bg-white/20 p-6">
        <div class="w-full h-full bg-[url('/public/storage/images/login-image.jpg')] bg-cover shadow-md shadow-gray-400 rounded-lg">

        </div>
        <div class="h-full w-full overflow-y-auto px-8 py-6 ">
            <div class="w-full">
                <h1 class="text-3xl font-poppins text-center font-medium mb-8 text-primary">
                    Register
                </h1>
                <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4" action="<?= URL ?>/auth/register/signup" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(id: 'id_number', name: 'id_number', label: 'NIM/NIP', required: false);
                    FormInput::input(id: 'email', name: 'email', type: 'email', label: 'Email', required: false);
                    FormInput::input(id: 'first_name', name: 'first_name', label: 'Nama Depan', required: false);
                    FormInput::input(id: 'last_name', name: 'last_name', label: 'Nama Belakang');
                    FormInput::select(
                        id: 'jurusan',
                        name: 'jurusan',
                        label: 'Jurusan',
                        required: false,
                        options: $options
                    );
                    FormInput::input(id: 'phone_number', name: 'phone_number', type: 'tel', label: 'Nomor Whatsapp', required: false);
                    FormInput::input(id: 'password', name: 'password', type: 'password', label: 'Password', required: false);
                    FormInput::input(id: 'password_confirmation', name: 'password_confirmation', type: 'password', label: 'Konfirmasi Password', required: false);

                    FormInput::fileInput(
                        id: 'file_upload',
                        name: 'file_upload',
                        label: 'Upload bukti download \'Kubaca PNJ\'',
                        required: false,
                        classGlobal: 'sm:col-span-2',
                        accept: 'image/*'
                    );

                    FormInput::select(
                        id: 'role',
                        name: 'role',
                        label: 'Jenis Civitas',
                        required: false,
                        classGlobal: 'sm:col-span-2',
                        options: [
                            [
                                "display" => "Mahasiswa",
                                "value" => "Mahasiswa"
                            ],
                            [
                                "display" => "Dosen",
                                "value" => "Dosen"
                            ],
                        ]
                    );
                    ?>
                     <!-- CAPTCHA Section -->
                    <div class="w-full col-span-2">
                        <label class="block text-primary mb-2 font-poppins">
                            Kode Verifikasi
                        </label>
                        <div class="flex gap-3 items-center mb-2">
                            <img id="captcha-image" 
                                 src="<?=URL?>/public/validator/captcha.php" 
                                 alt="CAPTCHA Code" 
                                 class="border-2 border-primary rounded-md shadow-sm bg-white"
                                 style="height: 50px; width: 200px;"/>
                        </div>
                        <?php
                        FormInput::input(
                            id: 'captcha', 
                            name: 'captcha', 
                            type: 'text', 
                            label: '', 
                            required: true, 
                            placeholder: "Masukkan kode di atas",
                            classGlobal:"w-full"
                        );
                        ?>
                        <?php if (isset($captcha_error)): ?>
                            <p class="text-red-500 text-sm mt-1">
                                <?= $captcha_error ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="sm:col-span-2 mt-4">
                        <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-md cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                            Register
                        </button>
                    </div>
                </form>
                <div class="w-full text-sm flex justify-center items-center gap-2 col-span-1 mx-auto mt-8">
                    <p class="text-primary">Already have an account?</p>
                    <a class="text-secondary cursor-pointer" href="<?= URL ?>/auth/login/index">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>