<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\icon\Icon;
?>

<div class="h-screen w-full md:bg-primary md:p-4">
    <div class="h-full w-full flex justify-center items-center md:p-4 bg-white md:rounded-xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-0 md:gap-8 w-full h-full relative">
            <div class="col-span-1 bg-white md:bg-transparent w-full h-full">
                <div class="h-full w-full overflow-y-auto no-scrollbar p-6 md:p-8">
                    <div class="w-full md:max-w-md mx-auto flex flex-col justify-center h-full">
                        <h1 class="text-2xl md:text-3xl font-poppins font-semibold mb-3 md:mb-4 text-primary">
                            Buat Password Baru
                        </h1>

                        <p class="text-sm md:text-base text-gray-500 mb-8 md:mb-10 leading-relaxed">
                            Pastikan password mudah diingat oleh Anda, namun sulit ditebak oleh orang lain. </p>

                        <form class="w-full flex flex-col gap-4"
                            action="<?= URL ?>/auth/password/update"
                            method="post"
                            enctype="multipart/form-data">

                            <?php
                            FormInput::input(
                                id: 'password',
                                name: 'password',
                                type: 'password',
                                label: 'Password Baru',
                                required: true,
                                placeholder: "Masukkan password baru",
                                classGlobal: 'w-full'
                            );

                            FormInput::input(
                                id: 'password_confirmation',
                                name: 'password_confirmation',
                                type: 'password',
                                label: 'Konfirmasi Password',
                                required: true,
                                placeholder: "Masukkan ulang password baru",
                                classGlobal: 'w-full'
                            );
                            ?>
                            <div class="sm:col-span-2 px-4">
                                <ul class="text-xs text-start list-disc hidden text-red" id="text_alert"></ul>
                                <ul class="text-xs text-start list-disc hidden text-red" id="match_alert"></ul>
                            </div>

                            <?= Button::button(
                                label: 'Reset Password',
                                type: 'submit',
                                class: 'px-6 py-2.5 rounded-lg! shadow-none! w-full'
                            ) ?>
                        </form>
                        <div class="w-full text-xs md:text-sm flex justify-start items-center gap-2 mt-4 md:mt-8">
                            <p class="text-primary">Batal mengganti password?</p>
                            <a class="text-secondary cursor-pointer hover:underline font-medium"
                                href="<?= URL ?>/auth/login">
                                Kembali Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex col-span-1 h-full relative overflow-hidden items-center justify-center">
                <img src="<?= URL ?>/public/storage/images/new-password.png"
                    alt="forgot password image"
                    class="w-3/4 object-contain md:rounded-lg" />
            </div>
        </div>
    </div>
</div>
<script type="module" src="<?= URL ?>/public/js/password-validator.js"></script>