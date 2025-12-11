<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\Badge;

?>
<div class="flex flex-col gap-4 rounded-lg overflow-hidden bg-baseColor p-2 h-full w-[175px] sm:w-[200px] md:w-full cursor-pointer" onclick="window.location.href = '<?= URL . $room['room_url'] ?>'">
    <!-- Room Image -->
    <div class="relative w-full md:h-72 h-36 overflow-hidden rounded-lg flex-shrink-0">
        <img
            src="<?= URL . '/public/' . $room['image'] ?>" alt="<?= $room['name'] ?? 'Room' ?>"
            class="w-full h-full object-cover "
            onerror="this.onerror=null; this.src='<?= URL ?>/public/storage/bg-pattern/no-img.webp';">

        <?php if ($room['isSpecial']): ?>
            <div class="px-2 py-1 h-fit w-fit m-2 ms-auto rounded-full absolute top-0 right-0 text-sm border border-secondary bg-white/80 text-secondary">
                Ruang Rapat
            </div>
        <?php endif; ?>
    </div>

    <!-- Room Info -->
    <div class="flex flex-col gap-3 flex-1">
        <!-- Room Name & Rating -->
        <div class="flex flex-col gap-1">
            <h3 class="text-xl text-black/80 font-medium line-clamp-2 h-full flex-1">
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
        <p class="text-sm text-black/60 leading-relaxed line-clamp-3 hidden md:block">
            <?= $room['description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' ?>
        </p>

        <!-- Capacity Info -->
        <div class="flex items-center gap-2 font-medium text-xs text-black/70">
            <?= Icon::people('w-4 h-4') ?>
            <span>min: <?= $room['min'] ?></span> &bull; <span>max: <?= $room['max'] ?></span>
        </div>

        <!-- Book Button -->
        <div class="mt-auto pt-2 hidden md:block">
            <?= Button::anchor(
                label: 'Book This Room',
                color: 'primary',
                class: 'w-full py-2 text-sm shadow-none!',
                href: $room['room_url']
            ) ?>
        </div>
    </div>
</div>