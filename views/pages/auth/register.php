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
                <span class="title">Регистрация</span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="credentials__container">
                    <div class="input">
                        <input type="text" name="name" placeholder=" " <?php echo !empty($session->getFlush('name')) ? 'class="redInput"' : ''; ?>>
                        <label class="input-label" for="name">Имя*</label>
                    </div>
                    <div class="input">
                        <input type="email" name="email" placeholder=" " <?php echo !empty($session->getFlush('password')) ? 'class="redInput"' : ''; ?>>
                        <label class="input-label" for="email">E-mail*</label>
                    </div>
                    <div class="input">
                        <input type="password" name="password" placeholder=" " <?php echo !empty($session->getFlush('password')) ? 'class="redInput"' : ''; ?>>
                        <label class="input-label" for="password">Пароль*</label>
                    </div>
                </div>
                <button class="button">Создать аккаунт</button>
            </form>
        </div>
    </section>
<?php $view->component('end'); ?>