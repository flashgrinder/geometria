function initCookie() {

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }


    function checkCookies() {
        let cookieNote = document.getElementById('js-cookie-note');
        let cookieBtnAccept = cookieNote.querySelector('.js-cookie-accept');

        // Если куки cookies_policy нет или она просрочена, то показываем уведомление
        if (!getCookie('cookie-notifier__policy')) {
            cookieNote.classList.add('show');
        }

        // При клике на кнопку устанавливаем куку cookies_policy на один год
        cookieBtnAccept.addEventListener('click', function () {
            setCookie('cookie-notifier__policy', 'true', 365);
            cookieNote.classList.remove('show');
        });
    }

    checkCookies();

}

document.addEventListener("DOMContentLoaded", initCookie);