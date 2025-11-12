<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SIMARU" ?></title>
    <link href="<?= URL ?>/public/css/style.css" rel="stylesheet">
    <link href="<?= URL ?>/public/css/theme.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<?php

use App\Components\UserNavbar;
use App\Utils\Authentication;

$user = new Authentication

?>

<body class="font-poppins bg-gray-100">
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
        :class="scrolled ? 'p-0' : 'p-2'"
        class="w-full h-screen max-h-full overflow-hidden bg-primary transition-all duration-300">
        <div class="w-full h-full max-h-full overflow-hidden bg-baseColor " :class="scrolled ? 'rounded-none' : 'rounded-xl'">
            <?= UserNavbar::main(
                activeMenu: 'beranda',
                userName: $user->user['username'],
                logoUrl: URL . '/public/assets/logo.png',
            ) ?>

            <div x-ref="scrollContainer" class="w-full h-full max-h-full overflow-y-auto">
                <div class="pb-32">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>