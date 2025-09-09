<?php
/**
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var string $csrfToken
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <?php if ($auth->check()) { ?>
        <p>Нет доступа</p>
    <?php } else { ?>
        <b>Registration page</b>
        <div>
            <form action="/signup" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="text" name="name" placeholder="Имя*">
                <input type="email" name="email" placeholder="E-mail*">
                <input type="password" name="password" placeholder="Пароль*">
                <button>Создать аккаунт</button>
            </form>
        </div>
    <?php } ?>
</body>
</html>