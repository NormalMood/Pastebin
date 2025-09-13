<?php
/**
 * @var \Pastebin\Models\Post $post
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
    <?php if (!isset($post)) { ?>
        <p>Поста не существует или он был удален</p>
    <?php } else { ?>
        <div>
            <a href="#"><?php echo $post->author(); ?></a><br>
            <b><?php echo $post->title(); ?></b><br>
            <div><?php echo $post->syntax()->name(); ?></div>
            <div><?php echo $post->category()->name(); ?></div>
            <div><?php echo $post->text(); ?></div>
            <div><?php echo $post->createdAt(); ?></div>
            <div><?php echo $post->expiresAt(); ?></div>
        </div>
        <div>
            <a href="/post/edit?link=<?php echo $post->postLink(); ?>">Редактировать</ф>
        </div>
        <form action="/post/delete?link=<?php echo $post->postLink(); ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <button>Удалить пост</button>
        </form>
    <?php } ?>
</body>
</html>