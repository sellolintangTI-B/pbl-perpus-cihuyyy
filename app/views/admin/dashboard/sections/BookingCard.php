<?php

use App\Components\Icon\Icon;
use App\Components\Badge;
?>
<div class="w-full p-6 flex flex-col gap-4 bg-white border-gray-200 border rounded-lg font-medium">
    <div class="w-full flex justify-between">
        <div class="flex gap-2 text-xl font-medium">
            <span class="text-primary">
                Kode Booking:
            </span>
            <span id="kode_booking" class="text-secondary">
                #AA682358
            </span>
            <!-- copy button -->
            <button class="p-1.5 rounded-md hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                <?php Icon::copy('w-5 h-5 text-black/80') ?>
            </button>
        </div>
        <?php
        Badge::badge('Created', color: 'primary')
        ?>
    </div>
    <div class="flex gap-2 text-black/80">
        <span>
            <?php
            Icon::location('w-5 h-5 ')
            ?>
        </span>
        <span>
            Tempat: <span class="text-primary">Ruang Perancis</span>, Perpustakaan PNJ, LT. 4
        </span>
    </div>
    <div class="flex gap-2 text-black/80">
        <span>
            <?php
            Icon::calendar_pencil('w-5 h-5 ')
            ?>
        </span>
        <span>
            Tanggal : 8 - 11 - 2025
        </span>
    </div>
    <div class="flex justify-between">
        <div class="flex gap-2 text-black/80">
            <span>
                <?php
                Icon::clock('w-5 h-5 ')
                ?>
            </span>
            <span>
                Jam: 13:00 - 15:00
            </span>
        </div>
        <!-- get some fuckin action here -->
        <div class="relative" x-data="{open: false}">
            <button
                @click="open = !open"
                class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                <?= Icon::dotMenu('w-5 h-5') ?>
            </button>

            <!-- Dropdown Menu -->
            <div
                x-show="open"
                @click.outside="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-1 w-32 bg-white border border-gray-200 rounded-md shadow-md text-left z-50 overflow-hidden"
                style="display: none;">
                <button
                    @click=""
                    class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 border-t border-gray-100 w-full transition cursor-pointer">
                    Check In
                </button>
                <button
                    @click=""
                    class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 border-t border-gray-100 w-full transition cursor-pointer">
                    Check Out
                </button>
                <button
                    @click=""
                    class="flex items-center gap-2 px-3 py-2 text-xs text-red hover:bg-red/5 border-t border-gray-100 w-full transition cursor-pointer">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>