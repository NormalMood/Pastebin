<?php
/**
 * @var string $type
 * @var string $name
 * @var string $placeholder
 */
?>
<div class="input">
    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" placeholder=" ">
    <label class="input-label" for="<?php echo $name; ?>"><?php echo $placeholder; ?></label>
</div>