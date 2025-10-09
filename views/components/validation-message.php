<?php
/**
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var string $id
 * @var string $inputName
 */
?>
<?php if ($session->has($inputName)) { ?>
    <p id="<?php echo $id; ?>" class="validation__message validation__message_margin-top validation__message_visible"><?php echo $session->getFlush($inputName); ?></p>
<?php } else { ?>
    <p id="<?php echo $id; ?>" class="validation__message validation__message_margin-top"></p>
<?php } ?>