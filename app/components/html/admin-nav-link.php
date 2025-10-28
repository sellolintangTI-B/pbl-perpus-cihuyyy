<!-- variable: active, icon -->
<div class="w-full flex flex-col gap-4 mt-8">
    <div  class="w-full h-fit flex items-center gap-4 cursor-pointer">
        <div class="w-1 rounded-r-xs bg-white duration-300 transition-all <?=$active?"h-6":"h-0"?>">

        </div>
        <a class="p-1.5 bg-white/20 rounded-md hover:bg-white/30 w-full text-center flex gap-2 justify-center items-center <?=$active?"h-6":"h-0"?>" >
           <span class="w-5 h-5">
                <?php
                    $icon();
                ?>
           </span>
            <?= $label ?>
        </a>
    </div>
</div>