/*
 * Create Post page
*/

const textTextarea = document.getElementById('text');
const syntaxHighlightCheckbox = document.getElementById('syntax_highlight_checkbox');
const syntaxInput = document.getElementById('syntax-id-input');

let editor = null;

if ((textTextarea !== null) && (syntaxHighlightCheckbox !== null) && (syntaxInput !== null)) {
    editor = CodeMirror.fromTextArea(textTextarea, {
        theme: 'default',
        mode: 'text/plain',
        lineNumbers: false,
    });
    editor.on('change', (instance, changeObj) => {
        textTextarea.textContent = editor.getValue();
    });
    const syntaxOptionSelected = (event) => {
        const syntaxOption = document.querySelector(`.select__options div[data-value="${syntaxInput.value}"][data-codemirror5-mode]`);
        if (syntaxOption !== null) {
            const codeMirror5Mode = syntaxOption.getAttribute('data-codemirror5-mode');
            editor.setOption('mode', codeMirror5Mode);
        } 
    }
    syntaxHighlightCheckbox.addEventListener('change', () => {
        if (syntaxHighlightCheckbox.checked) {
            syntaxOptionSelected();
            syntaxInput.addEventListener('input', syntaxOptionSelected);
        } else {
            syntaxInput.removeEventListener('input', syntaxOptionSelected);
            editor.setOption('mode', null);
        }
    });
    
}

const codeMirrorEditor = document.querySelector('div.CodeMirror');

const observer = new MutationObserver((mutationList) => {
    for (const mutation of mutationList) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
            if (codeMirrorEditor.classList.contains('CodeMirror-focused')) {
                codeMirrorEditorPlaceholder.classList.add('CodeMirror__placeholder_top');
            } else {
                if (editor.getValue() === '')
                    codeMirrorEditorPlaceholder.classList.remove('CodeMirror__placeholder_top');
            }
        }
    }
})

const observerConfig = {
    attributes: true
};

const codeMirrorEditorPlaceholder = document.createElement('div');
codeMirrorEditorPlaceholder.textContent = 'Содержимое поста*';
codeMirrorEditorPlaceholder.classList.add('CodeMirror__placeholder');

if (codeMirrorEditor !== null) {
    if (editor.getValue() !== '') {
        codeMirrorEditorPlaceholder.classList.add('CodeMirror__placeholder_top');
    }
    codeMirrorEditor.appendChild(codeMirrorEditorPlaceholder);
    observer.observe(codeMirrorEditor, observerConfig);
} else {
    observer.disconnect();
}


/**
 * Post page
 */

const postContent = document.getElementById('post-content');

if (postContent !== null) {
    const mode = document.getElementById('syntax').getAttribute('data-codemirror5-mode');
    const postText = document.getElementById('post-text').textContent;
    const postContentContainer = CodeMirror(postContent, {
        theme: 'default',
        mode: mode,
        value: postText,
        lineNumbers: true,
        readOnly: true,
        cursorBlinkRate: -1,
        lineWrapping: false
    });

    const postCodeMirror = document.querySelector('.CodeMirror');
    const scrollCodeMirror = document.querySelector('.CodeMirror-scroll');
    const codeMirrorVScrollbar = document.querySelector('.CodeMirror-vscrollbar');
    const codeMirrorHScrollbar = document.querySelector('.CodeMirror-hscrollbar');
    const codeMirrorGutters = document.querySelector('.CodeMirror-gutters');

    codeMirrorVScrollbar.remove();
    codeMirrorHScrollbar.classList.add('CodeMirror-hscrollbar_visibility');

    //delete excess scroll element
    scrollCodeMirror.children[1].remove();
    //unset height for div which adds unnecessary padding after click on post content
    scrollCodeMirror.children[1].removeAttribute('style');
    codeMirrorGutters.removeAttribute('style');
    //no focus is needed
    postCodeMirror.classList.add('CodeMirror-focused_unset');

    postCodeMirror.classList.add('CodeMirror_height-unset');
    scrollCodeMirror.classList.add('CodeMirror-scroll_height-unset');

    postCodeMirror.classList.add('CodeMirror_border-top-unset');

    postCodeMirror.classList.add('CodeMirror_border-color-unset');
}