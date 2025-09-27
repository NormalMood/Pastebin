const successCopyElement = document.querySelector('.post__success-copy');
const copyButton = document.querySelector('.post__copy-button button');

if ((successCopyElement) !== null && (copyButton !== null)) {
    const postText = document.getElementById('post-text');
    copyButton.addEventListener('click', () => {
        navigator.clipboard.writeText(postText.textContent)
            .then(() => {
                successCopyElement.classList.remove('post__success-copy_hidden');
                setTimeout(() => {
                    successCopyElement.classList.add('post__success-copy_hidden');
                }, 2000);
            })
            .catch(error => {
                alert('Ошибка при копировании: ' + error);
            });
    });
}