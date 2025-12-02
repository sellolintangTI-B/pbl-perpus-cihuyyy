<?php

use App\Components\FormInput;
use App\Components\icon\Icon;
?>
<div class="h-full w-full flex justify-center items-center p-4 bg-baseColor rounded-xl">
    <div class="grid grid-cols-2 gap-8 h-full">
        <div class="col-span-1 h-full">
            <div class="w-full h-full  shadow-md shadow-gray-400 rounded-lg relative overflow-hidden">
                <img src="<?= URL ?>/public/storage/images/login-image.jpg" alt="login image" class="w-full h-full object-cover rounded-lg hidden md:block" />
                <div class="p-2 m-4 w-fit h-fit bg-baseColor/50 absolute z-20 rounded-lg inset-0">
                    <img src="<?= URL ?>/public/storage/logo/logo-simaru-text.svg" alt="Icon" class="h-14" />
                </div>
            </div>
        </div>
        <div class="col-span-1 h-full">
            <div class="h-full w-full overflow-y-auto p-8">
                <div class="w-full max-w-md mx-auto flex flex-col justify-center">
                    <h1 class="text-3xl font-medium font-poppins text-primary text-center mb-8">
                        Login
                    </h1>
                    <form class="w-full grid grid-cols-1 gap-4" action="<?= URL ?>/auth/login/signin" method="post" enctype="multipart/form-data">
                        <?php
                        FormInput::input(id: 'username', name: 'username', type: 'text', label: 'username', required: true, value: $_COOKIE['remember_username'] ?? "", placeholder: "Masukkan email atau NIM/NIP anda");
                        FormInput::input(id: 'password', name: 'password', type: 'password', label: 'password', required: true, placeholder: "Masukkan password anda");
                        ?>
                        <!-- CAPTCHA Section -->
                        <div class="w-full">
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
                                placeholder: "Masukkan kode di atas"
                            );
                            ?>
                            <?php if (isset($captcha_error)): ?>
                                <p class="text-red-500 text-sm mt-1">
                                    <?= $captcha_error ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="w-full text-sm flex justify-between col-span-1 text-primary">
                            <div class="flex gap-4 items-center ">
                                <input type="checkbox" id="remember_me" name="remember_me" value="true" <?= isset($_COOKIE['remember_username']) ? 'checked' : '' ?> class="w-4 h-4 bg-primary active:bg-primary cursor-pointer text-primary " />
                                <p>remember username</p>
                            </div>
                            <a class="cursor-pointer">
                                Forgot Password?
                            </a>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-md cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                            Login
                        </button>
                        <div class="w-full text-sm flex justify-center items-center gap-2 col-span-1 mt-8">
                            <p class="text-primary">Don't have an account?</p>
                            <a class="text-secondary cursor-pointer" href="<?= URL ?>/auth/register/index">
                                Register Now
                            </a>
                        </div>
                        <div class="w-3/4 h-px bg-secondary-40 rounded-full mx-auto">

                        </div>
                        <!-- <div class="flex flex-col gap-2 items-center justify-center text-sm text-primary">
                        <a class="w-12 h-12 flex items-center justify-center shadow-md bg-white text-primary text-xl cursor-pointer rounded-full" href='<?= URL ?>/guest'>
                            <?php Icon::person(); ?>
                        </a>
                        <p>
                            Guest mode
                        </p>
                    </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>