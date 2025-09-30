const successCopyElement = document.querySelector('.post__success-copy');
const copyButton = document.querySelector('.post__copy-button button');

if ((successCopyElement) !== null && (copyButton !== null)) {
    const showSuccessCopyElement = () => {
        successCopyElement.classList.remove('post__success-copy_hidden');
        setTimeout(() => {
            successCopyElement.classList.add('post__success-copy_hidden');
        }, 2000);
    }

    const copyText = (text) => {
        const hiddenTextArea = document.createElement('textarea');
        hiddenTextArea.value = text;
        hiddenTextArea.classList.add('text_hidden');
        document.body.appendChild(hiddenTextArea);
        hiddenTextArea.focus();
        hiddenTextArea.select();
        try {
            const successful = document.execCommand('copy');
            if (!successful) {
                alert('Ошибка копирования');
            } else {
                document.body.removeChild(hiddenTextArea);
                showSuccessCopyElement();
            }
        } catch (error) {
            alert('Ошибка копирования: ' + error);
        }
    }

    const postText = document.getElementById('post-text');
    copyButton.addEventListener('click', () => {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(postText.textContent)
                .then(() => {
                    showSuccessCopyElement();
                })
                .catch(error => {
                    copyText(postText.textContent);
                });
        } else {
            copyText(postText.textContent);
        }
    });
}