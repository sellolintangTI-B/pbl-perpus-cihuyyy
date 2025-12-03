<?php

use App\Components\Badge;
use App\Components\Button;
use App\Components\Icon\Icon;

$statusColor = [
    "created" => "primary",
    "checked_in" => "secondary",
    "cancelled" => "red",
    "finished" => "tertiary"
];

$statusLabel = [
    "created" => "berlangsung",
    "checked_in" => "berlangsung",
    "cancelled" => "dibatalkan",
    "finished" => "selesai"
];
?>

<div class="bg-white rounded-xl shadow-md p-4">
    <!-- Header with Code and Status -->
    <div class="flex justify-between items-start mb-3">
        <div>
            <h3 class="text-base font-normal text-primary mb-1">Kode Booking: <?= $booking['code'] ?></h3>
        </div>
        <?php
        Badge::badge(label: $statusLabel[$booking['status']], active: false, color: $statusColor[$booking['status']]);
        ?>
    </div>

    <!-- Booking Details -->
    <div class="space-y-2 text-sm text-gray-700 mb-4 my-6 md:my-0">
        <div class="flex items-start gap-2 w-3/4 md:w-full">
            <span><?php Icon::location("w-5 w-5 text-primary") ?></span>
            <span><?= $booking['location'] ?></span>
        </div>

        <div class="flex items-center gap-2">
            <span><?php Icon::calendar_pencil("w-5 w-5 text-primary") ?></span>
            <span><?= $booking['date'] ?></span>
        </div>

        <div class="flex items-center gap-2">
            <span><?php Icon::clock("w-5 w-5 text-primary") ?></span>
            <span><?= $booking['time'] ?></span>
        </div>
    </div>

    <!-- Action Button -->
    <div class="flex w-full justify-end">
        <div class="flex gap-2">
            <?php
            if ($booking['status'] == 'finished' && !$booking['has_feedback']) {
                Button::buttonGradient(label: "Beri Feedback",  alpineClick: $booking['alpineClick'], class: 'rounded-full! w-fit! text-sm! py-2! px-4!');
            }
            Button::anchorGradient(label: "See Details", link: $booking['url'], class: 'rounded-full! w-fit! text-sm! py-2! px-4!');
            ?>
        </div>
    </div>
</div>