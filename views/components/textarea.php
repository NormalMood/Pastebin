<?php
/**
 * @var string $name
 * @var string $placeholder
 * @var array<string> $classes
 */
?>
<div class="textarea">
    <textarea class="<?php echo !empty($classes) ? implode(separator: ' ', array: $classes) . ' textarea_height' : 'textarea_height'; ?>" id="<?php echo $name; ?>" name="<?php echo $name; ?>" placeholder=" "></textarea>
    <label class="textarea__label" for="<?php echo $name; ?>"><?php echo $placeholder; ?></label>
</div>