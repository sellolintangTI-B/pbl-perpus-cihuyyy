<?php
$customClass = "border border-primary " . ($active  ? "bg-primary text-white" :  "bg-primary/20 text-primary");
if (!empty($color)) {
    switch (trim($color)) {
        case 'red':
            $customClass = "border border-red " . ($active ? "bg-red text-white" : "bg-red/20 text-red");
            break;
        case 'primary':
            $customClass = "border border-primary " . ($active ? "bg-primary text-white" : "bg-primary/20 text-primary");
            break;
        case 'secondary':
            $customClass = "border border-secondary " . ($active ? "bg-secondary text-white" : "bg-secondary/20 text-secondary");
            break;
        case 'tertiary':
            $customClass = "border border-tertiary " . ($active ? "bg-tertiary text-white" : "bg-tertiary/20 text-tertiary");
            break;
        default:
            $customClass = "border border-primary " . ($active ? "bg-primary text-white" : "bg-primary/20 text-primary");
            break;
    }
}
?>

<button class="px-2 py-1 rounded-full flex items-center justify-center text-sm <?= $customClass ?> <?= $class ?>" type="<?= $type ?>" onclick="<?= $onclick ?>" name="<?= $name ?>" value="<?= $value ?>">
    <?= $label ?>
</button>