<?php
/**
 * @var string $userName
 * @var string $email
 * @var string $csrfToken
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
</head>
<body>
    <b>Settings page</b><br>
    <?php if (!isset($userName)) { ?>
        Доступ запрещен
    <?php } else { ?>
        <div>
            <span>Имя: <?php echo $userName; ?></span><br>
            <span>E-mail: <?php echo $email; ?></span>
        </div>
        <div>
            <form action="/picture" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="u" value="<?php echo $userName; ?>">
                <input type="file" name="picture">
                <button>Сохранить</button>
            </form>
        </div>
    <?php } ?>
    <form action="/logout" method="post">
        <button>Выйти</button>
    </form>
</body>
</html>