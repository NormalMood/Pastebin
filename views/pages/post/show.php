<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var \Pastebin\Models\Post $post
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <?php if (!isset($post)) { ?>
        <p>Поста не существует или он был удален</p>
    <?php } else { ?>
        <div>
            <?php if (!empty($post->author())) { ?>
                <a href="/profile?u=<?php echo $post->author(); ?>"><?php echo $post->author(); ?></a><br>
            <?php } ?>
            <b><?php echo $post->title(); ?></b><br>
            <div><?php echo $post->syntax()->name(); ?></div>
            <div><?php echo $post->category()->name(); ?></div>
            <div><?php echo $post->text(); ?></div>
            <div><?php echo $post->createdAt(); ?></div>
            <div><?php echo $post->expiresAt(); ?></div>
        </div>
        <?php if (!empty($post->authorId()) && $post->authorId() === $session->get($auth->sessionField())) { ?>
            <div>
                <a href="/post/edit?link=<?php echo $post->postLink(); ?>">Редактировать</a>
            </div>
            <form class="deletePostForm" action="/post/delete?link=<?php echo $post->postLink(); ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <button>Удалить пост</button>
            </form>
        <?php } ?>
    <?php } ?>
<?php $view->component('end'); ?>