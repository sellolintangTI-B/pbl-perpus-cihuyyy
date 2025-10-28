<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?=URL?>/public/css/style.css" rel="stylesheet">
    <link href="<?=URL?>/public/css/theme.css" rel="stylesheet">
</head>
<?php
    use App\components\icon\Icon;
    use App\components\NavThings;
    $items = [
                    ['label' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => Icon::dashboard()],
                    ['label' => 'Data Ruangan', 'url' => '/admin/rooms', 'icon' => Icon::person()],
    ];
    $activeItem = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<body class="font-poppins bg-gray-100 w-full h-screen">
    <!-- Main Content -->
     <div class="h-full w-full flex items-center bg-primary gap-4">
        <?=
            NavThings::adminSideBar(items: $items, activeItem: $activeItem ?? null, title: $title ?? "SIMARU", logo: $logo ?? null);
        ?>
        <div class="flex-1 w-full h-full p-4">
           <div class="flex items-center justify-center w-full h-full bg-white rounded-xl">
                <?= $content ?>
           </div>
        </div>
    </div>
</body>

</html>