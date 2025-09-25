<?php
/**
 * @var array<string> $classes
 * @var string $id
 * @var string $text
 */
?>
<label class="<?php echo !empty($classes) ? 'checkbox ' . implode(' ', $classes) : 'checkbox'; ?>">
    <input id="<?php echo $id; ?>" type="checkbox">
    <span class="checkmark"></span>
    <span><?php echo $text; ?></span>
</label>