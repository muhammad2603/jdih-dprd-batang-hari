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
            return (new Date(this.value)).getTime() > (new Date()).getTime();
        },
        /** max_mb {int: kilobytes} */
        isFileSizeTooLarge(max_mb) {
            return (this.value / (1024 * 1024)) >= max_mb;
        },
        /** allowedExtensionsArray {array: list allowed extension} */
        isAllowedFileExtension(allowedExtensionsArray) {
            const getExtension = this.value.match(/\w+$/);
            if (!getExtension) {
                return false;
            }
            return allowedExtensionsArray.includes(getExtension[0]);
        }
    }
}
function validate(validation) {
    let isPassed;
    const { inputElement, messageElement, validators, value } = validation;
    const useValue = inputElement === undefined ? value : inputElement.value;
    messageElement.innerText = "";
    for (const validator of validators) {
        const { method, parameters, messageError } = validator;
        const useNegate = validator.isNegate ?? false;
        const result = validations(useValue)[method](...parameters);
        const isValid = useNegate ? !result : result;
        if (isValid) {
            isPassed = false
            messageElement.innerText = messageError;
            return isPassed;
        }
    }
    return true;
}

export { validations, validate };