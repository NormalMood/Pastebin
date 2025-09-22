const headerBurger = document.getElementById('header-burger');
const headerMenu = document.getElementById('header-menu');

if ((headerBurger !== null) && (headerMenu !== null)) {
    headerBurger.addEventListener('click', function() {
        if (this.classList.contains('header__burger_opened')) {
            this.classList.remove('header__burger_opened');
            headerMenu.classList.remove('header__menu_opened');
            document.documentElement.removeAttribute('style');
        } else {
            this.classList.add('header__burger_opened');
            headerMenu.classList.add('header__menu_opened');
            document.documentElement.style.overflow = 'hidden';
        }
    });
}

const setOverflow = () => {
    if (window.innerWidth >= 768) {
        document.documentElement.removeAttribute('style');
    } else if ((headerMenu !== null) && (headerMenu.classList.contains('header__menu_opened'))) {
        document.documentElement.style.overflow = 'hidden';
    }
};
window.addEventListener('resize', setOverflow);