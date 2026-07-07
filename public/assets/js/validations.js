/**
 * @typedef {Object} ValidationConfig
 * @property {HTMLInputElement} [inputElement] element input yang akan dicek value-nya. jika undefined, property value akan digunakan.
 * @property {any} [value] value yang akan dicek. jika undefined, property inputElement akan digunakan.
 * @property {HTMLElement} messageElement element untuk menampilkan pesan kesalahan
 * @property {Validator[]} validators
*/

/**
 * @typedef {Object} Validator
 * @property {string} method method validations yang ingin digunakan.
 * @property {Array} parameters parameter yang dibutuhkan dari method validations.
 * @property {string} messageError pesan yang akan ditampilkan ke messageElement jika hasil method tidak valid.
 * @property {boolean} isNegate Apakah hasil dari method validations harus dinegasi? true jika ya, false jika tidak.
*/

function validations(value) {
    return {
        value,
        isEmptyValue() {
            return this.value === "";
        },
        isValidValue(pattern = false) {
            if (pattern instanceof RegExp) {
                return pattern.test(this.value);
            }
            return !this.value;
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
        isValueIncludedChar(char) {
            return this.value.includes(char);
        },
        isInvalidDate() {
            return new Date(this.value) > new Date();
        },
        /** maxMB {int: MegaBytes} */
        isFileSizeTooLarge(maxMB) {
            return (this.value / (1024 * 1024)) >= maxMB;
        },
        /** allowedExtensionsArray {array: list allowed extension} */
        isAllowedFileExtension(allowedExtensionsArray) {
            const getExtension = this.value.match(/\w+$/);
            if (!getExtension) {
                return false;
            }
            return allowedExtensionsArray.includes(getExtension[0]);
        },
        /** allowedMimesType {array: list allowed mimes type} */
        isAllowedMimesType(allowedMimes) {
            return allowedMimes.includes(this.value);
        },
        /**
         * Cek apakah input yang opsional saat diisi memiliki panjang karakter yang valid?
         */
        isValidOptionalValueLength(min, max) {
            return (!this.isEmptyValue() && this.isValidValueLength(min, max));
        }
    }
}

/**
 * Validasi otomatis menggunakan config
 * @param {ValidationConfig[]} validation config validasi
 * @return {boolean} false jika ada yang tidak valid, true jika semuanya valid
*/
function validate(validation) {
    let isPassed;
    const { inputElement, messageElement, validators, value } = validation;
    const useValue = inputElement === undefined ? value : inputElement.value;
    messageElement.innerText = "";
    for (const validator of validators) {
        const { method, parameters, messageError } = validator;
        const useNegate = validator.isNegate ?? false;
        const result = validations(useValue)[method](...parameters);
        const hasError = useNegate ? !result : result;
        if (hasError) {
            isPassed = false
            messageElement.innerText = messageError;
            return isPassed;
        }
    }
    return true;
}

export { validations, validate };