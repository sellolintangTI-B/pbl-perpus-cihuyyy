<?php

use App\Components\Icon\Icon;
use app\Components\UserNavbar;
use App\Components\Modal;

$navItems = [
    ['label' => 'Beranda', 'url' => '/user/room/index', 'start-with' => '/user/room'],
    ['label' => 'Booking', 'url' => '/user/booking/index', 'start-with' => '/user/booking'],
    ['label' => 'Panduan', 'url' => '/user/guide/index', 'start-with' => '/user/guide']
];

$currentPath = URL . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<div class="w-full" x-data="{logoutAlert: false}">
    <nav class="w-full py-4 px-8 transition-all duration-300" x-data="{ profileOpen: false }" x-bind:class="scrolled ? 'bg-primary' : 'bg-baseColor'" x-cloak>
        <div class="w-full flex items-center justify-between">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <img :src="scrolled ? '<?= URL ?>/public/storage/logo/logo-simaru-text-white.svg' : '<?= URL ?>/public/storage/logo/logo-simaru-text.svg'" alt="Simaru Logo" class="h-12 object-cover transition-all duration-300">
            </div>

            <!-- Navigation Menu -->
            <div class="flex items-center gap-2">
                <?php
                foreach ($navItems as $item):
                    $isActive = str_contains($currentPath,  $item['start-with']);
                ?>
                    <?= UserNavbar::navLink(label: $item['label'], href: URL . $item['url'], active: $isActive) ?>
                <?php endforeach; ?>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button @click="profileOpen = !profileOpen"
                    class="flex items-center gap-2 px-4 py-2 rounded-full border transition-all duration-300"
                    :class="scrolled ? 'border-white/30 bg-white/10 hover:bg-white/20' : 'border-gray-300 bg-white hover:border-primary'">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center transition-colors duration-300"
                        :class="scrolled ? 'bg-white/20' : 'bg-primary/10'">
                        <span :class="scrolled ? 'text-white' : 'text-primary'">
                            <?= Icon::person('w-4 h-4') ?>
                        </span>
                    </div>
                    <span class="text-sm font-medium transition-colors duration-300"
                        :class="scrolled ? 'text-white' : 'text-black/80'"><?= $userName ?></span>
                    <svg class="w-4 h-4 transition-all duration-300"
                        :class="[scrolled ? 'text-white/80' : 'text-black/60', profileOpen ? 'rotate-180' : '']"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileOpen"
                    @click.away="profileOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    x-cloak
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
                    style="display: none;">
                    <a href="<?= URL . '/user/profile/index' ?>" class="flex items-center gap-3 px-4 py-2 text-sm text-black/80 hover:bg-gray-50 transition-colors duration-200">
                        <?= Icon::person('w-4 h-4') ?>
                        <span>Profile</span>
                    </a>
                    <div class="border-t border-gray-200 my-1"></div>
                    <button class="flex items-center gap-3 px-4 py-2 text-sm text-red hover:bg-red/5 transition-colors duration-200 w-full" @click="logoutAlert = true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>
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