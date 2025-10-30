<?php

use App\Components\FormInput;
use App\Components\icon\Icon;

?>
<div class="h-screen w-full  flex justify-center items-center p-4 bg-[#FAFAFA]">
    <div class="max-w-7xl h-[90vh] w-full flex items-center justify-center overflow-hidden rounded-xl shadow-md shadow-gray-400 bg-white/20 p-6">
        <div class="w-full h-full  shadow-md shadow-gray-400 rounded-lg">
            <img src="<?=URL?>/public/storage/images/login-image.jpg" alt="login image" class="w-full h-full object-cover rounded-lg hidden md:block"/>
        </div>
        <div class="h-full w-full overflow-y-auto px-8 py-6 ">
            <div class="w-full h-full max-w-md mx-auto flex flex-col justify-center">
                <h1 class="text-3xl font-medium font-poppins text-primary text-center mb-8">
                    Login
                </h1>
                <form class="w-full grid grid-cols-1 gap-4" action="<?= URL ?>/auth/login/signin" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(id: 'username', name: 'username', type: 'text', label: 'username', required: false, placeholder: "Masukkan email atau NIM/NIP anda");
                    FormInput::input(id: 'password', name: 'password', type: 'password', label: 'password', required: false, placeholder: "Masukkan password anda");
                    ?>
                    <div class="w-full text-sm flex justify-between col-span-1 text-primary">
                        <div class="flex gap-4 items-center ">
                            <input type="checkbox" id="remember_me" name="remember_me" value="true" class="w-4 h-4 bg-primary active:bg-primary cursor-pointer text-primary " />
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
                        <a class="text-secondary cursor-pointer" href="<?=URL?>/auth/register/index">
                            Register Now
                        </a>
                    </div>
                    <div class="w-3/4 h-px bg-secondary-40 rounded-full mx-auto">

                    </div>
                    <div class="flex flex-col gap-2 items-center justify-center text-sm text-primary">
                        <a class="w-12 h-12 flex items-center justify-center shadow-md bg-white text-primary text-xl cursor-pointer rounded-full"  href='<?=URL?>/guest'>
                            <?php Icon::person(); ?>
                        </a>
                        <p>
                            Guest mode
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>