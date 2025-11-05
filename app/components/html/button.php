<?php
    use App\Components\Icon\Icon;
?>
<button class=" bg-primary text-sm text-white rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-500 <?= $class ?>" type="<?=$type?>" onclick="<?=$onclick?>"  id="<?= $id ?>" name="<?= $name ?>">
     <?php $icon?Icon::{ $icon }('w-6 h-6'): null;?> <?= $label ?>
</button> 