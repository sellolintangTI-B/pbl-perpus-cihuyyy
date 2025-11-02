<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?= URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/theme.css" rel="stylesheet">
</head>
<?php

use App\Components\NavThings;

$items = [
    ['label' => 'Dashboard', 'url' => '/admin/dashboard/index', 'icon' => 'dashboard'],
    ['label' => 'Data Ruangan', 'url' => '/admin/room/index', 'icon' => 'person'],
    ['label' => 'Data User', 'url' => '/admin/user/index', 'icon' => 'person'],
    ['label' => 'Logout', 'url' => '/admin/dashboard/logout', 'icon' => 'person'],
];
$activeItem = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<body class="font-poppins">
    <!-- Main Content -->
    <div class="h-screen overflow-hidden w-full flex items-center bg-primary gap-4">
       <div class="w-56 h-full flex items-center justify-center">
            <?php
                NavThings::adminSideBar(items: $items, activeItem: $activeItem ?? null, title: $title ?? "SIMARU", logo: $logo ?? null);
            ?>
       </div>
        <div class="flex-1 w-full h-full p-4">
            <div class="flex items-center justify-center w-full h-full bg-white rounded-xl">
                <?= $content ?>
            </div>
        </div>
    </div>
</body>

</html>