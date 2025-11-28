<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\Badge;
use Soap\Url;

?>
<div class="flex flex-col gap-4 rounded-lg overflow-hidden bg-baseColor p-2">
    <!-- Room Image -->
    <div class="relative w-full h-72 overflow-hidden rounded-lg">
        <img src="<?= URL . '/public/' . $room['image'] ?>" alt="<?= $room['name'] ?? 'Room' ?>" class="w-full h-full object-cover">
        <?php if ($room['isSpecial']):
            Badge::badge(label: 'Special Room', color: 'secondary', class: 'absolute inset-0 m-2 w-fit h-fit ms-auto bg-secondary/40!');
        endif;
        ?>

    </div>

    <!-- Room Info -->
    <div class="flex flex-col gap-3 flex-1">
        <!-- Room Name & Rating -->
        <div class="flex flex-col gap-1">
            <h3 class="text-xl text-black/80 font-medium">
                <?= $room['name'] ?? 'Ruang Perancis' ?>
            </h3>
            <div class="flex items-center gap-1">
                <?= Icon::star('w-4 h-4 text-primary') ?>
                <span class="text-medium font-medium text-black/70">
                    <?= $room['rating'] ?? '4.85' ?>
                </span>
            </div>
        </div>

        <!-- Room Description -->
        <p class="text-sm text-black/60 leading-relaxed line-clamp-3">
            <?= $room['description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' ?>
        </p>

        <!-- Capacity Info (if exists) -->
        <div class="flex items-center gap-2 font-medium text-xs text-black/70">
            <?= Icon::people('w-4 h-4') ?>
            <span>min: <?= $room['min'] ?></span> &bull; <span>max: <?= $room['max'] ?></span>
        </div>

        <!-- Book Button -->
        <div class="mt-auto pt-2">
            <?= Button::anchor(
                label: 'Book This Room',
                color: 'primary',
                class: 'w-full py-2 text-sm shadow-none!',
                href: $room['room_url']
            ) ?>
        </div>
    </div>
</div>