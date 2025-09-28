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
    <div class="container container_background-color container_height container_padding-top container_flex">
        <?php if (isset($author)) { ?>
            <div class="author__metadata">
                <?php if ($author->id() !== $session->get($auth->sessionField())) { ?>
                    <a class="author__link" href="/profile?u=<?php echo $author->name(); ?>">
                        <img class="author__picture" src="/img/default_picture.png">
                        <span class="author__name"><?php echo $author->name(); ?></span>
                    </a>
                <?php } ?>
                <div class="author__created-at">
                    <img src="/img/date.png">
                    <span><?php echo explode(' ', $author->createdAt())[0]; ?></span>
                </div>
            </div>
            <?php if (!isset($posts)) { ?>
                <span>Постов нет</span>
            <?php } else { ?>
                <?php if ($session->get($auth->sessionField()) === $author->id()) { ?>
                    <div class="table">
                        <table>
                            <caption>Мои посты</caption>
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
                                            <div class="post__actions post__actions-2-columns">
                                                <a href="/post/edit?link=<?php echo $post->postLink(); ?>"><img class="post__actions-img" src="/img/edit_post.png"></a>
                                                <form class="deletePostForm" action="/post/delete?link=<?php echo $post->postLink(); ?>" method="post">
                                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                                    <input type="hidden" name="u" value="<?php echo $author->name(); ?>">
                                                    <input class="post__actions-img" type="image" src="/img/delete_post.png">
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="table">
                        <table>
                            <caption>Посты</caption>
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
                                            <td><a href="/post?link=<?php echo $post->postLink(); ?>"><?php echo !empty($post->title()) ? $post->title() : 'Без названия'; ?></a></td>
                                            <td><?php echo $post->createdAt(); ?></td>
                                            <td><?php echo $post->interval()->name(); ?></td>
                                            <td><?php echo $post->syntax()->name(); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } else { ?>
            <b>Профиля не существует</b>
        <?php } ?>
    </div>
<?php $view->component('end'); ?>