<?php
    use App\Components\Icon\Icon;
?>
<a class=" bg-primary text-sm text-white rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-500 <?= $class ?>" id="<?= $id ?>" href="<?= URL.$href ?>">
     <?php $icon?Icon::{ $icon }('w-3 h-3'): null;?> <?= $label ?>
</a>