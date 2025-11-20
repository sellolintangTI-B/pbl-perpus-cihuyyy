<?php

use App\Components\Button;
use App\Components\NavThings;
use App\Components\Icon\Icon;
use App\Components\Modal;

use App\Utils\Authentication;

$auth = new Authentication();
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
        <div class="flex items-center justify-center w-full ps-8 flex-col gap-4">
            <div class="w-full p-2 items-center justify-start flex gap-2">
                <div class="rounded-full bg-baseColor/20 p-0.5 w-8 h-8">
                    <img src="<?= URL ?>/public/<?= $auth->user["img_url"] ?? "" ?>" class="w-full h-full object-cover rounded-full" />
                </div>
                <div class="flex-1 break-all">
                    <?= $auth->user["username"] ?>
                </div>
            </div>
            <?=
            Button::button(label: 'Logout', color: 'white', alpineClick: 'logoutAlert = true', icon: 'logout', class: 'w-full py-2 text-sm!')
            ?>
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
        height: 'h-fit',
        class: 'max-w-xl w-full p-8'
    ) ?>
</div>