<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="/public/css/style.css" rel="stylesheet">
    <link href="/public/css/theme.css" rel="stylesheet">
</head>
<body class="font-poppins bg-gray-100">
    <?php include_once 'app/components/response-hadler.php'; ?>
    <!-- Main Content -->
    <div>
        <?= $content ?>
    </div>
</body>
</html>