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
function Validations(value) {
    return {
        value,
        isEmptyValue() {
            return this.value.trim() === "";
        },
        isValidValue(pattern) {
            return pattern.test(this.value);
        },
        isInvalidValue(pattern) {
            if (pattern instanceof RegExp) {
                return pattern.test(this.value);
            }
            return this.value === pattern;
        },
        isValidValueLength(min, max = false) {
            return this.value.length < min || (max !== false && this.value.length > max);
        },
    }
}
const validate = (validation) => {
    let isPassed;
    const { inputElement, messageElement, validators } = validation;
    for (const validator of validators) {
        const { method, parameters, messageError } = validator;
        const useNegate = validator.isNegate ?? false;
        const result = Validations(inputElement.value)[method](...parameters);
        const isValid = useNegate ? !result : result;
        if (isValid) {
            isPassed = false
            messageElement.innerText = messageError;
            return;
        }
    }
    return isPassed;
}
const validations = [
    {
        inputElement: $("#namaLengkap"),
        messageElement: $("#namaLengkap").nextElementSibling,
        validators: [
            {
                method: "isEmptyValue",
                parameters: [],
                messageError: "Input tidak boleh kosong.",
            },
        ]
    },
    {
        inputElement: $("#email"),
        messageElement: $("#email").nextElementSibling,
        validators: [
            {
                method: "isEmptyValue",
                parameters: [],
                messageError: "Input tidak boleh kosong.",
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
        inputElement: $("#noTelp"),
        messageElement: $("#noTelp").nextElementSibling,
        validators: [
            {
                method: "isEmptyValue",
                parameters: [],
                messageError: "Input tidak boleh kosong.",
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
        inputElement: $("#subject"),
        messageElement: $("#subject").nextElementSibling,
        validators: [
            {
                method: "isInvalidValue",
                parameters: ["#"],
                messageError: "Pilih subjek anda."
            },
        ]
    },
    {
        inputElement: $("#message"),
        messageElement: $("#message").nextElementSibling,
        validators: [
            {
                method: "isEmptyValue",
                parameters: [],
                messageError: "Input tidak boleh kosong."
            },
            {
                method: "isValidValueLength",
                parameters: [30],
                messageError: "Pesan terlalu pendek, minimal 30 karakter."
            },
        ]
    },
];
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
        payload.userEmail = inputEmail.value.trim();
        payload.namaLengkap = inputNamaLengkap.value.trim();
        payload.nomorTelpon = inputNomorTelpon.value.trim();
        payload.subjek = inputSubjek.value.trim();
        payload.pesan = inputPesan.value.trim();
        let statusValidation;
        for (const validation of validations) {
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