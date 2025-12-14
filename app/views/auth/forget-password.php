<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\icon\Icon;
?>

<div class="h-screen w-full md:bg-primary md:p-4">
    <div class="h-full w-full flex justify-center items-center md:p-4 bg-white md:rounded-xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-0 md:gap-8 w-full h-full relative">
            <!-- Form Section -->
            <div class="col-span-1 bg-white md:bg-transparent w-full h-full">
                <div class="h-full w-full overflow-y-auto no-scrollbar p-6 md:p-8">
                    <div class="w-full md:max-w-lg mx-auto flex flex-col justify-center h-full">
                        <h1 class="text-2xl md:text-3xl font-poppins font-semibold mb-3 md:mb-4 text-primary">
                            Lupa password?
                        </h1>

                        <p class="text-sm md:text-base text-gray-500 mb-8 md:mb-10 leading-relaxed">
                            Jangan Khawatir. Kami akan membantu dengan mengirimkan anda link untuk membuat password baru.
                        </p>

                        <form class="w-full flex flex-col gap-4"
                            action="<?= URL ?>/auth/password/send_token"
                            method="post"
                            enctype="multipart/form-data">

                            <div class="flex flex-col md:flex-row gap-3 w-full">
                                <?php
                                FormInput::input(
                                    id: 'email',
                                    name: 'email',
                                    type: 'email',
                                    required: true,
                                    placeholder: "Masukkan  email",
                                    classGlobal: 'w-full'
                                );
                                ?>
                                <?= Button::button(
                                    label: 'Reset Password',
                                    type: 'submit',
                                    class: 'px-3 py-2.5 rounded-lg! shadow-none! w-full md:w-auto whitespace-nowrap'
                                ) ?>
                            </div>

                            <!-- Back to Login Link -->
                            <div class="w-full text-xs md:text-sm flex justify-start items-center gap-2 mt-4 md:mt-8">
                                <p class="text-primary">Sudah ingat password mu?</p>
                                <a class="text-secondary cursor-pointer hover:underline font-medium"
                                    href="<?= URL ?>/auth/login">
                                    Kembali Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Image Section - Hidden on Mobile -->
            <div class="hidden md:flex col-span-1 h-full relative overflow-hidden items-center justify-center">
                <img src="<?= URL ?>/public/storage/images/forgot-password-image.png"
                    alt="forgot password image"
                    class="w-3/4 object-contain md:rounded-lg" />
            </div>
        </div>
    </div>
</div>