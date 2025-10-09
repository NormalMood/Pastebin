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
 * @var \Pastebin\Kernel\Http\RequestInterface $request
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
    <?php if ($request->input('account_deleted')) { ?>
        <div class="message-wrapper">
            <div class="container">
                <?php $view->component('message', ['type' => 'success', 'messages' => ['Аккаунт удален']]); ?>
            </div>
        </div>
    <?php } ?>
    <div class="container container_background-color container_post-height container_padding-top container_padding-bottom">
        <form class="content-container" action="/" method="post">
            <span class="title title_hidden">Пост</span>
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <textarea id="text" name="text"></textarea>
            <p id="post-text-error" class="validation__message validation__message_margin-top"></p>
            <span class="title">Настройки поста</span>
            <div class="content-container__settings">
                <div class="content-container__input">
                    <?php $view->component('input', ['id' => 'post-title-input', 'type' => 'text', 'name' => 'title', 'placeholder' => 'Заголовок']); ?>
                    <p id="post-title-error" class="validation__message validation__message_margin-top"></p>
                </div>
                <div class="content-container__select content-container__settings-category-id-select">
                    <?php $view->component('select', ['selectId' => 'category-id-select', 'placeholder' => 'Категория*', 'rows' => $categories, 'inputId' => 'category-id-input', 'selectName' => 'category_id']) ?>
                    <p id="post-category-id-error" class="validation__message validation__message_margin-top"></p>
                </div>
                <div class="content-container__select content-container__settings-syntax-id-select">
                    <?php $view->component('select', ['selectId' => 'syntax-id-select', 'placeholder' => 'Подсветка синтаксиса*', 'rows' => $syntaxes, 'inputId' => 'syntax-id-input', 'selectName' => 'syntax_id']); ?>
                    <p id="post-syntax-id-error" class="validation__message validation__message_margin-top"></p>
                </div>
                <div class="content-container__select content-container__settings-interval-id-select">
                    <?php $view->component('select', ['selectId' => 'interval-id-select', 'placeholder' => 'Время жизни*', 'rows' => $intervals, 'inputId' => 'interval-id-input', 'selectName' => 'interval_id']); ?>
                    <p id="post-interval-id-error" class="validation__message validation__message_margin-top"></p>
                </div>
                <?php if ($auth->check()) { ?>
                    <div class="content-container__select content-container__settings-post-visibility-select_auth">
                        <?php $view->component('select', ['selectId' => 'post-visibility-id-select', 'placeholder' => 'Видимость*', 'rows' => $postVisibilities, 'inputId' => 'post-visibility-id-input', 'selectName' => 'post_visibility_id']); ?>
                        <p id="post-post-visibility-id-error" class="validation__message validation__message_margin-top"></p>
                    </div>
                    <?php $view->component('checkbox', ['classes' => ['content-container__settings-highlight-checkbox_auth'], 'id' => 'syntax_highlight_checkbox', 'text' => 'Подсвечивать синтаксис']) ?>
                    <button class="button content-container__settings-button_auth">Создать</button>
                <?php } else { ?>
                    <?php $view->component('checkbox', ['classes' => ['content-container__settings-highlight-checkbox'], 'id' => 'syntax_highlight_checkbox', 'text' => 'Подсвечивать синтаксис']) ?>
                    <button class="button content-container__settings-button">Создать</button>
                <?php } ?>
            </div>
        </form>
    </div>
<?php $view->component('end'); ?>