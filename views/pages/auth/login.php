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
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('userNotVerified')]]) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('incorrectPassword')) { ?>
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('incorrectPassword')]]) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('resetPassword')) { ?>
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'success', 'messages' => [$session->getFlush('resetPassword')]]) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('forgotName')) { ?>
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('forgotName')]]) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('forgotPassword')) { ?>
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('forgotPassword')]]) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('errorMessages')) { ?>
        <div class="message-credentials-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => $session->getFlush('errorMessages')]) ?>
            </div>
        </div>
    <?php } ?>
    <section class="credentials">
        <div class="container">
            <form class="credentials__form" id="signInForm" action="/signin" method="post">
                <span class="title credentials__title_hidden">Вход</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['id' => 'signin-name-input', 'type' => 'text', 'name' => 'name', 'placeholder' => 'Имя*', 'value' => $this->session->getFlush('name_error_value')]) ?>
                    <?php $view->component('validation-message', ['id' => 'signin-name-error', 'inputName' => 'name']); ?>
                    <?php $view->component('input', ['id' => 'signin-password-input', 'type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль*', 'value' => $this->session->getFlush('password_error_value')]) ?>
                    <?php $view->component('validation-message', ['id' => 'signin-password-error', 'inputName' => 'password']); ?>
                </div>
                <button class="button">Войти</button>
                <div class="credentials__navigation">
                    <span class="forgotName">Забыли имя?</span>
                    <span class="forgotPassword">Забыли пароль?</span>
                </div>
            </form>
            <form class="credentials__form credentials__form_hidden" id="forgotNameForm" action="/forgot-name" method="post">
                <span class="title credentials__title_hidden">Восстановление имени</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['id' => 'forgot-name-email-input', 'type' => 'email', 'name' => 'email', 'placeholder' => 'E-mail*', 'value' => $this->session->getFlush('email_error_value')]) ?>
                    <?php $view->component('validation-message', ['id' => 'forgot-name-email-error', 'inputName' => 'email']); ?>
                </div>
                <button class="button">Получить имя</button>
                <div class="credentials__navigation">
                    <span class="back">Назад</span>
                    <span class="forgotPassword">Забыли пароль?</span>
                </div>
            </form>
            <form class="credentials__form credentials__form_hidden" id="forgotPasswordForm" action="/forgot-password" method="post">
                <span class="title credentials__title_hidden">Восстановление пароля</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['id' => 'forgot-password-name-input', 'type' => 'text', 'name' => 'forgot-password_name', 'placeholder' => 'Имя*', 'value' => $this->session->getFlush('forgot-password_name_error_value')]) ?>
                    <?php $view->component('validation-message', ['id' => 'forgot-password-name-error', 'inputName' => 'forgot-password_name']); ?>
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