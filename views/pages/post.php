<?php
/**
 * @var array<\Pastebin\Models\Category> $categories
 * @var array<\Pastebin\Models\Syntax> $syntaxes
 * @var array<\Pastebin\Models\Interval> $intervals
 * @var array<\Pastebin\Models\PostVisibility> $postVisibilities
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>
    <b>Post page</b>
    <form action="/" method="post">
        <div>
            <textarea name="text" placeholder="Содержимое поста*" required></textarea>
        </div>
        <div>
            <input type="text" name="title" placeholder="Заголовок">
        </div>
        <div>
            <select name="category" required>
                <option value="" disabled selected>Категория*</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category->id(); ?>"><?php echo $category->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <select name="syntax" required>
                <option value="" disabled selected>Подсветка синтаксиса*</option>
                <?php foreach ($syntaxes as $syntax) { ?>
                    <option value="<?php echo $syntax->id(); ?>" data-codemirror5-mode="<?php echo $syntax->codemirror5Mode(); ?>"><?php echo $syntax->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <select name="interval" required>
                <option value="" disabled selected>Время жизни*</option>
                <?php foreach ($intervals as $interval) { ?>
                    <option value="<?php echo $interval->id(); ?>"><?php echo $interval->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <select name="post_visibility" required>
                <option value="" disabled selected>Доступ*</option>
                <?php foreach ($postVisibilities as $postVisibility) { ?>
                    <option value="<?php echo $postVisibility->id(); ?>"><?php echo $postVisibility->name(); ?></option>
                <?php } ?>
            </select>
        </div>
        <button>Создать</button>
    </form>
</body>
</html>