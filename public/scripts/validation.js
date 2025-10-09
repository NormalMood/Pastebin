/* Login page */

const signinNameInput = document.getElementById('signin-name-input');
const signinNameError = document.getElementById('signin-name-error');
const signinPasswordInput = document.getElementById('signin-password-input');
const signinPasswordError = document.getElementById('signin-password-error');

const validateInput = (field, inputElement, errorElement, inputConfirmationElement) => {
    inputElement.addEventListener('blur', () => {
        let url;
        if (inputConfirmationElement === undefined) {
            url = `/validate?field=${field}&value=${encodeURIComponent(inputElement.value.trim())}`;
        } else {
            url = `/validate?field=${field}&value=${encodeURIComponent(inputElement.value.trim())}&value_confirmation=${encodeURIComponent(inputConfirmationElement.value.trim())}`;
        }
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data['message'] !== 'OK') {
                inputElement.classList.add('input_error');
                errorElement.textContent = data['message'];
                errorElement.classList.add('validation__message_visible');
            } else {
                inputElement.classList.remove('input_error');
                errorElement.classList.remove('validation__message_visible');
            }
        })
        .catch(error => {
            console.log(error);
        });
    });
    if (inputConfirmationElement !== undefined) {
        inputElement.addEventListener('input', () => {
            if (errorElement.textContent.includes('не совпадает')) {
                if (inputElement.value === inputConfirmationElement.value) {
                    inputElement.classList.remove('input_error');
                    errorElement.classList.remove('validation__message_visible');
                } else {
                    inputElement.classList.add('input_error');
                    errorElement.classList.add('validation__message_visible');
                }
            }
        })
        inputConfirmationElement.addEventListener('input', () => {
            if (errorElement.textContent.includes('не совпадает')) {
                if (inputElement.value === inputConfirmationElement.value) {
                    inputElement.classList.remove('input_error');
                    errorElement.classList.remove('validation__message_visible');
                } else {
                    inputElement.classList.add('input_error');
                    errorElement.classList.add('validation__message_visible');
                }
            }
        })
    }
}

const validateSelect = (field, selectElement, inputElement, errorElement) => {
    const fetchValidationResponse = () => {
        fetch(`/validate?field=${field}&value=${encodeURIComponent(inputElement.value.trim())}`)
        .then(response => response.json())
        .then(data => {
            if (data['message'] !== 'OK') {
                selectElement.classList.add('input_error');
                errorElement.textContent = data['message'];
                errorElement.classList.add('validation__message_visible');
            } else {
                selectElement.classList.remove('input_error');
                errorElement.classList.remove('validation__message_visible');
            }
        })
        .catch(error => {
            console.log(error)
        })
    }
    selectElement.addEventListener('blur', fetchValidationResponse);
    inputElement.addEventListener('input', fetchValidationResponse);
}



if ((signinNameInput !== null) && (signinPasswordInput !== null)) {
    validateInput('login_name', signinNameInput, signinNameError);
    validateInput('password', signinPasswordInput, signinPasswordError);
}

const forgotNameEmailInput = document.getElementById('forgot-name-email-input');
const forgotNameEmailError = document.getElementById('forgot-name-email-error');

if (forgotNameEmailInput !== null) {
    validateInput('forgot-name_email', forgotNameEmailInput, forgotNameEmailError);
}

const forgotPasswordNameInput = document.getElementById('forgot-password-name-input');
const forgotPasswordNameError = document.getElementById('forgot-password-name-error');

if (forgotPasswordNameInput !== null) {
    validateInput('forgot-password_name', forgotPasswordNameInput, forgotPasswordNameError);
}

/* Registration page */

const signupNameInput = document.getElementById('signup-name-input');
const signupNameError = document.getElementById('signup-name-error');

const signupEmailInput = document.getElementById('signup-email-input');
const signupEmailError = document.getElementById('signup-email-error');

const signupPasswordInput = document.getElementById('signup-password-input');
const signupPasswordError = document.getElementById('signup-password-error');

if ((signupNameInput !== null) && (signupEmailInput !== null) && (signupPasswordInput !== null)) {
    validateInput('register_name', signupNameInput, signupNameError);
    validateInput('register_email', signupEmailInput, signupEmailError);
    validateInput('password', signupPasswordInput, signupPasswordError);
}

/* Reset password page */

const resetPasswordPasswordInput = document.getElementById('reset-password-password-input');
const resetPasswordPasswordError = document.getElementById('reset-password-password-error');

if (resetPasswordPasswordInput !== null) {
    validateInput('password', resetPasswordPasswordInput, resetPasswordPasswordError);
}

/* Create post page */

const postTextEditor = document.querySelector('.CodeMirror');
const postTextTextarea = document.getElementById('text');
const postTextError = document.getElementById('post-text-error');

const postTitleInput = document.getElementById('post-title-input');
const postTitleError = document.getElementById('post-title-error');

const postCategoryIdSelect = document.getElementById('category-id-select');
const postCategoryIdInput = document.getElementById('category-id-input');
const postCategoryIdError = document.getElementById('post-category-id-error');

const postSyntaxIdSelect = document.getElementById('syntax-id-select');
const postSyntaxIdInput = document.getElementById('syntax-id-input');
const postSyntaxIdError = document.getElementById('post-syntax-id-error');

const postIntervalIdSelect = document.getElementById('interval-id-select');
const postIntervalIdInput = document.getElementById('interval-id-input');
const postIntervalIdError = document.getElementById('post-interval-id-error');

const postPostVisibilityIdSelect = document.getElementById('post-visibility-id-select');
const postPostVisibilityIdInput = document.getElementById('post-visibility-id-input');
const postPostVisibilityIdError = document.getElementById('post-post-visibility-id-error');

const focusObserver = new MutationObserver((mutationList) => {
    for (const mutation of mutationList) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
            if (!postTextEditor.classList.contains('CodeMirror-focused')) {
                fetch('/validate?field=post_text&value=' + encodeURIComponent(postTextTextarea.value.trim()))
                .then(response => response.json())
                .then(data => {
                    if (data['message'] !== 'OK') {
                        postTextEditor.classList.add('input_error');
                        postTextError.textContent = data['message'];
                        postTextError.classList.add('validation__message_visible');
                    } else {
                        postTextEditor.classList.remove('input_error');
                        postTextError.classList.remove('validation__message_visible');
                    }
                })
                .catch(error => {
                    console.log(error);
                })
            }
        }
    }
});

const focusObserverConfig = {
    attributes: true
};

if (postTextEditor !== null) {
    focusObserver.observe(postTextEditor, focusObserverConfig);

    validateInput('post_title', postTitleInput, postTitleError);

    validateSelect('post_category_id', postCategoryIdSelect, postCategoryIdInput, postCategoryIdError);
    validateSelect('post_syntax_id', postSyntaxIdSelect, postSyntaxIdInput, postSyntaxIdError);
    validateSelect('post_interval_id', postIntervalIdSelect, postIntervalIdInput, postIntervalIdError);
} else {
    focusObserver.disconnect();
}

if (postPostVisibilityIdSelect !== null) {
    validateSelect('post_post_visibility_id', postPostVisibilityIdSelect, postPostVisibilityIdInput, postPostVisibilityIdError);
}

/* Settings page */

//Account option
const deleteAccountPasswordInput = document.getElementById('delete-account-password-input');
const deleteAccountPasswordError = document.getElementById('delete-account-password-error');

if (deleteAccountPasswordInput !== null) {
    validateInput('password', deleteAccountPasswordInput, deleteAccountPasswordError);
}

//Password option
const changePasswordPasswordInput = document.getElementById('change-password-password-input');
const changePasswordPasswordError = document.getElementById('change-password-password-error');

const changePasswordNewPasswordInput = document.getElementById('change-password-new-password-input');
const changePasswordNewPasswordError = document.getElementById('change-password-new-password-error');

const changePasswordNewPasswordConfirmationInput = document.getElementById('change-password-new-password-confirmation-input');
const changePasswordNewPasswordConfirmationError = document.getElementById('change-password-new-password-confirmation-error');

if (changePasswordPasswordInput !== null) {
    validateInput('password', changePasswordPasswordInput, changePasswordPasswordError);
    validateInput(
        'new_password', 
        changePasswordNewPasswordInput, 
        changePasswordNewPasswordError, 
        changePasswordNewPasswordConfirmationInput
    );
    validateInput('new_password_confirmation', changePasswordNewPasswordConfirmationInput, changePasswordNewPasswordConfirmationError);
}