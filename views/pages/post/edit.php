<?php
/**
 * @var array<\Pastebin\Models\Category> $categories
 * @var array<\Pastebin\Models\Syntax> $syntaxes
 * @var array<\Pastebin\Models\Interval> $intervals
 * @var array<\Pastebin\Models\PostVisibility> $postVisibilities
 * @var string $csrfToken
 * @var \Pastebin\Models\Post $post
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>
    <b>Post edit page</b>
    <?php if (!isset($post)) { ?>
        <div>
            <span>Поста не существует или он был удален</span>
        </div>
    <?php } else { ?>
        <form action="/post/update?link=<?php echo $post->postLink(); ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <div>
                <textarea name="text" placeholder="Содержимое поста*" required><?php echo $post->text(); ?></textarea>
            </div>
            <div>
                <input type="text" name="title" value="<?php echo $post->title(); ?>" placeholder="Заголовок">
            </div>
            <div>
                <select name="category_id" required>
                    <option value="" disabled>Категория*</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id(); ?>" <?php echo ($category->id() === $post->category()->id()) ? 'selected' : ''; ?>><?php echo $category->name(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <select name="syntax_id" required>
                    <option value="" disabled>Подсветка синтаксиса*</option>
                    <?php foreach ($syntaxes as $syntax) { ?>
                        <option 
                            value="<?php echo $syntax->id(); ?>" <?php echo ($syntax->id() === $post->syntax()->id()) ? 'selected' : ''; ?> data-codemirror5-mode="<?php echo $syntax->codemirror5Mode(); ?>"><?php echo $syntax->name(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <select name="interval_id" required>
                    <option value="" disabled>Время жизни*</option>
                    <?php foreach ($intervals as $interval) { ?>
                        <option value="<?php echo $interval->id(); ?>" <?php echo ($interval->id() === $post->interval()->id()) ? 'selected' : ''; ?>><?php echo $interval->name(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <select name="post_visibility_id" required>
                    <option value="" disabled>Доступ*</option>
                    <?php foreach ($postVisibilities as $postVisibility) { ?>
                        <option value="<?php echo $postVisibility->id(); ?>" <?php echo ($postVisibility->id() === $post->postVisibility()->id()) ? 'selected' : ''; ?> ><?php echo $postVisibility->name(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <button>Сохранить</button>
        </form>
    <?php } ?>
</body>
</html>