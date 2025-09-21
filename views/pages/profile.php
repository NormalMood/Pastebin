<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Auth\Auth $auth
 * @var \Pastebin\Kernel\Session\Session $session
 * @var \Pastebin\Models\Author $author
 * @var array<\Pastebin\Models\Post> $posts
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <p>Profile page</p><br>
    <?php if (isset($author)) { ?>
        <div>
            <h4><?php echo $author->name(); ?></h4>
            <span><?php echo $author->createdAt(); ?></span>
        </div>
        <?php if (!isset($posts)) { ?>
            <span>Постов нет</span>
        <?php } else { ?>
            <?php if ($session->get($auth->sessionField()) === $author->id()) { ?>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Создан</th>
                            <th>Срок истекает</th>
                            <th>Доступен</th>
                            <th>Синтаксис</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post) { ?>
                            <tr>
                                <td><a href="/post?link=<?php echo $post->postLink(); ?>"><?php echo !empty($post->title()) ? $post->title() : 'Без названия'; ?></a></td>
                                <td><?php echo $post->createdAt(); ?></td>
                                <td><?php echo $post->interval()->name(); ?></td>
                                <td><?php echo $post->postVisibility()->name(); ?></td>
                                <td><?php echo $post->syntax()->name(); ?></td>
                                <td>
                                    <div>
                                        <a href="/post/edit?link=<?php echo $post->postLink(); ?>">Редактировать</a>
                                    </div>
                                    <div>
                                        <form class="deletePostForm" action="/post/delete?link=<?php echo $post->postLink(); ?>" method="post">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                            <input type="hidden" name="u" value="<?php echo $author->name(); ?>">
                                            <button type="submit">Удалить пост</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Создан</th>
                            <th>Срок истекает</th>
                            <th>Синтаксис</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post) { ?>
                            <?php if ($post->postVisibility()->id() !== UNLISTED_POST_VISIBILITY_ID) { ?>
                                <tr>
                                    <td><a href="/post?link=<?php echo $post->postLink(); ?>"><?php echo $post->title(); ?></a></td>
                                    <td><?php echo $post->createdAt(); ?></td>
                                    <td><?php echo $post->interval()->name(); ?></td>
                                    <td><?php echo $post->syntax()->name(); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <b>Профиля не существует</b>
    <?php } ?>
<?php $view->component('end'); ?>