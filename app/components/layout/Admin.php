<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?= URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/theme.css" rel="stylesheet">
</head>

<body class="font-poppins bg-gray-100 w-full h-screen">
    <?php include_once 'app/components/response-hadler.php'; ?>
    <!-- Main Content -->
    <div class="h-full w-full flex gap-4 items-center bg-tertiary-100 p-4">
        <div class="w-44 h-full flex flex-col items-center justify-start text-white ">
            <h1 class="text-3xl font-bold mt-8 mb-4">
                SIMARU
            </h1>
        </div>
        <div class="flex-1 flex items-center justify-center w-full h-full bg-white rounded-xl">
            <?= $content ?>
        </div>
    </div>
</body>

</html>