const textarea = document.querySelector('.textarea textarea');
const styleTag = document.querySelector('style[nonce]');

if ((textarea !== null) && (styleTag !== null)) {
    const autoResize = (event) => {
        const textarea = event.target;
        styleTag.textContent = ".textarea_height { height: auto; }";
        styleTag.textContent = `.textarea_height { height: ${textarea.scrollHeight}px; }`;
    }
    textarea.addEventListener('input', autoResize);
}