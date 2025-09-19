<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var string $csrfToken
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $view->title(); ?></title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <?php if ($auth->check()) { ?>
        <p>Нет доступа</p>
    <?php } else { ?>
        <b>Registration page</b>
        <?php if ($session->has('errorMessages')) { ?>
            <ul>
                <?php foreach ($session->getFlush('errorMessages') as $errorMessage) { ?>
                    <li><?php echo $errorMessage; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <div>
            <form action="/signup" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="text" name="name" placeholder="Имя*" <?php echo !empty($session->getFlush('name')) ? 'class="redInput"' : ''; ?>>
                <input type="email" name="email" placeholder="E-mail*" <?php echo !empty($session->getFlush('email')) ? 'class="redInput"' : ''; ?>>
                <input type="password" name="password" placeholder="Пароль*" <?php echo !empty($session->getFlush('password')) ? 'class="redInput"' : ''; ?>>
                <button>Создать аккаунт</button>
            </form>
        </div>
    <?php } ?>
</body>
</html>