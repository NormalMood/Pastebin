const imgPasswordEyes = document.querySelectorAll('.input__eye');

if (imgPasswordEyes !== null) {
    imgPasswordEyes.forEach(imgPasswordEye => {
        const parent = imgPasswordEye.parentNode;
        const input = parent.querySelector('input');
        imgPasswordEye.addEventListener('click', (event) => {
            if (imgPasswordEye.classList.contains('input__eye_show-password')) {
                imgPasswordEye.setAttribute('src', '/img/hide_password.png');
                imgPasswordEye.classList.remove('input__eye_show-password');
                input.setAttribute('type', 'text');
                input.focus();
            } else {
                imgPasswordEye.setAttribute('src', '/img/show_password.png');
                imgPasswordEye.classList.add('input__eye_show-password');
                input.setAttribute('type', 'password');
                input.focus();
            }
        });
    });
}