<?php
/**
 * @var string $id
 * @var string $type
 * @var string $name
 * @var string $placeholder
 * @var string $value
 */
?>
<div class="input">
    <input <?php echo !empty($id) ? "id=\"$id\"" : "id=\"$name\""; ?> type="<?php echo $type; ?>" name="<?php echo $name; ?>" placeholder=" " <?php echo (isset($value) && ($value !== '')) ? "value=\"$value\"" : '' ?> autocomplete="off">
    <label class="input__label" for="<?php echo !empty($id) ? $id : $name; ?>"><?php echo $placeholder; ?></label>
</div>