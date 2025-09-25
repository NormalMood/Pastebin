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
        <ul>
            <?php foreach ($session->getFlush('errorMessages') as $errorMessage) { ?>
                <li><?php echo $errorMessage; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <section class="credentials">
        <div class="container">
            <form class="credentials__form" action="/signup" method="post">
                <span class="title credentials__title_hidden">Регистрация</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['type' => 'text', 'name' => 'name', 'placeholder' => 'Имя*']) ?>
                    <?php $view->component('input', ['type' => 'email', 'name' => 'email', 'placeholder' => 'E-mail*']) ?>
                    <?php $view->component('input', ['type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль*']) ?>
                </div>
                <button class="button">Создать аккаунт</button>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>