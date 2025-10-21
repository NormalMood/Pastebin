const showSuccessCopyElement = (successCopyElement) => {
    successCopyElement.classList.remove('success-copy_hidden');
    setTimeout(() => {
        successCopyElement.classList.add('success-copy_hidden');
    }, 2000);
}

const copyText = (text, successCopyElement) => {
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
            showSuccessCopyElement(successCopyElement);
        }
    } catch (error) {
        alert('Ошибка копирования: ' + error);
    }
}

const copyContent = (content, successCopyElement) => {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(content)
            .then(() => {
                showSuccessCopyElement(successCopyElement);
            })
            .catch(error => {
                copyText(content, successCopyElement);
            });
    } else {
        copyText(content, successCopyElement);
    }
}

// Post page

const postSuccessCopyElement = document.querySelector('.post__copy-button span');
const postCopyButton = document.querySelector('.post__copy-button button');

const linkSuccessCopyElementPostPage = document.querySelector('.post__copy-link-button span');
const linkCopyButtonPostPage = document.querySelector('.post__copy-link-button button');

if ((postSuccessCopyElement) !== null && (postCopyButton !== null)) {

    const postText = document.getElementById('post-text');
    postCopyButton.addEventListener('click', () => {
        copyContent(postText.textContent, postSuccessCopyElement);
    });

    linkCopyButtonPostPage.addEventListener('click', () => {
        copyContent(linkCopyButtonPostPage.getAttribute('data-post-link'), linkSuccessCopyElementPostPage);
    });
}

// Profile page

const copyLinkImagesProfile = document.querySelectorAll('.copy__img_profile');

if (copyLinkImagesProfile !== null) {
    copyLinkImagesProfile.forEach(copyLinkImgProfile => {
        const parent = copyLinkImgProfile.parentNode;
        const linkSuccessCopyElement = parent.querySelector('span');
        copyLinkImgProfile.addEventListener('click', () => {
            copyContent(copyLinkImgProfile.getAttribute('data-post-link'), linkSuccessCopyElement);
        });
    })
}