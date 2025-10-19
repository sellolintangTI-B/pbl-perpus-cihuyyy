<?php
require_once 'app/components/form-input.php'
?>
<div class="h-screen w-full  flex justify-center items-center p-4">
    <div class="max-w-6xl h-[90vh] w-full flex items-center justify-center">
        <div class=" w-full h-full bg-gray-500">

        </div>
        <div class="h-full w-full overflow-y-auto px-8 py-6 bg-white border ">
            <div class="w-full h-full max-w-md mx-auto flex flex-col justify-center">
                <h1 class="text-3xl font-poppins text-center mb-8">
                    Login
                </h1>
                <form class="w-full grid grid-cols-1 gap-4" action="<?= URL ?>/auth/signin" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(id: 'username', name: 'username', type: 'text', label: 'username', required: false, placeholder: "Masukkan email atau NIM/NIP anda");
                    FormInput::input(id: 'password', name: 'password', type: 'password', label: 'password', required: false, placeholder: "Masukkan password anda");
                    ?>
                    <div class="w-full text-sm flex justify-between col-span-1">
                        <div class="flex gap-4 ">
                            <input type="checkbox" id="remember_me" name="remember_me" value="true" />
                            <p>remember me</p>
                        </div>
                        <a>
                            Forgot Password?
                        </a>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition font-medium">
                        Login
                    </button>
                    <div class="w-full text-sm flex justify-center items-center gap-2 col-span-1 mt-8">
                        <p>Don't have an account?</p>
                        <a class="text-blue-500 cursor-pointer" href="/auth/register">
                            Register Now
                        </a>
                    </div>
                    <div class="flex flex-col gap-6 mt-8 items-center justify-center text-sm">
                        <p>
                            are you guest?
                        </p>
                        <a class="w-8 h-8 flex items-center justify-center border border-black text-xl">
                            X
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>