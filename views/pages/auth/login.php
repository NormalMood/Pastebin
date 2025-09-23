<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
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
    <section class="credentials">
        <div class="container">
            <form class="credentials__form" id="signInForm" action="/signin" method="post">
                <span class="title">Вход</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['type' => 'text', 'name' => 'name', 'placeholder' => 'Имя*']) ?>
                    <?php $view->component('input', ['type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль*']) ?>
                </div>
                <button class="button">Войти</button>
                <div class="credentials__navigation">
                    <span class="forgotName">Забыли имя?</span>
                    <span class="forgotPassword">Забыли пароль?</span>
                </div>
            </form>
            <form class="credentials__form credentials__form_hidden" id="forgotNameForm" action="/forgot-name" method="post">
                <span class="title">Восстановление имени</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['type' => 'email', 'name' => 'email', 'placeholder' => 'E-mail*']) ?>
                </div>
                <button class="button">Получить имя</button>
                <div class="credentials__navigation">
                    <span class="back">Назад</span>
                    <span class="forgotPassword">Забыли пароль?</span>
                </div>
            </form>
            <form class="credentials__form credentials__form_hidden" id="forgotPasswordForm" action="/forgot-password" method="post">
                <span class="title">Восстановление пароля</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['type' => 'text', 'name' => 'name', 'placeholder' => 'Имя*']) ?>
                </div>
                <button class="button">Получить пароль</button>
                <div class="credentials__navigation">
                    <span class="back">Назад</span>
                    <span class="forgotName">Забыли имя?</span>
                </div>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>