const signInForm = document.getElementById('signInForm');
const forgotNameForm = document.getElementById('forgotNameForm');
const forgotPasswordForm = document.getElementById('forgotPasswordForm');

const forgotNameSpans = document.querySelectorAll('.forgotName');
const forgotPasswordSpans = document.querySelectorAll('.forgotPassword');
const backSpans = document.querySelectorAll('.back');

if (forgotNameSpans !== null) {
    forgotNameSpans.forEach(forgotNameSpan => {
        forgotNameSpan.addEventListener('click', function () {
            forgotNameForm.classList.remove('credentials__form_hidden');
            signInForm.classList.add('credentials__form_hidden');
            forgotPasswordForm.classList.add('credentials__form_hidden');
        });
    });
};

if (forgotPasswordSpans !== null) {
    forgotPasswordSpans.forEach(forgotPasswordSpan => {
        forgotPasswordSpan.addEventListener('click', function () {
            forgotPasswordForm.classList.remove('credentials__form_hidden');
            signInForm.classList.add('credentials__form_hidden');
            forgotNameForm.classList.add('credentials__form_hidden');
        });
    });
};

if (backSpans !== null) {
    backSpans.forEach(backSpan => {
        backSpan.addEventListener('click', function () {
            signInForm.classList.remove('credentials__form_hidden');
            forgotNameForm.classList.add('credentials__form_hidden');
            forgotPasswordForm.classList.add('credentials__form_hidden');
        });
    });
};