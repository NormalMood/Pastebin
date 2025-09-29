<?php
/**
 * @var string $name
 * @var string $text
 * @var string $accept
 */
?>
<div class="upload-button" tabindex="1">
    <label for="<?php echo $name; ?>"><?php echo $text; ?></label>
    <input class="upload-button" id="<?php echo $name; ?>" type="file" name="<?php echo $name ?>" accept="<?php echo $accept; ?>">
</div>