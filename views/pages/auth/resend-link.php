<?php
/**
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Config\ConfigInterface $config
 * @var string $csrfToken
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if ($session->has($config->get('auth.verification_link_field'))) {?>
        <p>Отправлена ссылка на почту <b><?php echo $session->get($config->get('auth.verification_link_field')) ?></b></p>
        <form action="/resend-link" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="email" value="<?php echo $session->get($config->get('auth.verification_link_field')) ?>">
            <button>Получить ссылку</button>
        </form>
    <?php } else { ?>
    <?php echo 'Нет доступа'; } ?>
</body>
</html>