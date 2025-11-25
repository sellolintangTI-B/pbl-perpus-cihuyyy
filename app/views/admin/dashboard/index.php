<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Icon\Icon;
use App\Components\Badge;

?>
<div class="flex flex-col justify-start items-start h-full w-full p-4 gap-5">
    <h1 class="text-2xl font-medium text-primary">
        Beranda
    </h1>
    <form class="flex gap-2 items-center w-full">
        <div class="relative flex-1">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <input
                type="text"
                name="search"
                id="search"
                placeholder="Cari Kode Booking..."
                class="rounded-xl shadow-md py-3 px-5 pl-12 bg-baseColor text-gray-600 border border-gray-400 hover:border-primary outline-none text-sm focus:shadow-md focus:shadow-primary/20 transition-shadow duration-300 w-full" />
        </div>
        <?php
        Button::button(label: 'check', type: 'submit', class: 'py-3 px-4 rounded-lg!', color: 'primary')
        ?>
    </form>

    <!-- give some shit condition here ... -->
    <?php
    if (!empty($data)) {
        include __DIR__ . '/sections/BookingCard.php';
    } else {
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            include __DIR__ . '/sections/BookingNotFound.php';
        }
    }
    ?>


</div>