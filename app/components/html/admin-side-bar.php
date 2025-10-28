<div class="w-56 h-full flex flex-col items-center justify-start text-white">
    <h1 class="text-2xl font-bold mt-8 mb-4">
        SIMARU
    </h1>
    <div class="w-full flex flex-col items-center">
        <?php
            foreach($items as $item){
                $isActive = ($activeItem == $item['url']);
                NavThings::adminNavLink(active: $isActive, label: $item['label'], icon: $item['icon'], href: $item['url']);
            }
        ?>  
</div>