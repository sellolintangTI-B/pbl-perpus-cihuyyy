<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?= URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/theme.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/global.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php

use App\Components\Icon\Icon;
use App\Components\UserNavbar;
use App\Utils\Authentication;

$user = new Authentication;

$navItems = [
    ['icon' => 'home_outlined', 'url' => '/user/room/index', 'start-with' => '/user/room'],
    ['icon' => 'calendar_outlined', 'url' => '/user/booking/index', 'start-with' => '/user/booking'],
    ['icon' => 'question_mark', 'url' => '/user/guide/index', 'start-with' => '/user/guide'],
    ['icon' => 'person_outlined', 'url' => '/user/profile/index', 'start-with' => '/user/profile'],
];
$currentPath = URL . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

?>

<body class="font-poppins">
    <?php include_once 'app/components/response-banner.php'; ?>
    <div x-data="{ 
        scrolled: false,
        init() {
                const container = this.$refs.scrollContainer;
                container.addEventListener('scroll', () => {
                    this.scrolled = container.scrollTop > 20;
                });
            }
        }"
        :class="scrolled ? 'md:p-0!' : 'md:p-2'"
        class="w-full h-screen max-h-full overflow-hidden bg-primary transition-all duration-300 md:p-2 relative" x-cloak>
        <div class="w-full h-full max-h-full overflow-hidden bg-image bg-repeat bg-cover md:rounded-xl relative" :class="scrolled ? 'md:rounded-none!' : 'md:rounded-xl'">
            <div class="absolute inset-0 bg-baseColor/20 backdrop-blur-2xl -z-10 "></div>
            <div class="hidden md:block">
                <?= UserNavbar::main(
                    activeMenu: 'beranda',
                    userName: $user->user['username'] ?? 'ga login yaa?',
                    logoUrl: URL . '/public/assets/logo.png',
                ) ?>
            </div>

            <div x-ref="scrollContainer" class="w-full h-full max-h-full overflow-y-auto ">
                <div>
                    <?= $content ?>
                    <?php include __DIR__ . '/Footer.php'; ?>
                </div>
            </div>
        </div>
        <!-- mobile navbar -->
        <div class="w-full h-fit bg-primary fixed inset-0  mt-auto px-4 pt-4 md:hidden z-50">
            <div class="h-fit w-full flex items-center justify-between gap-2 px-6">
                <?php
                foreach ($navItems as $item):
                    $isActive = str_contains($currentPath,  $item['start-with']);
                ?>
                    <div class="flex flex-col items-center justify-center">
                        <a class="h-full p-2  flex items-center justify-center" href="<?= URL . $item['url'] ?>">
                            <?= Icon::{$item['icon']}('w-6 h-6 text-white'); ?>
                        </a>
                        <div class="px-3 h-1 mt-2 rounded-t-lg <?= $isActive ? 'bg-white' : 'bg-none' ?>">

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
<style>
    .bg-image {
        background: url('<?= URL ?>/public/storage/bg-pattern/pattern.webp');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>

</html>