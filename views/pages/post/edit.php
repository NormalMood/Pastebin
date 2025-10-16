<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var array<\Pastebin\Models\Category> $categories
 * @var array<\Pastebin\Models\Syntax> $syntaxes
 * @var array<\Pastebin\Models\Interval> $intervals
 * @var array<\Pastebin\Models\PostVisibility> $postVisibilities
 * @var string $csrfToken
 * @var \Pastebin\Models\Post $post
 */
?>
<?php $view->component('start'); ?>
    <?php if ($session->has('errorMessages')) { ?>
        <div class="message-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => $session->getFlush('errorMessages')]); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('postNotSaved')) { ?>
        <div class="message-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('postNotSaved')]]) ?>
            </div>
        </div>
    <?php } ?>
    <div class="container container_background-color container_post-height container_padding-top container_padding-bottom">
        <form class="content-container" action="/post/update?link=<?php echo $post->postLink(); ?>" method="post">
            <span class="title title_hidden">Редактирование поста</span>
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <?php if ($session->has('text_value')) { ?>
                <textarea id="text" name="text"><?php echo htmlspecialchars($session->getFlush('text_value')); ?></textarea>
            <?php } else { ?>
                <textarea id="text" name="text"><?php echo htmlspecialchars($post->text()); ?></textarea>
            <?php } ?>
            <?php $view->component('validation-message', ['id' => 'post-text-error', 'inputName' => 'text']); ?>
            <span class="title">Настройки поста</span>
            <div class="content-container__settings">
                <div class="content-container__input">
                    <?php if ($session->has('title_value')) { ?>
                    <?php $view->component('input', ['id' => 'post-title-input', 'type' => 'text', 'name' => 'title', 'placeholder' => 'Заголовок', 'value' => $session->getFlush('title_value')]); ?>
                    <?php } else { ?>
                    <?php $view->component('input', ['id' => 'post-title-input', 'type' => 'text', 'name' => 'title', 'placeholder' => 'Заголовок', 'value' => "{$post->title()}"]); ?>
                    <?php } ?>
                    <?php $view->component('validation-message', ['id' => 'post-title-error', 'inputName' => 'title']); ?>
                </div>
                <div class="content-container__select content-container__settings-category-id-select">
                    <?php $view->component('select', ['selectId' => 'category-id-select', 'placeholder' => 'Категория*', 'rows' => $categories, 'inputId' => 'category-id-input', 'selectName' => 'category_id', 'value' => $post->category()->id()]) ?>
                    <?php $view->component('validation-message', ['id' => 'post-category-id-error', 'inputName' => 'category_id']); ?>
                </div>
                <div class="content-container__select content-container__settings-syntax-id-select">
                    <?php $view->component('select', ['selectId' => 'syntax-id-select', 'placeholder' => 'Подсветка синтаксиса*', 'rows' => $syntaxes, 'inputId' => 'syntax-id-input', 'selectName' => 'syntax_id', 'value' => $post->syntax()->id()]); ?>
                    <?php $view->component('validation-message', ['id' => 'post-syntax-id-error', 'inputName' => 'syntax_id']); ?>
                </div>
                <div class="content-container__select content-container__settings-interval-id-select">
                    <?php $view->component('select', ['selectId' => 'interval-id-select', 'placeholder' => 'Время жизни*', 'rows' => $intervals, 'inputId' => 'interval-id-input', 'selectName' => 'interval_id', 'value' => $post->interval()->id()]); ?>
                    <?php $view->component('validation-message', ['id' => 'post-interval-id-error', 'inputName' => 'interval_id']); ?>
                </div>
                <div class="content-container__select content-container__settings-post-visibility-select_auth">
                    <?php $view->component('select', ['selectId' => 'post-visibility-id-select', 'placeholder' => 'Видимость*', 'rows' => $postVisibilities, 'inputId' => 'post-visibility-id-input', 'selectName' => 'post_visibility_id', 'value' => $post->postVisibility()->id()]); ?>
                    <?php $view->component('validation-message', ['id' => 'post-post-visibility-id-error', 'inputName' => 'post_visibility_id']); ?>
                </div>
                <?php $view->component('checkbox', ['classes' => ['content-container__settings-highlight-checkbox_auth'], 'id' => 'syntax_highlight_checkbox', 'text' => 'Подсвечивать синтаксис']) ?>
                <button class="button content-container__settings-button_auth">Сохранить</button>
            </div>
        </form>
    </div>
<?php $view->component('end'); ?>