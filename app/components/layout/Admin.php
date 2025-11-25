<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?= URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/theme.css" rel="stylesheet">
    <!-- <script src="<?= URL ?>/public/js/alpine.js" defer></script> -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="<?= URL ?>/public/js/modal.js"></script>
</head>
<?php

use App\Components\NavThings;

$items = [
    ['label' => 'Dashboard', 'url' => URL.'/admin/dashboard/index', 'icon' => 'home'],
    ['label' => 'Data Peminjaman', 'url' => URL.'/admin/booking/index', 'icon' => 'calendar_pencil'],
    ['label' => 'Data Pengguna', 'url' => URL.'/admin/user/index', 'icon' => 'person'],
    ['label' => 'Data Ruangan', 'url' => URL.'/admin/room/index', 'icon' => 'room'],

];
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
  $activeItem = "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>

<body class="font-poppins">
    <?php include_once 'app/components/response-banner.php'; ?>
    <!-- Main Content -->
    <div class="h-screen overflow-hidden w-full flex items-center bg-primary gap-4">
        <div class="w-56 h-full flex items-center justify-center">
            <?php
            NavThings::adminSideBar(items: $items, activeItem: $activeItem ?? null, title: $title ?? "SIMARU", logo: $logo ?? null);
            ?>
        </div>
        <div class="flex-1 w-full h-full p-4">
            <div class="w-full h-full bg-image rounded-xl overflow-hidden relative">
                <div class="w-full h-full p-4 flex items-center justify-center">
                    <?= $content ?>
                </div>
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