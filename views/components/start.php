<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var \Pastebin\Kernel\Http\RequestInterface $request
 * @var string $csrfToken
 * @var string $nonce
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $view->title(); ?></title>
    <script src="/scripts/confirm_post_deletion.js" defer></script>
    <script src="/scripts/confirm_account_deletion.js" defer></script>
    <script src="/scripts/header_burger.js" defer></script>
    <script src="/scripts/logout.js" defer></script>
    <script src="/scripts/credentials_forms.js" defer></script>
    <script src="/scripts/select.js" defer></script>
    <script src="/scripts/textarea_height.js" defer></script>
    <script src="/scripts/syntax_highlight.js" defer></script>
    <script src="/scripts/copy_post.js" defer></script>
    <script src="/scripts/settings.js" defer></script>
    <script src="/scripts/delete_account_popup.js" defer></script>
    <script src="/scripts/dates.js" defer></script>
    <script src="/scripts/validation.js" defer></script>
    <script src="/scripts/password_input.js" defer></script>

    <!-- CodeMirror 5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/addon/display/placeholder.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/shell/shell.min.js"></script>       <!-- Bash -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/clike/clike.min.js"></script>       <!-- C, C++, C#, Java -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/css/css.min.js"></script>             <!-- CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/htmlmixed/htmlmixed.min.js"></script> <!-- HTML -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/javascript/javascript.min.js"></script> <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/php/php.min.js"></script>             <!-- PHP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/mode/python/python.min.js"></script>       <!-- Python -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.19/codemirror.min.css" />
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/normalize.css" rel="stylesheet" />


    <style nonce="<?php echo $nonce; ?>">
    </style>
</head>
<body>
    <header class="header">
        <div class="header__container">
            <div>
                <div class="header__body">
                    <?php if ($auth->check()) { ?>
                        <a class="header__profile-info" href="/profile?u=<?php echo htmlspecialchars($auth->user()->name()); ?>">
                            <img class="header__picture" <?php echo !empty($auth->user()->pictureLink()) ? "src=\"{$auth->user()->pictureLink()}\"" : 'src="/img/default_picture.png"'; ?>>
                            <span class="header__username"><?php echo htmlspecialchars($auth->user()->name()); ?></span>
                        </a>
                    <?php } else { ?>
                        <div class="header__not-auth"></div>
                    <?php } ?>
                    <div class="header__burger" id="header-burger">
                        <span></span>
                    </div>
                    <nav class="menu header__menu" id="header-menu">
                        <ul class="menu__list">
                            <li class="menu__item">
                                <a class="menu__link" href="/">
                                    <img class="menu__icon" src="/img/new_post.png">
                                    <span <?php echo $request->uri() === '/' ? 'class="menu__link_underline"' : ''; ?>>Пост</span>
                                </a>
                            </li>
                            <?php if ($auth->check()) { ?>
                                <li class="menu__item">
                                    <a class="menu__link" href="/profile?u=<?php echo $auth->user()->name(); ?>">
                                        <img class="menu__icon" src="/img/profile.png">
                                        <span <?php echo $request->uri() === '/profile' ? 'class="menu__link_underline"' : ''; ?>>Профиль</span>
                                    </a>
                                </li>
                                <li class="menu__item">
                                    <a class="menu__link" href="/settings?u=<?php echo $auth->user()->name(); ?>">
                                        <img class="menu__icon" src="/img/settings.png">
                                        <span <?php echo $request->uri() === '/settings' ? 'class="menu__link_underline"' : ''; ?>>Настройки</span>
                                    </a>
                                </li>
                                <li class="menu__item">
                                    <a class="menu__link" href="#" id="logoutLink">
                                        <img class="menu__icon" src="/img/logout.png">
                                        <span>Выход</span>
                                    </a>
                                </li>
                                <form id="logoutFormHidden" action="/logout" method="post">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                </form>
                            <?php } else { ?>
                                <li class="menu__item">
                                    <a class="menu__link" href="/signin">
                                        <img class="menu__icon" src="/img/signin.png">
                                        <span <?php echo $request->uri() === '/signin' ? 'class="menu__link_underline"' : ''; ?>>Вход</span>
                                    </a>
                                </li>
                                <li class="menu__item">
                                    <a class="menu__link" href="/signup">
                                        <img class="menu__icon" src="/img/signup.png">
                                        <span <?php echo in_array($request->uri(), ['/signup', '/resend-link']) ? 'class="menu__link_underline"' : ''; ?>>Регистрация</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>
