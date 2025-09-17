<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var string $token
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
    <b>Reset password</b><br>
    <div>
        <form action="/reset-password" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <input type="password" name="new_password" placeholder="Новый пароль*">
            <button>Сохранить</button>
        </form>
    </div>
</body>
</html>