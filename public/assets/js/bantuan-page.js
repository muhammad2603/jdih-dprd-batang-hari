function showNotification(el) {
    requestAnimationFrame(() => {
        requestAnimationFrame(() => el.classList.remove('translate-x-2/4', 'opacity-75', 'pointer-events-none'))
    })
}
function hideNotification(el, delay = true) {
    if (delay) {
        setTimeout(() => el.classList.add('pointer-events-none', 'translate-x-2/4', 'opacity-0'), 4000)
    } else {
        el.classList.add('pointer-events-none', 'translate-x-2/4', 'opacity-0')
        setTimeout(() => el.remove(), 200)
    }
}
function removeNotification(el) {
    hideNotification(el)
    setTimeout(() => el.remove(), 4100)
}
function insertHTML(parentEl, childEl, position = 'afterbegin') {
    parentEl.insertAdjacentHTML(position, childEl)
}
function $(selector) {
    return document.querySelector(selector)
}
let payload = {};
document.addEventListener("DOMContentLoaded", () => {
    const btnSendMail = $("#btnSendMail");
    const inputEmail = $("#email");
    const inputNamaLengkap = $("#namaLengkap");
    const inputNomorTelpon = $("#noTelp");
    const inputSubjek = $("#subject");
    const inputPesan = $("#message");
    const toastNotification = $("#toastNotification");
    const csrfToken = $("input[name=csrf_token]");
    toastNotification.addEventListener('click', e => {
        const closeNotificationBtn = e.target.closest('.close-notification');
        if (!closeNotificationBtn) return;
        const notification = closeNotificationBtn.parentElement;
        hideNotification(notification, false)
    })
    btnSendMail.addEventListener("click", () => {
        payload.userEmail = inputEmail.value.trim();
        payload.namaLengkap = inputNamaLengkap.value.trim();
        payload.nomorTelpon = inputNomorTelpon.value.trim();
        payload.subjek = inputSubjek.value.trim();
        payload.pesan = inputPesan.value.trim();
        if (
            payload.userEmail === "" ||
            payload.namaLengkap === "" ||
            payload.nomorTelpon === "" ||
            payload.subjek === "#" ||
            payload.pesan === ""
        ) return;
        fetch('/api/sendmail', {
            method: 'POST',
            headers: {
                "ContentType": 'application/json',
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": csrfToken.value,
            },
            body: JSON.stringify(payload)
        })
            .then(async (resp) => {
                const data = await resp.json();
                if (!resp.ok) {
                    throw data;
                };
                return data;
            })
            .then(data => {
                const { message, notificationId, notification, newToken } = data;
                csrfToken.value = newToken;
                insertHTML(toastNotification, notification, 'afterbegin')
                const currentNotificationEl = document.getElementById(notificationId);
                showNotification(currentNotificationEl, 'translate-x-2/4', 'opacity-75', 'pointer-events-none')
                removeNotification(currentNotificationEl, 'pointer-events-none', 'translate-x-2/4', 'opacity-0')
            })
            .catch(err => {
                if (err.code === 403) return alert("Permintaan tidak diizinkan!");
                const { message, notificationId, notification, newToken } = err;
                csrfToken.value = newToken;
                insertHTML(toastNotification, notification, 'afterbegin')
                const currentNotificationEl = document.getElementById(notificationId);
                showNotification(currentNotificationEl, 'translate-x-2/4', 'opacity-75', 'pointer-events-none')
                removeNotification(currentNotificationEl, 'pointer-events-none', 'translate-x-2/4', 'opacity-0')
            });
    })
})