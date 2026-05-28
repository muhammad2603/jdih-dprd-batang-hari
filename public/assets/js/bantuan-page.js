import { classManipulation } from "./class-manipulation.js";
function $(selector) {
    return document.querySelector(selector)
}
$.id = (id) => {
    return document.getElementById(id);
}
function $$(element) {
    return {
        element,
        insertHTML(childEl, position = 'afterbegin') {
            this.element.insertAdjacentHTML(position, childEl)
        },
        prevEl() {
            return this.element.previousElementSibling;
        },
        nextEl() {
            return this.element.nextElementSibling;
        },
        removeEl() {
            return this.element.remove();
        },
        getInputValue() {
            return this.element.value.trim();
        }
    }
}
function showNotification(el) {
    classManipulation(el).useAnimFrame(el => el.classList.remove('translate-x-2/4', 'opacity-75', 'pointer-events-none'))
}
function hideNotification(el) {
    classManipulation(el).add('pointer-events-none', 'translate-x-2/4', 'opacity-0')
}
function removeNotification(el, delay = 0) {
    setTimeout(() => $$(el).removeEl(), delay)
}
function autoCloseNotification(el) {
    setTimeout(() => {
        hideNotification(el)
        setTimeout(() => removeNotification(el), 100)
    }, 4000)
}
function manualCloseNotification(el) {
    hideNotification(el)
    removeNotification(el, 200)
}
function Validations(value) {
    return {
        value,
        isEmptyValue() {
            return this.value.trim() === "";
        },
        isValidValue(pattern) {
            return pattern.test(this.value.trim());
        },
        isInvalidValue(pattern) {
            if (pattern instanceof RegExp) {
                return pattern.test(this.value.trim());
            }
            return this.value.trim() === pattern;
        },
        isValidValueLength(min, max = false) {
            return this.value.trim().length < min || (max !== false && this.value.trim().length > max);
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
    const btnSendMail = $.id("btnSendMail");
    const inputEmail = $.id("email");
    const inputErrorEmail = $$(inputEmail).nextEl();
    const inputNamaLengkap = $.id("namaLengkap");
    const inputErrorNamaLengkap = $$(inputNamaLengkap).nextEl();
    const inputNomorTelpon = $.id("noTelp");
    const inputErrorNomorTelpon = $$(inputNomorTelpon).nextEl();
    const inputSubjek = $.id("subject");
    const inputErrorSubjek = $$(inputSubjek).nextEl();
    const inputPesan = $.id("message");
    const inputErrorPesan = $$(inputPesan).nextEl();
    const toastNotification = $.id("toastNotification");
    const csrfToken = $("input[name=csrf_token]");
    toastNotification.addEventListener('click', e => {
        const closeNotificationBtn = e.target.closest('.close-notification');
        if (!closeNotificationBtn) return;
        const notification = closeNotificationBtn.parentElement;
        manualCloseNotification(notification)
    })
    inputNomorTelpon.addEventListener("change", function () {
        const value = this.value;
        if (value.startsWith('08')) return;
        const fillZero = Validations(value).isValidValue(/^\+620/) ? '' : '0';
        const getNumber = value.replace(/^\+62/, fillZero);
        this.value = getNumber;
    })
    btnSendMail.addEventListener("click", () => {
        payload.userEmail = $$(inputEmail).getInputValue();
        payload.namaLengkap = $$(inputNamaLengkap).getInputValue();
        payload.nomorTelpon = $$(inputNomorTelpon).getInputValue();
        payload.subjek = $$(inputSubjek).getInputValue();
        payload.pesan = $$(inputPesan).getInputValue();
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
                $$(toastNotification).insertHTML(notification)
                const currentNotificationEl = $.id(notificationId);
                showNotification(currentNotificationEl)
                autoCloseNotification(currentNotificationEl)
            })
            .catch(err => {
                if (err.code === 403) return alert("Permintaan tidak diizinkan!");
                const { message, notificationId, notification, newToken } = err;
                csrfToken.value = newToken;
                $$(toastNotification).insertHTML(notification)
                const currentNotificationEl = $.id(notificationId);
                showNotification(currentNotificationEl)
                autoCloseNotification(currentNotificationEl)
            });
    })
})