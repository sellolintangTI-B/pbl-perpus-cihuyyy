<?php

use App\Components\NavThings;
use App\Components\Icon\Icon;
use App\Components\Modal;
?>
<div class="w-full h-full" x-data="{logoutAlert: false}">
    <div class=" w-full h-full flex flex-col items-center py-8 justify-between text-baseColor">
        <div class="flex flex-col gap-4 items-center justify-center w-full">
            <h1 class="text-2xl font-bold">
                SIMARU
            </h1>
            <div class="w-full flex flex-col gap-6 items-center mt-8">
                <?php
                foreach ($items as $item) {
                    $isActive = ($activeItem == $item['url']);
                    NavThings::adminNavLink(active: $isActive, label: $item['label'], icon: $item['icon'], href: $item['url']);
                }
                ?>
            </div>
        </div>
        <div class="flex items-center justify-center w-full ps-8">
            <button
                class="text-baseColor flex items-center justify-center py-2 gap-4 w-full cursor-pointer rounded-lg hover:bg-baseColor/20 transition-all duration-300 "
                @click="logoutAlert = true">
                <?= Icon::logout("w-6 h-6") ?>
                Logout
            </button>
        </div>
    </div>
    <?= Modal::render(
        title: 'Yakin ingin logout?',
        actionUrl: URL . '/auth/logout/logout',
        color: 'red',
        confirmText: 'Ya',
        cancelText: 'Tidak',
        message: 'Anda akan keluar dari akun ini. Pastikan semua pekerjaan sudah disimpan sebelum logout.',
        method: 'POST',
        alpineShow: 'logoutAlert',
    ) ?>
</div>