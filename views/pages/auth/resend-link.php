<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Config\ConfigInterface $config
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <p>Отправлена ссылка на почту <b><?php echo $session->get($config->get('auth.verification_link_field')) ?></b></p>
    <form action="/resend-link" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        <input type="hidden" name="email" value="<?php echo $session->get($config->get('auth.verification_link_field')) ?>">
        <button>Получить ссылку</button>
    </form>
<?php $view->component('end'); ?>