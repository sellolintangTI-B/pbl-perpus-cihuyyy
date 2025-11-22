<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'berlangsung';

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Modal;
?>

<div class=" font-poppins w-full" x-data="{showCancel: false, cancelPeminjamanId: null }">
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
            <div class=" w-full">
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
    <!-- modal -->
    <?php
    ob_start();
    ?>
    <form x-bind:action="`<?= URL ?>/user/booking/cancel_booking/${cancelPeminjamanId}`" method="POST" class="w-full flex flex-col gap-2">
        <?= FormInput::textarea(id: 'reason', name: 'reason', label: 'Alasan:', required: true, class: 'h-18', maxlength: 100, color: 'red') ?>
        <!-- opsional misal idnya mau disatuin ama form -->
        <input type="text" name="id" x-bind:value="cancelPeminjamanId" class="hidden" />
        <div class="flex gap-4 w-full ">
            <?php
            Button::button(label: 'Iya', color: 'red', type: 'submit', class: 'w-full py-3');
            Button::button(label: 'Tidak', color: 'white', type: 'button', alpineClick: "showCancel=false", class: 'w-full py-3');
            ?>
        </div>
    </form>
    <?php $content = ob_get_clean(); ?>

    <?= Modal::render(
        title: 'Yakin ingin membatalkan booking?',
        color: 'red',
        message: 'Booking akan dibatalkan. Pastikan keputusan Anda sudah benar sebelum melanjutkan.',
        customContent: $content,
        alpineShow: 'showCancel',
        class: 'max-w-2xl p-8',
        height: 'h-fit'
    ) ?>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>