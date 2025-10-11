<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 * @var \Pastebin\Kernel\Session\SessionInterface $session
 * @var \Pastebin\Kernel\Auth\AuthInterface $auth
 * @var string $userName
 * @var string $email
 * @var string $csrfToken
 */
?>
<?php $view->component('start'); ?>
    <?php if ($session->has('userVerified')) { ?>
        <div class="message-wrapper message-wrapper_background-color">
            <div class="container container_padding-top-settings-page">
                <?php $view->component('message', ['type' => 'success', 'messages' => [$session->getFlush('userVerified')]]); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('errorMessages')) { ?>
        <div class="message-wrapper message-wrapper_background-color">
            <div class="container container_padding-top-settings-page">
                <?php $view->component('message', ['type' => 'error', 'messages' => $session->getFlush('errorMessages')]); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('settingsSaved')) { ?>
        <div class="message-wrapper message-wrapper_background-color">
            <div class="container container_padding-top-settings-page">
                <?php $view->component('message', ['type' => 'success', 'messages' => [$session->getFlush('settingsSaved')]]); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('image')) { ?>
        <div id="picture-error-message-wrapper" class="message-wrapper message-wrapper_background-color">
            <div class="container container_padding-top-settings-page">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('image')]]); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('incorrectPassword')) { ?>
        <div id="incorrect-password-message-wrapper" class="message-wrapper message-wrapper_background-color">
            <div class="container container_padding-top-settings-page">
                <?php $view->component('message', ['type' => 'error', 'messages' => [$session->getFlush('incorrectPassword')]]); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($session->has('resetPassword')) { ?>
        <div class="message-wrapper message-wrapper_background-color">
            <div class="container container_padding-top-settings-page">
                <?php $view->component('message', ['type' => 'success', 'messages' => [$session->getFlush('resetPassword')]]); ?>
            </div>
        </div>
    <?php } ?>
    <section class="settings">
        <div class="container">
            <form class="settings__account settings_hidden" action="/picture" method="post" enctype="multipart/form-data">
                <div class="settings__title-wrapper">
                    <img class="settings__back-img" src="/img/arrow_back.png">
                    <span class="title">Аккаунт</span>
                </div>
                <div class="settings__picture">
                    <img class="settings__picture-img" <?php echo !empty($auth->user()->pictureLink()) ? "src=\"{$auth->user()->pictureLink()}\"" : 'src="/img/default_picture.png"'; ?>>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    <input type="hidden" name="u" value="<?php echo $userName; ?>">
                    <?php $view->component(name: 'upload-button', data: ['name' => 'picture', 'text' => 'Выбрать фото', 'accept' => '.jpeg, .jpg, .png']); ?>
                </div>
                <div>
                    <div class="settings__account-info">
                        <div class="settings__account-info-labels">
                            <span>Имя:</span>
                            <span>E-mail:</span>
                        </div>
                        <div class="settings__account-info-content">
                            <span> <?php echo htmlspecialchars($userName); ?></span>
                            <span> <?php echo htmlspecialchars($email); ?></span>
                        </div>
                    </div>
                </div>
                <button class="button" type="submit">Сохранить</button>
                <button class="button button_delete-account" id="open-delete-account-popup" type="button">Удалить аккаунт</button>
            </form>
            <form class="settings__password settings_hidden" action="/change-password" method="post">
                <div class="settings__title-wrapper">
                    <img class="settings__back-img" src="/img/arrow_back.png">
                    <span class="title">Пароль</span>
                </div>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="u" value="<?php echo $userName; ?>">
                <?php $view->component('input', ['id' => 'change-password-password-input', 'type' => 'password', 'name' => 'old_password', 'placeholder' => 'Старый пароль*']) ?>
                <?php $view->component('validation-message', ['id' => 'change-password-password-error', 'inputName' => 'old_password']); ?>
                <?php $view->component('input', ['id' => 'change-password-new-password-input', 'type' => 'password', 'name' => 'new_password', 'placeholder' => 'Новый пароль*']) ?>
                <?php $view->component('validation-message', ['id' => 'change-password-new-password-error', 'inputName' => 'new_password']); ?>
                <?php $view->component('input', ['id' => 'change-password-new-password-confirmation-input', 'type' => 'password', 'name' => 'new_password_confirmation', 'placeholder' => 'Еще раз новый пароль*']) ?>
                <?php $view->component('validation-message', ['id' => 'change-password-new-password-confirmation-error', 'inputName' => 'new_password_confirmation']); ?>
                <button class="button">Изменить пароль</button>
            </form>
        </div>
        <div class="settings__menu">
            <div class="container">
                <span class="title">Настройки</span>
                <ul class="settings__menu-options">
                    <li class="settings__menu-option" id="settings-account-option" tabindex="1">
                        <img class="settings__menu-option-img" src="/img/account.png">
                        <span>Аккаунт</span>
                        <img class="settings__move-to-img" src="/img/arrow_move_to.png">
                    </li>
                    <li class="settings__menu-option" id="settings-password-option" tabindex="1">
                        <img class="settings__menu-option-img" src="/img/password.png">
                        <span>Пароль</span>
                        <img class="settings__move-to-img" src="/img/arrow_move_to.png">
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="delete-account-popup" id="delete-account-popup">
        <div class="delete-account-popup__content">
            <img id="close-delete-account-popup" src="/img/close.png">
            <form id="deleteAccountForm" action="/delete-account" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="u" value="<?php echo $userName; ?>">
                <?php $view->component('message', ['type' => 'error', 'messages' => ['После удаления <b>не получится создать аккаунт с этим же именем, и все посты будут необратимо удалены</b>']]); ?>
                <?php $view->component('input', ['id' => 'delete-account-password-input', 'type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль*']) ?>
                <?php $view->component('validation-message', ['id' => 'delete-account-password-error', 'inputName' => 'password']); ?>
                <button class="button button_delete-account">Удалить аккаунт</button>
            </form>
        </div>
    </div>
<?php $view->component('end'); ?>