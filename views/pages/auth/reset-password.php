<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var string $token
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
            <form class="credentials__form" action="/reset-password" method="post">
                <span class="title credentials__title_hidden">Сброс пароля</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="token" value="<?php echo $token ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['id' => 'reset-password-password-input', 'type' => 'password', 'name' => 'new_password', 'placeholder' => 'Новый пароль*']) ?>
                    <?php $view->component('validation-message', ['id' => 'reset-password-password-error', 'inputName' => 'new_password']); ?>
                </div>
                <button class="button">Сохранить</button>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>