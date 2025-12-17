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
        <div class="flex flex-col gap-4 items-center justify-start w-full h-full">
            <a class="text-2xl font-bold cursor-pointer " href="<?= URL ?>/admin/dashboard">
                <div class="w-full bg-baseColor rounded-xl overflow-hidden flex items-center justify-center">
                    <img src="<?= URL . '/public/storage/logo/logo-simaru-text-primary.svg' ?>" class="w-3/4" />
                </div>
            </a>
            <div class="w-full flex flex-col gap-6 items-center mt-4">
                <?php
                foreach ($items as $item) {
                    $isActive = str_contains($item['url'], $activeItem);
                    NavThings::adminNavLink(active: $isActive, label: $item['label'], icon: $item['icon'], href: URL . $item['url']);
                }
                ?>
            </div>
        </div>
        <div class="flex items-center justify-center w-full ps-4 flex-col gap-4">
            <a class="w-full p-2 items-center justify-start flex gap-2 bg-white/20 rounded-lg cursor-pointer hover:bg-white/40 transition-all duration-300" href="<?= URL . "/admin/profile/index" ?>">
                <div class="rounded-full bg-baseColor/20 p-0.5 w-8 h-8">
                    <img src="<?= URL ?>/public/<?= $auth->user["img_url"] ?? "" ?>"
                        class="w-full h-full object-cover rounded-full"
                        onerror="this.onerror=null; this.src='<?= URL ?>/public/storage/bg-pattern/no-profile.webp';" />
                </div>
                <div class="flex-1 break-all line-clamp-1">
                    <?= $auth->user["username"] ?>
                </div>
            </a>
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
    ) ?>
</div>