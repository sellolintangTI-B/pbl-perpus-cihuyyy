<?php

use App\Components\Button;
use App\Components\icon\Icon;
?>

<div class="h-screen w-full md:bg-primary md:p-4">
    <div class="h-full w-full flex justify-center items-center md:p-4 md:bg-baseColor md:rounded-xl overflow-hidden">
        <div class="w-full h-full flex items-center justify-center p-6">
            <!-- Success Content -->
            <div class="w-full max-w-lg mx-auto text-center">
                <!-- Animated Email Icon -->
                <div class="mb-8 flex justify-center">
                    <div class="relative">
                        <!-- Email Icon -->
                        <div class="email-icon w-32 h-32 bg-tertiary/10 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <!-- Checkmark Badge -->
                        <div class="checkmark-badge absolute -bottom-2 -right-2 w-12 h-12 bg-secondary rounded-full flex items-center justify-center shadow-lg">
                            <svg class="checkmark w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <h1 class="text-2xl md:text-3xl font-poppins font-semibold mb-4 text-primary">
                    Email berhasil dikirim!
                </h1>

                <p class="text-sm md:text-base text-gray-500 mb-8 leading-relaxed px-4">
                    Kami telah mengirimkan tautan untuk mereset kata sandi ke alamat email Anda. Silakan periksa kotak masuk Anda dan ikuti petunjuk untuk membuat kata sandi baru. </p>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3 px-4">
                    <a href="<?= URL ?>/auth/login">
                        <?= Button::button(
                            label: 'Kembali Login',
                            type: 'button',
                            class: 'px-6 py-2.5 rounded-full! shadow-none! w-full'
                        ) ?>
                    </a>

                    <button onclick="window.location.href='mailto:'" class="text-secondary cursor-pointer hover:underline text-sm md:text-base font-medium">
                        Buka aplikasi email
                    </button>
                </div>

                <!-- Additional Help -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs md:text-sm text-gray-400">
                        tidak menerima email? Cek folder spam atau
                        <a href="<?= URL ?>/auth/password/forget" class="text-secondary hover:underline font-medium">
                            coba lagi
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>