<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var array<\Pastebin\Models\Category> $categories
 * @var array<\Pastebin\Models\Syntax> $syntaxes
 * @var array<\Pastebin\Models\Interval> $intervals
 * @var array<\Pastebin\Models\PostVisibility> $postVisibilities
 * @var string $csrfToken
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $view->title(); ?></title>
</head>
    <b>Post page</b>
    <?php if ($session->has('errorMessages')) { ?>
        <ul>
            <?php foreach ($session->getFlush('errorMessages') as $errorMessage) { ?>
                <li><?php echo $errorMessage; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <?php if ($session->has('accountDeleted')) { ?>
        <ul>
            <li><?php echo $session->getFlush('accountDeleted'); ?></li>
        </ul>
    <?php } ?>
    <form action="/" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        <div>
            <textarea name="text" placeholder="Содержимое поста*" required></textarea>
        </div>
        <div>
            <input type="text" name="title" placeholder="Заголовок">
        </div>
        <div>
            <select name="category_id" required>
                <option value="" disabled selected>Категория*</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category->id(); ?>"><?php echo $category->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <select name="syntax_id" required>
                <option value="" disabled selected>Подсветка синтаксиса*</option>
                <?php foreach ($syntaxes as $syntax) { ?>
                    <option value="<?php echo $syntax->id(); ?>" data-codemirror5-mode="<?php echo $syntax->codemirror5Mode(); ?>"><?php echo $syntax->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <select name="interval_id" required>
                <option value="" disabled selected>Время жизни*</option>
                <?php foreach ($intervals as $interval) { ?>
                    <option value="<?php echo $interval->id(); ?>"><?php echo $interval->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <?php if ($auth->check()) { ?>
            <div>
                <select name="post_visibility_id" required>
                    <option value="" disabled selected>Доступ*</option>
                    <?php foreach ($postVisibilities as $postVisibility) { ?>
                        <option value="<?php echo $postVisibility->id(); ?>"><?php echo $postVisibility->name(); ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        <button>Создать</button>
    </form>
</body>
</html>