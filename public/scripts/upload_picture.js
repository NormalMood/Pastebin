const settingsUploadPictureButton = document.querySelector('#settings-upload-picture-button input');
const settingsSaveForm = document.getElementById('settings-save-form');

if (settingsUploadPictureButton !== null) {
    settingsUploadPictureButton.addEventListener('change', () => {
        if (settingsUploadPictureButton.files.length > 0) {
            settingsSaveForm.submit();
        }
    })
}