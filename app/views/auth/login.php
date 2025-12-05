<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\icon\Icon;
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
            <div class="col-span-1 bg-white rounded-t-4xl md:bg-transparent z-20 md:z-0 absolute md:static bottom-0 left-0 right-0 md:rounded-none shadow-2xl md:shadow-none max-h-[65vh] md:max-h-full h-[65vh] md:h-full">
                <div class="h-full w-full overflow-y-auto no-scrollbar md:overflow-y-auto p-6 md:p-8">
                    <div class="w-full md:max-w-md mx-auto flex flex-col justify-start md:justify-center md:min-h-full">
                        <h1 class="text-2xl md:text-3xl font-poppins text-center font-medium mb-6 md:mb-8 text-primary">
                            Login
                        </h1>

                        <form class="w-full flex flex-col gap-4"
                            action="<?= URL ?>/auth/login/signin"
                            method="post"
                            enctype="multipart/form-data">
                            <?php
                            FormInput::input(
                                id: 'username',
                                name: 'username',
                                type: 'text',
                                label: 'Username',
                                required: true,
                                value: $_COOKIE['remember_username'] ?? "",
                                placeholder: "Masukkan email atau NIM/NIP"
                            );

                            FormInput::input(
                                id: 'password',
                                name: 'password',
                                type: 'password',
                                label: 'Password',
                                required: true,
                                placeholder: "Masukkan password"
                            );
                            ?>
                            <div class="cf-turnstile" data-sitekey="<?= $_ENV['TURNSTILE_SITEKEY'] ?>" data-size="flexible" data-theme="light"></div>
                            <!-- CAPTCHA Section -->

                            <!-- Remember Me & Forgot Password -->
                            <div class="w-full text-xs md:text-sm flex justify-between items-center text-primary">
                                <div class="flex gap-2 md:gap-4 items-center">
                                    <input type="checkbox"
                                        id="remember_me"
                                        name="remember_me"
                                        value="true"
                                        <?= isset($_COOKIE['remember_username']) ? 'checked' : '' ?>
                                        class="w-4 h-4 bg-primary active:bg-primary cursor-pointer text-primary rounded" />
                                    <label for="remember_me" class="cursor-pointer">Remember username</label>
                                </div>
                                <a class="cursor-pointer hover:underline">
                                    Forgot Password?
                                </a>
                            </div>

                            <!-- Login Button -->
                            <?= Button::button(label: 'Login', type: 'submit', class: 'px-4 py-2.5 rounded-full! shadow-none!') ?>


                            <!-- Register Link -->
                            <div class="w-full text-xs md:text-sm flex justify-center items-center gap-2 mt-4 md:mt-8 pb-6 md:pb-0">
                                <p class="text-primary">Don't have an account?</p>
                                <a class="text-secondary cursor-pointer hover:underline font-medium"
                                    href="<?= URL ?>/auth/register/index">
                                    Register Now
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>