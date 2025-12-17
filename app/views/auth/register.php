<?php

use App\Components\Button;
use App\Components\FormInput;
use Carbon\Traits\Options;

if (isset($_SESSION['register_old'])) {
    $old_data = $_SESSION['register_old'];
}
?>

<div class="h-screen w-full md:bg-primary md:p-4">
    <div class="h-full w-full flex justify-center items-center md:p-4 md:bg-baseColor md:rounded-xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-0 md:gap-8 w-full h-full relative">
            <!-- Image Section -->
            <div class="col-span-1 h-full relative md:static">
                <div class="w-full h-full md:shadow-md shadow-gray-400 md:rounded-lg relative overflow-hidden">
                    <img src="<?= URL ?>/public/storage/images/login-image.jpg"
                        alt="login image"
                        class="w-full h-full object-cover md:rounded-lg" />
                    <div class="p-2 m-4 md:m-4 w-fit h-fit bg-primary/40 absolute top-0 left-1/2 md:left-0 -translate-x-1/2 md:translate-x-0 rounded-lg z-20">
                        <img src="<?= URL ?>/public/storage/logo/logo-simaru-mixed-text.svg"
                            alt="Icon"
                            class="h-16 md:h-14" />
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="col-span-1 bg-white rounded-t-4xl md:bg-transparent z-20 md:z-0 absolute md:static bottom-0 left-0 right-0 md:rounded-none shadow-2xl md:shadow-none overflow-y-auto no-scrollbar md:show-scrollbar transition-all duration-300"
                x-data="{ scrolled: false }"
                @scroll="scrolled = $el.scrollTop > 0"
                :class="scrolled ? 'max-h-[80vh] h-[80vh] md:max-h-full md:h-full' : 'max-h-[60vh] h-[60vh] md:max-h-full md:h-full'">
                <div class="h-full w-full p-6 md:p-8">
                    <div class="w-full md:max-w-none mx-auto">
                        <div class="mb-6 md:mb-8 flex flex-col gap-2">
                            <h1 class="text-2xl md:text-3xl font-poppins font-medium  text-primary">
                                Halo pengguna baru!
                            </h1>
                            <p class="text-gray-600">
                                Masukkan data diri anda melalui form dibawah ini untuk mendaftar.
                            </p>
                        </div>
                        <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4"
                            id="form_register"
                            action="<?= URL ?>/auth/register/signup"
                            method="post"
                            enctype="multipart/form-data">
                            <?php
                            FormInput::input(
                                id: 'id_number',
                                placeholder: 'Masukkan NIM/NIP',
                                name: 'id_number',
                                label: 'NIM/NIP',
                                required: true,
                                value: $old_data['id_number'] ?? ''
                            );

                            FormInput::input(
                                id: 'email',
                                placeholder: 'Masukkan email kampus',
                                name: 'email',
                                type: 'email',
                                label: 'Email',
                                required: true,
                                value: $old_data['email'] ?? ''
                            );

                            FormInput::input(
                                id: 'first_name',
                                placeholder: 'Masukkan nama depan',
                                name: 'first_name',
                                label: 'Nama Depan',
                                required: true,
                                value: $old_data['first_name'] ?? ''
                            );

                            FormInput::input(
                                id: 'last_name',
                                placeholder: 'Masukkan nama belakang',
                                name: 'last_name',
                                label: 'Nama Belakang',
                                value: $old_data['last_name'] ?? ''
                            );

                            FormInput::select(
                                id: 'jurusan',
                                name: 'jurusan',
                                label: 'Jurusan',
                                placeholder: 'Pilih Jurusan',
                                required: true,
                            );

                            FormInput::select(
                                id: 'prodi',
                                name: 'prodi',
                                label: 'Program Studi',
                                placeholder: 'Pilih Jurusan terlebih dahulu',
                                required: true,
                            );

                            FormInput::input(
                                id: 'phone_number',
                                placeholder: 'Masukkan nomor whatsapp',
                                name: 'phone_number',
                                type: 'tel',
                                label: 'Nomor Whatsapp',
                                required: true,
                                value: $old_data['phone_number'] ?? ''
                            );

                            FormInput::select(
                                id: 'role',
                                name: 'role',
                                label: 'Jenis Civitas',
                                required: true,
                                placeholder: "Pilih Jenis Civitas",
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

                            FormInput::input(
                                id: 'password',
                                placeholder: 'Masukkan password',
                                name: 'password',
                                type: 'password',
                                label: 'Password',
                                required: true
                            );

                            FormInput::input(
                                id: 'password_confirmation',
                                placeholder: 'Konfirmasi password',
                                name: 'password_confirmation',
                                type: 'password',
                                label: 'Konfirmasi Password',
                                required: true
                            );
                            ?>

                            <!-- Password Alerts -->
                            <div class="sm:col-span-2 px-4">
                                <ul class="text-xs text-start list-disc hidden text-red" id="text_alert"></ul>
                                <ul class="text-xs text-start list-disc hidden text-red" id="match_alert"></ul>
                            </div>

                            <!-- File Upload -->
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
                            <div class="cf-turnstile sm:col-span-2" data-sitekey="<?= $_ENV['TURNSTILE_SITEKEY'] ?>" data-size="flexible" data-theme="light"></div>

                            <!-- Submit Button -->
                            <div class="sm:col-span-2 mt-4">
                                <?= Button::button(label: 'Register', type: 'submit', class: 'px-4 py-2.5 rounded-full! shadow-none! w-full') ?>
                            </div>
                        </form>

                        <!-- Login Link -->
                        <div class="w-full text-xs md:text-sm flex justify-center items-center gap-2 mt-6 md:mt-8 pb-32">
                            <p class="text-primary">Sudah punya akun?</p>
                            <a class="text-secondary cursor-pointer hover:underline font-medium"
                                href="<?= URL ?>/auth/login/index">
                                Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= URL ?>/public/js/select-jurusan.js"></script>
<script type="module" src="<?= URL ?>/public/js/password-validator.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dbJurusan = "<?= $old_data['major'] ?? "" ?>";
        const dbProdi = "<?= $old_data['study_program'] ?? "" ?>";

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