<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'berlangsung';
?>

<div class="bg-baseColor font-poppins w-full">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold text-primary mb-6">Booking</h1>

        <!-- Tabs -->
        <form class="flex gap-4 mb-6 border-b-2 border-gray-200" method="get">
            <button
                name="tab"
                value="berlangsung"
                class="pb-3 px-1 transition-colors <?= $tab == 'berlangsung' ? 'text-primary font-medium border-b-2 border-primary -mb-0.5' : 'text-gray-500 hover:text-primary' ?>">
                Berlangsung
            </button>
            <button
                name="tab"
                value="riwayat"
                class="pb-3 px-1 transition-colors <?= $tab == 'riwayat' ? 'text-primary font-medium border-b-2 border-primary -mb-0.5' : 'text-gray-500 hover:text-primary' ?>">
                Riwayat
            </button>
        </form>

        <!-- Container for main content with fixed height and scroll -->
        <div
            class="w-full">
            <div class="relative w-full">
                <?php
                if ($tab == 'berlangsung') {
                    include __DIR__ . "/sections/berlangsung.php";
                } else if ($tab == 'riwayat') {
                    include __DIR__ . "/sections/riwayat.php";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>