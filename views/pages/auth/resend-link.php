<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Config\ConfigInterface $config
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <div class="message-credentials-wrapper">
        <div class="container">
            <?php $view->component('message', ['type' => 'success', 'messages' => ["Добро пожаловать, {$session->get($config->get('auth.verification_link_for_user'))}! Ваш аккаунт создан. На Вашу почту <b>{$session->get($config->get('auth.verification_link_field'))}</b> было отправлено письмо с <b>ссылкой активации</b> внутри.<br>Пожалуйста, перейдите по ней, чтобы активировать аккаунт"]]) ?>
        </div>
    </div>
    <div class="message-credentials-wrapper">
        <div class="container">
            <?php $view->component('message', ['type' => 'info', 'messages' => ['Доставка письма с ссылкой иногда может занять несколько минут. Если Вы не можете найти письмо, пожалуйста, проверьте папку "Спам".<br>Если письмо не пришло, то нажмите, пожалуйста, на кнопку ниже']]) ?>
        </div>
    </div>
    <section class="credentials credentials_max-width credentials_height-fit-content">
        <div class="container container_padding-unset">
            <form action="/resend-link" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="email" value="<?php echo $session->get($config->get('auth.verification_link_field')) ?>">
                <button class="button">Получить ссылку</button>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>