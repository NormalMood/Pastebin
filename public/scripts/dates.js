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
const timeExtraOptions = {
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric'
};

const getTimeLeft = (dateExpiresAt) => {
    const now = new Date();
    const msLeft = dateExpiresAt - now;
    const secondsLeft = Math.floor(msLeft / 1000);
    const minutesLeft = Math.floor(secondsLeft / 60);
    const hoursLeft = Math.floor(minutesLeft / 60);
    const daysLeft = Math.floor(hoursLeft / 24);
    const weeksLeft = Math.floor(daysLeft / 7);
    const monthsLeft = Math.floor(daysLeft / 30);

    let timeLeft = '';

    if (minutesLeft === 0) {
        timeLeft = secondsLeft + ' сек.';
    } else if (hoursLeft === 0) {
        timeLeft = minutesLeft + ' мин.';
    } else if (daysLeft === 0) {
        timeLeft = hoursLeft + ' ч.';
    } else if (weeksLeft === 0) {
        timeLeft = daysLeft + ' д.';
    } else if (monthsLeft === 0) {
        timeLeft = weeksLeft + ' нед.';
    } else if ((monthsLeft > 0) && (monthsLeft <= 11)) {
        timeLeft = monthsLeft + ' мес.';
    } else if (monthsLeft >= 12) {
        timeLeft = '1 год';
    } else {
        timeLeft = '0 сек.';
    }
    
    return timeLeft;
}

// Post page

if (authorCreatedAt !== null) {
    const dateObject = new Date(authorCreatedAt.textContent);
    const date = dateObject.toLocaleString('ru-RU', dateOptions);
    const time = dateObject.toLocaleString('ru-RU', timeOptions);

    authorCreatedAt.textContent = date;

    const accountCreatedAtTitle = 'Аккаунт создан: ' + date + ' ' + time;
    authorCreatedAtImg.setAttribute('title', accountCreatedAtTitle);
    authorCreatedAt.setAttribute('title', accountCreatedAtTitle);
}

const postsCreatedAt = document.querySelectorAll('.post__created-at');

if (postsCreatedAt !== null) {
    postsCreatedAt.forEach(postCreatedAt => {
        const dateObject = new Date(postCreatedAt.textContent);
        const date = dateObject.toLocaleString('ru-RU', dateOptions);
        const time = dateObject.toLocaleString('ru-RU', timeOptions);
        const timeExtra = dateObject.toLocaleString('ru-RU', timeExtraOptions);
        postCreatedAt.textContent = date + ' ' + time;
        postCreatedAt.setAttribute('title', 'Пост создан: ' + date + ' ' + timeExtra);
    })
}

const datetimeMetadataCreatedAt = document.querySelector('.post__datetime-metadata-created-at span');
const datetimeMetadataCreatedAtImg = document.querySelector('.post__datetime-metadata-created-at img');

const datetimeMetadataExpiresAt = document.querySelector('.post__datetime-metadata-expires-at span');
const datetimeMetadataExpiresAtImg = document.querySelector('.post__datetime-metadata-expires-at img');

if (datetimeMetadataCreatedAt !== null) {
    const dateCreatedAt = new Date(datetimeMetadataCreatedAt.textContent);
    const date = dateCreatedAt.toLocaleString('ru-RU', dateOptions);
    const time = dateCreatedAt.toLocaleString('ru-RU', timeOptions);
    const timeExtra = dateCreatedAt.toLocaleString('ru-RU', timeExtraOptions);

    datetimeMetadataCreatedAt.textContent = date + ' ' + time;
    const datetimeCreatedAtTitle = 'Пост создан: ' + date + ' ' + timeExtra;
    datetimeMetadataCreatedAtImg.setAttribute('title', datetimeCreatedAtTitle);
    datetimeMetadataCreatedAt.setAttribute('title', datetimeCreatedAtTitle);
}

if (datetimeMetadataExpiresAt !== null) {
    if (datetimeMetadataExpiresAt.textContent === 'infinity') {
        datetimeMetadataExpiresAt.textContent = 'Не удалять';
        datetimeMetadataExpiresAt.setAttribute('title', 'Пост будет удален: Никогда');
        datetimeMetadataExpiresAtImg.setAttribute('title', 'Пост будет удален: Никогда');
    } else {
        const dateExpiresAt = new Date(datetimeMetadataExpiresAt.textContent);
        const date = dateExpiresAt.toLocaleString('ru-RU', dateOptions);
        const timeExtra = dateExpiresAt.toLocaleString('ru-RU', timeExtraOptions);

        datetimeMetadataExpiresAt.textContent = getTimeLeft(dateExpiresAt);

        const datetimeExpiresAtTitle = 'Пост будет удален: ' + date + ' ' + timeExtra;
        datetimeMetadataExpiresAtImg.setAttribute('title', datetimeExpiresAtTitle);
        datetimeMetadataExpiresAt.setAttribute('title', datetimeExpiresAtTitle);
    }
}

// Profile page

const postsExpireAt = document.querySelectorAll('.post__expires-at');

if (postsExpireAt !== null) {
    postsExpireAt.forEach(postExpiresAt => {
        if (postExpiresAt.textContent === 'infinity') {
            postExpiresAt.textContent = 'Никогда';
            postExpiresAt.setAttribute('title', 'Пост будет удален: Никогда');
        } else {
            const dateExpiresAt = new Date(postExpiresAt.textContent);
            const date = dateExpiresAt.toLocaleString('ru-RU', dateOptions);
            const timeExtra = dateExpiresAt.toLocaleString('ru-RU', timeExtraOptions);

            postExpiresAt.textContent = getTimeLeft(dateExpiresAt);

            const datetimeExpiresAtTitle = 'Пост будет удален: ' + date + ' ' + timeExtra;
            postExpiresAt.setAttribute('title', datetimeExpiresAtTitle);
        }
    });
}