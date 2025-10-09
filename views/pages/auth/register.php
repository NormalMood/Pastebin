<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <?php if ($session->has('errorMessages')) { ?>
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => $session->getFlush('errorMessages')]) ?>
            </div>
        </div>
    <?php } ?>
    <section class="credentials">
        <div class="container">
            <form class="credentials__form" action="/signup" method="post">
                <span class="title credentials__title_hidden">Регистрация</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['id' => 'signup-name-input', 'type' => 'text', 'name' => 'name', 'placeholder' => 'Имя*']) ?>
                    <p id="signup-name-error" class="validation__message validation__message_margin-top"></p>
                    <?php $view->component('input', ['id' => 'signup-email-input', 'type' => 'email', 'name' => 'email', 'placeholder' => 'E-mail*']) ?>
                    <p id="signup-email-error" class="validation__message validation__message_margin-top"></p>
                    <?php $view->component('input', ['id' => 'signup-password-input', 'type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль*']) ?>
                    <p id="signup-password-error" class="validation__message validation__message_margin-top"></p>
                </div>
                <button class="button">Создать аккаунт</button>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>