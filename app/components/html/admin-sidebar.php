<?php
use App\Components\NavThings;
?>
<div class="w-full h-full flex flex-col items-center justify-start text-white">
    <h1 class="text-2xl font-bold mt-8 mb-4">
        SIMARU
    </h1>
    <div class="w-full flex flex-col gap-6 items-center mt-8">
        <?php
            foreach($items as $item){
                $isActive = ($activeItem == $item['url']);
                NavThings::adminNavLink(active: $isActive, label: $item['label'], icon: $item['icon'], href: $item['url']);
            }
        ?>  
    </div>
</div>