<?php
/**
 * @var string $type
 * @var string $name
 * @var string $placeholder
 * @var string $value
 */
?>
<div class="input">
    <input id="<?php echo $name; ?>" type="<?php echo $type; ?>" name="<?php echo $name; ?>" placeholder=" " <?php echo !empty($value) ? "value=\"$value\"" : '' ?>>
    <label class="input__label" for="<?php echo $name; ?>"><?php echo $placeholder; ?></label>
</div>