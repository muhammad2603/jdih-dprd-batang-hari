import { $, $id, $$ } from './dom.js';
import {
    showNotification,
    hideNotification,
    removeNotification,
    autoCloseNotification,
    manualCloseNotification,
} from './notification.js';
import { validations, validate } from './validations.js';
function autoZeroFillValue(inputEl, value) {
    const isZeroFill = !(validations(value).isValidValue(/^\+620/)) ? '0' : '';
    const getNumber = value.replace(/^\+62/, isZeroFill);
    inputEl.value = getNumber;
}
function setError(elementId, message) {
    $$($id(elementId)).nextEl().innerText = message;
}
function setErrorsFromResponse(errors, message) {
    Object.entries(errors).forEach(([id, error]) => setError(id, error))
}
function emptyText(el) {
    el.innerText = "";
}
let payload = {};
document.addEventListener("DOMContentLoaded", () => {
    const btnSendMail = $id("btnSendMail");
    const inputEmail = $id("email");
    const inputErrorEmail = $$(inputEmail).nextEl();
    const inputNamaLengkap = $id("namaLengkap");
    const inputErrorNamaLengkap = $$(inputNamaLengkap).nextEl();
    const inputNomorTelpon = $id("noTelp");
    const inputErrorNomorTelpon = $$(inputNomorTelpon).nextEl();
    const inputSubjek = $id("subject");
    const inputErrorSubjek = $$(inputSubjek).nextEl();
    const inputPesan = $id("message");
    const inputErrorPesan = $$(inputPesan).nextEl();
    const toastNotification = $id("toastNotification");
    const csrfToken = $("input[name=csrf_token]");
    const validationsConfig = [
        {
            inputElement: inputNamaLengkap,
            messageElement: inputErrorNamaLengkap,
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Isi nama lengkap anda.",
                },
            ]
        },
        {
            inputElement: inputEmail,
            messageElement: inputErrorEmail,
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Isi alamat email anda.",
                },
                {
                    method: "isValidValue",
                    parameters: [/@gmail\.com$/],
                    messageError: "Format email tidak valid.",
                    isNegate: true
                },
            ]
        },
        {
            inputElement: inputNomorTelpon,
            messageElement: inputErrorNomorTelpon,
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Isi nomor HP anda.",
                },
                {
                    method: "isInvalidValue",
                    parameters: [/\D+/],
                    messageError: "Format nomor HP hanya berupa digit atau angka.",
                },
                {
                    method: "isValidValue",
                    parameters: [/^08/],
                    messageError: "Format nomor HP tidak valid, harus diawali dengan angka 08.",
                    isNegate: true
                },
                {
                    method: "isValidValueLength",
                    parameters: [10, 13],
                    messageError: "Nomor HP tidak valid. Nomor yang valid minimal 10 digit dan maksimal 13 digit.",
                },
            ]
        },
        {
            inputElement: inputSubjek,
            messageElement: inputErrorSubjek,
            validators: [
                {
                    method: "isInvalidValue",
                    parameters: ["#"],
                    messageError: "Pilih subjek anda."
                },
            ]
        },
        {
            inputElement: inputPesan,
            messageElement: inputErrorPesan,
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Isi pesan anda."
                },
                {
                    method: "isValidValueLength",
                    parameters: [30],
                    messageError: "Pesan terlalu pendek, minimal 30 karakter."
                },
            ]
        },
    ];
    toastNotification.addEventListener('click', e => {
        const closeNotificationBtn = e.target.closest('.close-notification');
        if (!closeNotificationBtn) return;
        const notification = closeNotificationBtn.parentElement;
        manualCloseNotification(notification)
    })
    inputNomorTelpon.addEventListener("change", function () {
        const value = this.value;
        if (value.startsWith('08')) return;
        autoZeroFillValue(this, value)
    })
    btnSendMail.addEventListener("click", () => {
        payload.email = $$(inputEmail).getInputValue();
        payload.namaLengkap = $$(inputNamaLengkap).getInputValue();
        payload.noTelp = $$(inputNomorTelpon).getInputValue();
        payload.subject = $$(inputSubjek).getInputValue();
        payload.message = $$(inputPesan).getInputValue();
        let statusValidation;
        for (const validation of validationsConfig) {
            statusValidation = validate(validation);
        }
        if (!statusValidation) return;
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
                const { notificationId, notification, newToken } = data;
                csrfToken.value = newToken;
                $$(toastNotification).insertHTML(notification)
                const currentNotificationEl = $id(notificationId);
                showNotification(currentNotificationEl)
                autoCloseNotification(currentNotificationEl)
            })
            .catch(err => {
                if (err.code === 403) return alert("Token CSRF tidak ada atau telah kadaluarsa, silahkan refresh halaman dan coba lagi.");
                const { fieldsError, notificationId, notification, newToken } = err;
                csrfToken.value = newToken;
                $$(toastNotification).insertHTML(notification)
                const currentNotificationEl = $id(notificationId);
                showNotification(currentNotificationEl)
                autoCloseNotification(currentNotificationEl)
                if (fieldsError) {
                    setErrorsFromResponse(fieldsError)
                }
            });
    })
})