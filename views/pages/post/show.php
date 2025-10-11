<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var \Pastebin\Models\Post $post
 * @var \Pastebin\Models\Author $author
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <?php if (!isset($post)) { ?>
        <div class="message-wrapper message-wrapper_height">
            <div class="container">
                <?php $view->component('message', ['type' => 'info', 'messages' => ['Поста не существует или он был удален']]); ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="container container_background-color container_height container_padding-top container_flex">
            <?php if (($post->author() !== null) && ($post->author() !== '')) { ?>
                <a class="author__link" href="/profile?u=<?php echo $post->author(); ?>">
                    <img class="author__picture" <?php echo !empty($author->pictureLink()) ? "src=\"{$author->pictureLink()}\"" : 'src="/img/default_picture.png"'; ?>>
                    <span class="author__name"><?php echo $post->author(); ?></span>
                </a>
            <?php } else { ?>
                <a class="author__link author__link_guest">
                    <img class="author__picture" src="/img/default_picture.png">
                    <span>Гость</span>
                </a>
            <?php } ?>
            <div <?php echo (($post->title() !== null) && ($post->title() !== '')) ? 'class="post__metadata-top"' : 'class="post__metadata-top post__metadata-top_column-gap-unset post__metadata-top_row-gap-unset"' ?>>
                <span class="post__title"><?php echo htmlspecialchars($post->title()); ?></span>
                <div class="post__datetime-metadata">
                    <div class="post__datetime-metadata-created-at">
                        <img src="/img/date.png">
                        <span><?php echo $post->createdAt(); ?></span>
                    </div>
                    <div class="post__datetime-metadata-expires-at">
                        <img src="/img/time.png">
                        <span><?php echo $post->expiresAt(); ?></span>
                    </div>
                </div>
            </div>
            <div class="post">
                <div id="post-text" hidden><?php echo htmlspecialchars($post->text()); ?></div>
                <div class="post__metadata-above-post">
                    <div class="post__metadata-tags">
                        <div class="post__syntax-size">
                            <span class="post__metadata-tag" id="syntax" data-codemirror5-mode="<?php echo $post->syntax()->codemirror5Mode(); ?>"><?php echo $post->syntax()->name(); ?></span>
                            <?php
                                $textBytes = strlen($post->text());
                                $textKB = round(num: $textBytes / 1024, precision: 2);
                                $textMB = round(num: $textBytes / 1024 / 1024, precision: 2);
                                $textSize = '';
                                if ($textBytes < 1024) {
                                    $textSize = "$textBytes Б";
                                } elseif ($textKB < 1024) {
                                    $textSize = "$textKB КБ";
                                } else {
                                    $textSize = "$textMB МБ";
                                }
                            ?>
                            <span class="post__metadata-tag"><?php echo $textSize; ?></span>
                        </div>
                        <span class="post__metadata-tag"><?php echo $post->category()->name(); ?></span>
                    </div>
                    <div class="post__actions">
                        <?php if (!empty($post->authorId()) && $post->authorId() === $session->get($auth->sessionField())) { ?>     
                            <div class="post__copy-button">
                                <span class="post__success-copy post__success-copy_hidden"></span>
                                <button class="button">Копировать</button>
                            </div>
                            <a href="/post/edit?link=<?php echo $post->postLink(); ?>"><img class="post__actions-img" src="/img/edit_post.png"></a>
                            <form class="deletePostForm" action="/post/delete?link=<?php echo $post->postLink(); ?>" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input class="post__actions-img" type="image" src="/img/delete_post.png">
                            </form>
                        <?php } else { ?>
                            <div class="post__copy-button post__copy-button_span-3">
                                <span class="post__success-copy post__success-copy_hidden"></span>
                                <button class="button">Копировать</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div id="post-content"></div>
            </div>
            <?php if (($post->author() === null) || ($post->author() === '')) { ?>
                <div class="bottom-message">
                    <?php $view->component('message', ['type' => 'info', 'messages' => ['Еще нет аккаунта? <a class="link" href="/signup">Зарегистрируйтесь</a>, и у Вас будет больше возможностей!']]); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php $view->component('end'); ?>