<?php

use App\Components\Badge;
use App\Components\Button;
use App\Components\Icon\Icon;
?>

<div class="bg-white rounded-xl shadow-md p-4">
    <!-- Header with Code and Status -->
    <div class="flex justify-between items-start mb-3">
        <div>
            <h3 class="text-base font-bold text-primary mb-1">Kode Booking: <?= $booking['code'] ?></h3>
        </div>
        <?php
        Badge::badge(label: $booking['status'], active: false, color: $booking['status'] == 'finished' ? 'secondary' : 'red');
        ?>
    </div>

    <!-- Booking Details -->
    <div class="space-y-2 text-sm text-gray-700 mb-4">
        <div class="flex items-start gap-2">
            <?php Icon::location("w-5 w-5 text-primary") ?>
            <span><?= $booking['location'] ?></span>
        </div>

        <div class="flex items-center gap-2">
            <?php Icon::calendar_pencil("w-5 w-5 text-primary") ?>
            <span><?= $booking['date'] ?></span>
        </div>

        <div class="flex items-center gap-2">
            <?php Icon::clock("w-5 w-5 text-primary") ?>
            <span><?= $booking['time'] ?></span>
        </div>
    </div>

    <!-- Action Button -->
    <?php
    Button::anchorGradient(label: "See Details", link: $booking['url'])
    ?>
</div>