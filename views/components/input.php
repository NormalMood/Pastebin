<?php
/**
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var string $id
 * @var string $type
 * @var string $name
 * @var string $placeholder
 * @var string $value
 */
?>
<div class="input<?php echo ($type === 'password') ? ' input_password' : ''; ?>">
    <input <?php echo !empty($id) ? "id=\"$id\"" : "id=\"$name\""; ?> type="<?php echo $type; ?>" name="<?php echo $name; ?>" placeholder=" " <?php echo (isset($value) && ($value !== '')) ? "value=\"$value\"" : '' ?> autocomplete="off" <?php echo $session->has($name) ? 'class="input_error"' : ''; ?>>
    <label class="input__label" for="<?php echo !empty($id) ? $id : $name; ?>"><?php echo $placeholder; ?></label>
    <?php if ($type === 'password') { ?>
        <img class="input__eye input__eye_show-password" src="/img/show_password.png">
    <?php } ?>
</div>