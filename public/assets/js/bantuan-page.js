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
    const inputErrorEmail = inputEmail.nextElementSibling;
    const inputNamaLengkap = $("#namaLengkap");
    const inputErrorNamaLengkap = inputNamaLengkap.nextElementSibling;
    const inputNomorTelpon = $("#noTelp");
    const inputErrorNomorTelpon = inputNomorTelpon.nextElementSibling;
    const inputSubjek = $("#subject");
    const inputErrorSubjek = inputSubjek.nextElementSibling;
    const inputPesan = $("#message");
    const inputErrorPesan = inputPesan.nextElementSibling;
    const toastNotification = $("#toastNotification");
    const csrfToken = $("input[name=csrf_token]");
    toastNotification.addEventListener('click', e => {
        const closeNotificationBtn = e.target.closest('.close-notification');
        if (!closeNotificationBtn) return;
        const notification = closeNotificationBtn.parentElement;
        hideNotification(notification, false)
    })
    inputNomorTelpon.addEventListener("change", function () {
        const value = this.value;
        if (value.startsWith('08')) return;
        const fillZero = /^\+620/.test(value) ? '' : '0';
        const getNumber = value.replace(/^\+62/, fillZero);
        this.value = getNumber;
    })
    btnSendMail.addEventListener("click", () => {
        let isValid = true;
        payload.userEmail = inputEmail.value.trim();
        payload.namaLengkap = inputNamaLengkap.value.trim();
        payload.nomorTelpon = inputNomorTelpon.value.trim();
        payload.subjek = inputSubjek.value.trim();
        payload.pesan = inputPesan.value.trim();
        if (payload.namaLengkap === "") {
            isValid = false;
            inputErrorNamaLengkap.innerText = "Input tidak boleh kosong."
        }
        const isValidEmail = /@gmail\.com$/i.test(payload.userEmail);
        if (!isValidEmail) {
            isValid = false;
            inputErrorEmail.innerText = "Format email tidak valid.";
        }
        if (payload.userEmail === "") {
            isValid = false;
            inputErrorEmail.innerText = "Input tidak boleh kosong.";
        }
        const isNomorTelponValid = /^08.*$/.test(payload.nomorTelpon);
        if (/\D+/.test(payload.nomorTelpon)) {
            isValid = false;
            inputErrorNomorTelpon.innerText = "Format nomor HP hanya berupa digit atau angka.";
        }
        if (!isNomorTelponValid) {
            isValid = false;
            inputErrorNomorTelpon.innerText = "Format nomor HP tidak valid, harus diawali dengan angka 08.";
        }
        const getNomorTelponLength = payload.nomorTelpon.length;
        if (getNomorTelponLength < 10 || getNomorTelponLength > 13) {
            isValid = false;
            inputErrorNomorTelpon.innerText = "Nomor HP tidak valid. Nomor yang valid minimal 10 digit dan maksimal 13 digit.";
        }
        if (payload.nomorTelpon === "") {
            isValid = false;
            inputErrorNomorTelpon.innerText = "Input tidak boleh kosong.";
        }
        const isSubjekSelected = payload.subjek !== "#";
        if (!isSubjekSelected) {
            isValid = false;
            inputErrorSubjek.innerText = "Pilih subjek anda.";
        }
        const pesanValueLength = payload.pesan.length;
        if (pesanValueLength < 30) {
            isValid = false;
            inputErrorPesan.innerText = "Pesan terlalu pendek, minimal 30 karakter.";
        }
        if (payload.pesan === "") {
            isValid = false;
            inputErrorPesan.innerText = "Input tidak boleh kosong.";
        }
        if (isValid === false) return;
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