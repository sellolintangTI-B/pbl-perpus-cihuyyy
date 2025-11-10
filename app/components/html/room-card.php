<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use Soap\Url;

?>
<div class="flex flex-col bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
    <!-- Room Image -->
    <div class="relative w-full h-48 overflow-hidden">
        <img src="<?= $room['room_img_url'] ?? '/public/storage/images/ruang-dummy.jpg' ?>" alt="<?= $room['name'] ?? 'Room' ?>" class="w-full h-full object-cover">
    </div>

    <!-- Room Info -->
    <div class="p-4 flex flex-col gap-3 flex-1">
        <!-- Room Name & Rating -->
        <div class="flex flex-col gap-1">
            <h3 class="text-base font-semibold text-primary">
                <?= $room['name'] ?? 'Ruang Perancis' ?>
            </h3>
            <div class="flex items-center gap-1">
                <?= Icon::star('w-4 h-4 text-primary') ?>
                <span class="text-sm font-medium text-black/70">
                    <?= $room['rating'] ?? '4.85' ?>
                </span>
            </div>
        </div>

        <!-- Room Description -->
        <p class="text-xs text-black/60 leading-relaxed line-clamp-3">
            <?= $room['description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' ?>
        </p>

        <!-- Capacity Info (if exists) -->
        <div class="flex items-center gap-2 text-xs text-black/70">
            <?= Icon::people('w-4 h-4') ?>
            <span>min: <?= $room['min'] ?></span> &bull; <span>max: <?= $room['max'] ?></span>
        </div>

        <!-- Book Button -->
        <div class="mt-auto pt-2">
            <?= Button::anchor(
                label: 'Book This Room',
                color: 'primary',
                class: 'w-full py-2 text-sm',
                href: "/user/room/detail/" . $room['id']
            ) ?>
        </div>
    </div>
</div>