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
    <div class="container container_background-color container_height container_padding-top">
        <form class="content-container" action="/" method="post">
            <span class="title title_hidden">Пост</span>
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <textarea id="text" name="text"></textarea>
            <span class="title">Настройки поста</span>
            <div class="content-container__settings">
                <?php $view->component('input', ['type' => 'text', 'name' => 'title', 'placeholder' => 'Заголовок']); ?>
                <?php $view->component('select', ['classes' => ['content-container__settings-category-id-select'], 'placeholder' => 'Категория*', 'rows' => $categories, 'selectId' => 'category-id-input', 'selectName' => 'category_id']) ?>
                <?php $view->component('select', ['classes' => ['content-container__settings-syntax-id-select'], 'placeholder' => 'Подсветка синтаксиса*', 'rows' => $syntaxes, 'selectId' => 'syntax-id-input', 'selectName' => 'syntax_id']); ?>
                <?php $view->component('select', ['classes' => ['content-container__settings-interval-id-select'], 'placeholder' => 'Время жизни*', 'rows' => $intervals, 'selectId' => 'interval-id-input', 'selectName' => 'interval_id']); ?>
                <?php if ($auth->check()) { ?>
                    <?php $view->component('select', ['classes' => ['content-container__settings-post-visibility-select_auth'], 'placeholder' => 'Доступ*', 'rows' => $postVisibilities, 'selectId' => 'post-visibility-id-input', 'selectName' => 'post_visibility_id']); ?>
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