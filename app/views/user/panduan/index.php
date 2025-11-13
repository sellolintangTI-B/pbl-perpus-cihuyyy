<?php

use App\Components\Icon\Icon;
?>
<div class="bg-baseColor font-poppins w-full">
    <div class="max-w-5xl mx-auto flex flex-col gap-4 pb-8">
        <h1 class="text-2xl text-black/80 font-semibold">
            Panduan
        </h1>
        <div class="w-full relative" x-data="{open: false}">
            <div class="bg-linear-to-r from-primary to-secondary text-white p-6 rounded-lg flex items-center justify-between relative z-10 w-full">
                <span class="text-lg font-medium">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam, magnam.
                </span>
                <button @click="open = !open" class="cursor-pointer shrink-0 ml-4">
                    <span class="block transition-transform duration-300" :class="open ? 'rotate-180' : ''">
                        <?php
                        Icon::arrowDown('w-8 h-8 text-white')
                        ?>
                    </span>
                </button>
            </div>
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-24"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-24"
                class="px-8 w-full">
                <div class="p-8 bg-white shadow-md rounded-lg">
                    <p class="text-gray-700 leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Enim aut earum, explicabo fuga necessitatibus odio iste inventore, laborum voluptatibus voluptate, beatae recusandae esse totam. Distinctio iure itaque harum exercitationem molestiae?
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>