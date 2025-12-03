<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?= URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/theme.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/global.css" rel="stylesheet">
    <link rel="preconnect" href="https://challenges.cloudflare.com">
    <!-- <script src="<?= URL ?>/public/js/alpine.js" defer></script> -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>

<body class="font-poppins">
    <?php include_once 'app/components/response-banner.php'; ?>
    <!-- Main Content -->
    <div>
        <?= $content ?>
    </div>
</body>

</html>