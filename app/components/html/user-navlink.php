 <a href="<?= $url ?>"
     class="px-3 py-1 rounded-full transition-all duration-300 <?= $active  ? '' : '' ?>"
     :class="scrolled ? 
                   '<?= $active  ? 'bg-white/20 text-white font-medium' : 'text-white/80 hover:text-white hover:bg-white/10' ?>' : 
                   '<?= $active  ? 'bg-primary/20 text-primary font-medium' : 'text-black/70 hover:text-primary hover:bg-primary/10' ?>'">
     <?= $label ?>
 </a>