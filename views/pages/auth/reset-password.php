<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var string $token
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <b>Reset password</b><br>
    <?php if ($session->has('errorMessages')) { ?>
        <ul>
            <?php foreach ($session->getFlush('errorMessages') as $errorMessage) { ?>
                <li><?php echo $errorMessage; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <div>
        <form action="/reset-password" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <input type="password" name="new_password" placeholder="Новый пароль*" <?php echo !empty($session->getFlush('new_password')) ? 'class="redInput"' : ''; ?>>
            <button>Сохранить</button>
        </form>
    </div>
<?php $view->component('end'); ?>