const selects = document.querySelectorAll('.select');

if (selects !== null) {
    selects.forEach(select => {
        const selectTrigger = select.querySelector('.select__trigger');
        const selectDropdown = select.querySelector('.select__dropdown');
        const selectOptions = select.querySelector('.select__options-wrapper');
        const options = select.querySelectorAll('.select__option');
        const hiddenInput = select.querySelector('input[type="hidden"]');

        //show options on click
        selectTrigger.addEventListener('click', () => {
            selectDropdown.classList.toggle('select__dropdown_rotation');
            selectOptions.classList.toggle('select__options_hidden');
            select.classList.add('select_active');
        });

        //select option on click
        options.forEach(option => {
            option.addEventListener('click', () => {
                selectTrigger.textContent = option.textContent;
                selectTrigger.classList.add('select__trigger_selected');
                selectDropdown.classList.remove('select__dropdown_rotation');
                hiddenInput.value = option.getAttribute('data-value');
                hiddenInput.dispatchEvent(new Event('input'));
                selectOptions.classList.add('select__options_hidden');
                select.classList.remove('select_active');
            });
        });

        //hide options by clicking outside select
        document.addEventListener('click', e => {
            if (!select.contains(e.target)) {
                selectDropdown.classList.remove('select__dropdown_rotation');
                selectOptions.classList.add('select__options_hidden');
                select.classList.remove('select_active');
            }
        });

        //hide options on 'Escape' click
        select.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                selectDropdown.classList.remove('select__dropdown_rotation');
                selectOptions.classList.add('select__options_hidden');
                selectTrigger.focus();
            }
        });
    });
}