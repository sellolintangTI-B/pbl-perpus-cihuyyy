<?php

use App\Components\FormInput;
use Carbon\Traits\Options;

if (isset($_SESSION['old'])) {
    $old_data = $_SESSION['old'];
}

?>
<div class="h-full w-full flex justify-center items-center p-4 bg-baseColor rounded-xl">
    <div class="h-full grid gap-8 grid-cols-2">
        <div class="h-full col-span-1">
            <div class="w-full h-full  shadow-md shadow-gray-400 rounded-lg relative overflow-hidden">
                <img src="<?= URL ?>/public/storage/images/login-image.jpg" alt="login image" class="w-full h-full object-cover rounded-lg hidden md:block" />
                <div class="p-2 m-4 w-fit h-fit bg-baseColor/50 absolute z-20 rounded-lg inset-0">
                    <img src="<?= URL ?>/public/storage/logo/logo-simaru-text.svg" alt="Icon" class="h-14" />
                </div>
            </div>
        </div>
        <div class="h-full col-span-1 overflow-y-auto p-8">
            <div class="w-full">
                <h1 class="text-3xl font-poppins text-center font-medium mb-8 text-primary">
                    Register
                </h1>
                <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4" id="form_register" action="<?= URL ?>/auth/register/signup" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(id: 'id_number', placeholder: 'masukkan NIM/NIP', name: 'id_number', label: 'NIM/NIP', required: true, value: $old_data['id_number'] ?? '');
                    FormInput::input(id: 'email', placeholder: 'masukkan email', name: 'email', type: 'email', label: 'Email', required: true, value: $old_data['email'] ?? '');
                    FormInput::input(id: 'first_name', placeholder: 'masukkan nama depan', name: 'first_name', label: 'Nama Depan', required: true, value: $old_data['first_name'] ?? '');
                    FormInput::input(id: 'last_name', placeholder: 'masukkan nama belakang', name: 'last_name', label: 'Nama Belakang', value: $old_data['last_name'] ?? '');
                    FormInput::select(
                        id: 'jurusan',
                        name: 'jurusan',
                        label: 'Jurusan',
                        required: true,
                    );

                    FormInput::select(
                        id: 'prodi',
                        name: 'prodi',
                        label: 'Program Studi',
                        required: true,
                    );
                    FormInput::input(id: 'phone_number', placeholder: 'masukkan nomor whatsapp', name: 'phone_number', type: 'tel', label: 'Nomor Whatsapp', required: true, value: $old_data['phone_number'] ?? '');
                    FormInput::select(
                        id: 'role',
                        name: 'role',
                        label: 'Jenis Civitas',
                        required: true,
                        placeholder: "Role",
                        value: $old_data['role'] ?? '',
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
                    FormInput::input(id: 'password', placeholder: 'masukkan password', name: 'password', type: 'password', label: 'Password', required: true);
                    FormInput::input(id: 'password_confirmation', placeholder: 'masukkan password', name: 'password_confirmation', type: 'password', label: 'Konfirmasi Password', required: true);
                    ?>
                    <div class="sm:col-span-2 px-4">
                        <ul class="text-xs text-start list-disc hidden" id="text_alert">

                        </ul>
                        <ul class="text-xs text-start list-disc hidden" id="match_alert">

                        </ul>
                    </div>
                    <?php
                    FormInput::fileInput(
                        id: 'file_upload',
                        name: 'file_upload',
                        label: 'Upload Screenshot Profil Aplikasi \'Kubaca PNJ\'',
                        required: true,
                        classGlobal: 'sm:col-span-2',
                        accept: 'image/*',
                        value: $old_data['image'] ?? ''
                    );
                    ?>
                    <!-- CAPTCHA Section -->
                    <div class="w-full col-span-2">
                        <label class="block text-primary mb-2 font-poppins font-medium">
                            Kode verifikasi
                        </label>
                        <div class="flex gap-3 items-center mb-2">
                            <img id="captcha-image"
                                src="<?= URL ?>/public/validator/captcha.php"
                                alt="CAPTCHA Code"
                                class="border-2 border-primary rounded-md shadow-sm bg-white"
                                style="height: 50px; width: 200px;" />
                        </div>
                        <?php
                        FormInput::input(
                            id: 'captcha',
                            name: 'captcha',
                            type: 'text',
                            label: '',
                            required: true,
                            placeholder: "Masukkan kode di atas",
                            classGlobal: "w-full"
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
<script src="<?= URL ?>/public/js/select-jurusan.js" defer></script>
<script type="module" src="<?= URL ?>/public/js/password-validator.js" defer></script>