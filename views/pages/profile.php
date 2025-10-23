<?php

use Pastebin\Mappers\IntervalMapper;
use Pastebin\Mappers\PostVisibilityMapper;

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
    <?php if ($session->has('postSaved')) { ?>
        <div class="message-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'success', 'messages' => [$session->getFlush('postSaved')]]) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('postDeleted')) { ?>
        <div class="message-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'success', 'messages' => [$session->getFlush('postDeleted')]]) ?>
            </div>
        </div>
    <?php } ?>
    <div class="container container_background-color container_height container_padding-top container_flex">
        <?php if (isset($author)) { ?>
            <div class="author__metadata">
                <?php if ($author->id() !== $session->get($auth->sessionField())) { ?>
                    <a class="author__link" href="/profile?u=<?php echo $author->name(); ?>">
                        <img class="author__picture" <?php echo !empty($author->pictureLink()) ? "src=\"{$author->pictureLink()}\"" : 'src="/img/default_picture.png"'; ?>>
                        <span class="author__name"><?php echo htmlspecialchars($author->name()); ?></span>
                    </a>
                <?php } ?>
                <div class="author__created-at">
                    <img src="/img/date.png">
                    <span><?php echo $author->createdAt(); ?></span>
                </div>
            </div>
            <?php if (empty($posts)) { ?>
                <div class="no-posts-message">
                    <span>Постов нет</span>
                </div>
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
                                    <th>Время жизни</th>
                                    <th>Видимость</th>
                                    <th>Синтаксис</th>
                                    <th class="table__copy-button-column">Ссылка</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post) { ?>
                                    <tr>
                                        <td><a class="link" href="/post?link=<?php echo $post->postLink(); ?>"><?php echo (($post->title() !== null) && ($post->title() !== '')) ? htmlspecialchars($post->title()) : 'Без названия'; ?></a></td>
                                        <td class="post__created-at"><?php echo $post->createdAt(); ?></td>
                                        <td class="post__expires-at"><?php echo $post->expiresAt(); ?></td>
                                        <td><?php echo IntervalMapper::getExpiration($post->interval()->name()); ?></td>
                                        <td><?php echo PostVisibilityMapper::getValue($post->postVisibility()->name()); ?></td>
                                        <td><?php echo $post->syntax()->name(); ?></td>
                                        <td class="table__copy-button-column">
                                            <div class="table__copy-button">
                                                <span class="success-copy success-copy_hidden"></span>
                                                <img class="copy__img_profile" src="/img/copy_black.png" title="Копировать ссылку" data-post-link="<?php echo "http://{$_ENV['SERVER']}/post?link={$post->postLink()}"; ?>">
                                            </div>
                                        </td>
                                        <td class="table__actions">
                                            <div class="post__actions post__actions-2-columns">
                                                <a href="/post/edit?link=<?php echo $post->postLink(); ?>" title="Редактировать"><img class="post__actions-img" src="/img/edit_post.png"></a>
                                                <form class="deletePostForm" action="/post/delete?link=<?php echo $post->postLink(); ?>" method="post">
                                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                                    <input type="hidden" name="u" value="<?php echo $author->name(); ?>">
                                                    <input class="post__actions-img" type="image" src="/img/delete_post.png" title="Удалить">
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="bottom-message">
                        <?php
                            $authorName = htmlspecialchars($author->name());
                            $firstParagraph = "Добро пожаловать, {$authorName}, на Вашу персональную страницу! Чтобы другой человек увидел ее, отправьте ему ссылку<br><br>";
                            $secondParagraph = "Только Вы можете видеть в таблице посты, доступные по ссылке. Также редактирование и удаление Ваших постов доступно только Вам<br><br>";
                            $allPostsCount = count($posts);
                            $unlistedPostsCount = count(array_filter($posts, fn ($post) => $post->postVisibility()->id() === UNLISTED_POST_VISIBILITY_ID));
                            $publicPostsCount = $allPostsCount - $unlistedPostsCount;
                            $thirdParagraph = "Статистика:<br>Общее количество постов: $allPostsCount<br>Количество публичных постов: $publicPostsCount<br>Количество постов, доступных по ссылке: $unlistedPostsCount";
                        ?>
                        <?php $view->component('message', ['type' => 'info', 'messages' => [$firstParagraph . $secondParagraph . $thirdParagraph]]); ?>
                    </div>
                <?php } else { ?>
                    <?php
                        $publicPost = current(array_filter($posts, fn ($post) => $post->postVisibility()->id() !== UNLISTED_POST_VISIBILITY_ID));
                    ?>
                    <?php if (empty($publicPost)) { ?>
                        <div class="no-posts-message">
                            <span>Публичных постов нет</span>
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
                                        <th>Время жизни</th>
                                        <th>Синтаксис</th>
                                        <th class="table__copy-button-column">Ссылка</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post) { ?>
                                        <?php if ($post->postVisibility()->id() !== UNLISTED_POST_VISIBILITY_ID) { ?>
                                            <tr>
                                                <td><a class="link" href="/post?link=<?php echo $post->postLink(); ?>"><?php echo (($post->title() !== null) && ($post->title() !== '')) ? htmlspecialchars($post->title()) : 'Без названия'; ?></a></td>
                                                <td class="post__created-at"><?php echo $post->createdAt(); ?></td>
                                                <td class="post__expires-at"><?php echo $post->expiresAt(); ?></td>
                                                <td><?php echo IntervalMapper::getExpiration($post->interval()->name()); ?></td>
                                                <td><?php echo $post->syntax()->name(); ?></td>
                                                <td class="table__copy-button-column">
                                                    <div class="table__copy-button">
                                                        <span class="success-copy success-copy_hidden"></span>
                                                        <img class="copy__img_profile" src="/img/copy_black.png" title="Копировать ссылку" data-post-link="<?php echo "http://{$_ENV['SERVER']}/post?link={$post->postLink()}"; ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } else { ?>
            <b>Профиля не существует</b>
        <?php } ?>
    </div>
<?php $view->component('end'); ?>