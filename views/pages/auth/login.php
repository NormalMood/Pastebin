<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <b>Login page</b>
    <?php if ($session->has('userNotVerified')) { ?>
        <ul>
            <li><?php echo $session->getFlush('userNotVerified'); ?></li>
        </ul>
    <?php } ?>
    <?php if ($session->has('errorMessages')) { ?>
        <ul>
            <?php foreach ($session->getFlush('errorMessages') as $errorMessage) { ?>
                <li><?php echo $errorMessage; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <?php if ($session->has('incorrectPassword')) { ?>
        <ul>
            <li><?php echo $session->getFlush('incorrectPassword'); ?></li>
        </ul>
    <?php } ?>
    <?php if ($session->has('resetPassword')) { ?>
        <ul>
            <li><?php echo $session->getFlush('resetPassword'); ?></li>
        </ul>
    <?php } ?>
    <?php if ($session->has('forgotName')) { ?>
        <ul>
            <li><?php echo $session->getFlush('forgotName'); ?></li>
        </ul>
    <?php } ?>
    <?php if ($session->has('forgotPassword')) { ?>
        <ul>
            <li><?php echo $session->getFlush('forgotPassword'); ?></li>
        </ul>
    <?php } ?>
    <div>
        <form action="/signin" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="text" name="name" placeholder="Имя*" <?php echo !empty($session->getFlush('name')) ? 'class="redInput"' : ''; ?>>
            <input type="password" name="password" placeholder="Пароль*" <?php echo !empty($session->getFlush('password')) ? 'class="redInput"' : ''; ?>>
            <button>Войти</button>
        </form>
    </div>
    <br><br>
    <div>
        <form action="/forgot-name" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="text" name="email" placeholder="E-mail*">
            <button>Восстановить имя</button>
        </form>
    </div>
    <br><br>
    <div>
        <form action="/forgot-password" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="text" name="name" placeholder="Имя*">
            <button>Восстановить пароль</button>
        </form>
    </div>
<?php $view->component('end'); ?>