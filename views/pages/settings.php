<?php
/**
 * @var string $userName
 * @var string $email
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
    <?php } ?>
    <form action="/logout" method="post">
        <button>Выйти</button>
    </form>
</body>
</html>