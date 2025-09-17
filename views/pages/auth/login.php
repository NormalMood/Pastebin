<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var string $csrfToken
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $view->title(); ?></title>
</head>
<body>
    <?php if ($auth->check()) { ?>
        <p>Нет доступа</p>
    <?php } else { ?>
        <b>Login page</b>
        <div>
            <form action="/signin" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="text" name="name" placeholder="Имя*">
                <input type="password" name="password" placeholder="Пароль*">
                <button>Войти</button>
            </form>
        </div>
        <br><br>
        <div>
            <form action="/forgot-name" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="text" name="email" placeholder="E-mail*">
                <button>Восстановить имя</button>
            </form>
        </div>
        <br><br>
        <div>
            <form action="/forgot-password" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="text" name="name" placeholder="Имя*">
                <button>Восстановить пароль</button>
            </form>
        </div>
    <?php } ?>
</body>
</html>