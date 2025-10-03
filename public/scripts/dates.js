const authorCreatedAt = document.querySelector('.author__created-at span');
const authorCreatedAtImg = document.querySelector('.author__created-at img');

const dateOptions = {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
};
const timeOptions = {
    hour: 'numeric',
    minute: 'numeric'
};

if (authorCreatedAt !== null) {
    const dateObject = new Date(authorCreatedAt.textContent);
    const date = dateObject.toLocaleString('ru-RU', dateOptions);
    const time = dateObject.toLocaleString('ru-RU', timeOptions);

    authorCreatedAt.textContent = date;

    const accountCreatedAtTitle = 'Аккаунт создан: ' + date + ' ' + time;
    authorCreatedAtImg.setAttribute('title', accountCreatedAtTitle);
    authorCreatedAt.setAttribute('title', accountCreatedAtTitle);
}