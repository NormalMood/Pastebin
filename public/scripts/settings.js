const settingsAccount = document.querySelector('.settings__account');
const settingsPassword = document.querySelector('.settings__password');
const settingsBackArrows = document.querySelectorAll('.settings__back-img');

if ((settingsAccount !== null) && (settingsPassword !== null) && (settingsBackArrows !== null)) {
    settingsBackArrows.forEach(settingsBackArrow => {
        settingsBackArrow.addEventListener('click', () => {
            settingsAccount.classList.add('settings_hidden');
            settingsPassword.classList.add('settings_hidden');
            settingsAccountOption.classList.remove('settings__menu-option_active');
            settingsPasswordOption.classList.remove('settings__menu-option_active');
        });
    });
    const settingsAccountOption = document.getElementById('settings-account-option');
    const settingsPasswordOption = document.getElementById('settings-password-option');

    settingsAccountOption.addEventListener('click', () => {
        settingsAccount.classList.remove('settings_hidden');
        settingsPassword.classList.add('settings_hidden');
        settingsAccountOption.classList.add('settings__menu-option_active');
        settingsPasswordOption.classList.remove('settings__menu-option_active');
    });
    settingsPasswordOption.addEventListener('click', () => {
        settingsAccount.classList.add('settings_hidden');
        settingsPassword.classList.remove('settings_hidden');
        settingsPasswordOption.classList.add('settings__menu-option_active');
        settingsAccountOption.classList.remove('settings__menu-option_active');
    });

    const showSettingsAccount = () => {
        if ((window.innerWidth >= 1400) &&
            (settingsAccount.classList.contains('settings_hidden') && settingsPassword.classList.contains('settings_hidden'))) {
            settingsAccount.classList.remove('settings_hidden');
            settingsAccountOption.classList.add('settings__menu-option_active');
        }
    };
    showSettingsAccount();
    window.addEventListener('resize', showSettingsAccount);
}