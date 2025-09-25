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
        <ul>
            <?php foreach ($session->getFlush('errorMessages') as $errorMessage) { ?>
                <li><?php echo $errorMessage; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <section class="credentials">
        <div class="container">
            <form class="credentials__form" action="/reset-password" method="post">
                <span class="title credentials__title_hidden">Сброс пароля</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="token" value="<?php echo $token ?>">
                <div class="credentials__container">
                    <?php $view->component('input', ['type' => 'password', 'name' => 'new_password', 'placeholder' => 'Новый пароль*']) ?>
                </div>
                <button class="button">Сохранить</button>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>