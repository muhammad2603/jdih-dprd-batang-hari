import { $, $id, $$ } from './dom.js';
import { validate, validations } from './validations.js';
import { classManipulation } from './class-manipulation.js';
import { setValue } from './Form.js';
import { useFetch } from './Class/Fetch.js';
document.addEventListener('DOMContentLoaded', () => {
    const changesProfileBtn = $id("changesProfileBtn");
    const inputNamaLengkap = $id("namaLengkap");
    const namaLengkapError = $id("namaLengkapError");
    const inputDivisi = $id("divisi");
    const divisiError = $id("divisiError");
    const inputNoTelp = $id("noTelp");
    const noTelpError = $id("noTelpError");
    const inputCurrentPassword = $id("currentPassword");
    const currentPasswordError = $id("currentPasswordError");
    const inputNewPassword = $id("newPassword");
    const inputConfirmNewPassword = $id("confirmNewPassword");
    const passChecker = $id("passChecker");
    const tokenCsrf = $('input[name=csrf_token]');
    const [minLengthChecker, combinationLettersChecker, oneDigitChecker, oneSymbolChecker] = Array.from(passChecker.querySelectorAll("li"));
    let isNewPasswordValid = false;
    inputNewPassword.addEventListener("input", function () {
        const value = $$(this).getInputValue();
        const length = value.length + 1;
        const isLengthValid = length >= 8;
        const isHasOneUpperAndLower = /[A-Z]/.test(value) && /[a-z]/.test(value);
        const isHasOneDigit = /[\d+]/.test(value);
        const isHasOneSymbol = /[!@#$%^&*]+/.test(value);
        classManipulation(passChecker).remove('hidden')
        if (isLengthValid && isHasOneUpperAndLower && isHasOneDigit && isHasOneSymbol) {
            isNewPasswordValid = true;
        } else {
            isNewPasswordValid = false;
        }
        if (isLengthValid) {
            classManipulation(minLengthChecker).remove("text-red-500")
        } else {
            classManipulation(minLengthChecker).add("text-red-500")
        }
        if (isHasOneUpperAndLower) {
            classManipulation(combinationLettersChecker).remove("text-red-500")
        } else {
            classManipulation(combinationLettersChecker).add("text-red-500")
        }
        if (isHasOneDigit) {
            classManipulation(oneDigitChecker).remove("text-red-500")
        } else {
            classManipulation(oneDigitChecker).add("text-red-500")
        }
        if (isHasOneSymbol) {
            classManipulation(oneSymbolChecker).remove("text-red-500")
        } else {
            classManipulation(oneSymbolChecker).add("text-red-500")
        }
    })
    let validationsConfig = [
        {
            identityField: "nama_lengkap",
            messageElement: namaLengkapError,
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Nama lengkap harus diisi."
                },
                {
                    method: "isInvalidValue",
                    parameters: [/[^A-Za-z\. ]/],
                    messageError: "Nama lengkap hanya mengandung karakter alfabet (a-z), titik, dan spasi."
                },
                {
                    method: "isValidValueLength",
                    parameters: [3, 50],
                    messageError: "Nama lengkap memiliki panjang karakter yang tidak valid (min. 3 karakter dan maks. 50 karakter)."
                }
            ]
        },
        {
            identityField: "nama_divisi",
            messageElement: divisiError,
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Nama divisi harus diisi."
                },
                {
                    method: "isValidOptionalValueLength",
                    parameters: [5, 30],
                    messageError: "Nama Divisi memiliki panjang karakter yang tidak valid (min. 5 karakter dan maks. 30 karakter)."
                },
            ]
        },
        {
            identityField: "nomor_hp",
            messageElement: noTelpError,
            validators: [
                {
                    method: "isInvalidValue",
                    parameters: [/\D/],
                    messageError: "Nomor HP hanya mengandung digit/angka."
                },
                {
                    method: "isInvalidValue",
                    parameters: [/^08/],
                    messageError: "Nomor HP tidak valid. Pastikan nomor HP diawali dengan 08!",
                    isNegate: true
                },
                {
                    method: "isValidOptionalValueLength",
                    parameters: [10, 13],
                    messageError: "Nomor HP memiliki panjang digit yang tidak valid (min. 10 digit dan maks. 13 digit)."
                },
            ]
        },
        {
            identityField: "currentPassword",
            messageElement: currentPasswordError,
            validators: [
                {
                    method: "isValidOptionalValueLength",
                    parameters: [8],
                    messageError: "Password memiliki panjang minimal 8 karakter."
                },
            ]
        },
    ];
    const currentValue = {};
    currentValue["nama_lengkap"] = {
        inputEl: inputNamaLengkap,
        value: $$(inputNamaLengkap).getInputValue()
    };
    currentValue["nama_divisi"] = {
        inputEl: inputDivisi,
        value: $$(inputDivisi).getInputValue()
    };
    currentValue["nomor_hp"] = {
        inputEl: inputNoTelp,
        value: $$(inputNoTelp).getInputValue()
    };
    currentValue["currentPassword"] = {
        inputEl: inputCurrentPassword,
        value: $$(inputCurrentPassword).getInputValue()
    };
    const currentValueEntries = Object.entries(currentValue);
    changesProfileBtn.addEventListener("click", () => {
        const changesValue = {};
        currentValueEntries.forEach(([dbField, inputIdentities]) => {
            const { inputEl, value: oldValue } = inputIdentities;
            const newValue = $$(inputEl).getInputValue();
            if (newValue === oldValue) return;
            changesValue[dbField] = newValue;
        })
        const changesValueEntries = Object.entries(changesValue);
        if (changesValueEntries.length === 0) return alert("Tidak ada perubahan yang terjadi!");
        let isValid = true;
        for (const [identity, value] of changesValueEntries) {
            const rules = validationsConfig.find(config => config.identityField === identity);
            rules["value"] = value;
            if (!validate(rules)) {
                isValid = false;
            }
        }
        if (!isValid) return alert("Ada input yang tidak valid! Mohon cek kembali.");
        const formData = new FormData();
        const isPasswordChanged = changesValue.currentPassword !== undefined;
        if (isPasswordChanged) {
            const newPasswordValue = $$(inputNewPassword).getInputValue();
            const confirmNewPasswordValue = $$(inputConfirmNewPassword).getInputValue();
            const isNewPasswordEmpty = validations(newPasswordValue).isEmptyValue();
            const isConfirmPasswordEmpty = validations(confirmNewPasswordValue).isEmptyValue();
            const isChangePasswordAllowed = !(isNewPasswordEmpty || isConfirmPasswordEmpty);
            if (!isChangePasswordAllowed) return console.log("Password baru dan konfirmasi password baru tidak boleh kosong.");
            if (!isNewPasswordValid) return console.log("Password tidak valid. Pastikan format password sudah sesuai dengan yang diminta!");
            if (newPasswordValue !== confirmNewPasswordValue) return console.log("Password baru dan konfirmasi password tidak sama!");
            if (changesValue.currentPassword === newPasswordValue) return console.log("Password lama dan baru tidak boleh sama!");
            changesValue["newPassword"] = newPasswordValue;
            changesValue["confirmNewPassword"] = confirmNewPasswordValue;
        }
        for (const [field, value] of Object.entries(changesValue)) {
            formData.append(field, value)
        }
        formData.append('csrf_token', tokenCsrf.value);
        formData.append("_method", "PATCH");
        useFetch({
            url: '/api/update-profile',
            action: "POST",
            headers: {
                "X-REQUESTED-WITH": 'XMLHttpRequest'
            },
            body: formData,
            success: resp => {
                alert("Data profil berhasil diperbarui!")
                window.location.reload();
            },
            errors: err => {
                const { message, new_token } = err;
                setValue(tokenCsrf, new_token)
                alert(message)
            }
        });
    })
})