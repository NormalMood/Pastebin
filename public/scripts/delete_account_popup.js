const openDeleteAccountPopupBtn = document.getElementById('open-delete-account-popup');
const closeDeleteAccountPopupBtn = document.getElementById('close-delete-account-popup');
const deleteAccountPopup = document.getElementById('delete-account-popup');

if (openDeleteAccountPopupBtn !== null) {
    openDeleteAccountPopupBtn.addEventListener('click', () => {
        deleteAccountPopup.classList.add('delete-account-popup_visible');
    });
    closeDeleteAccountPopupBtn.addEventListener('click', () => {
        deleteAccountPopup.classList.remove('delete-account-popup_visible');
    });

    deleteAccountPopup.addEventListener('click', (e) => {
        if (e.target === deleteAccountPopup) {
            deleteAccountPopup.classList.remove('delete-account-popup_visible');
        }
    });
}