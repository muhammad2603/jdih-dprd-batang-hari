function validations(value) {
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
function validate(validation) {
    let isPassed;
    const { inputElement, messageElement, validators } = validation;
    for (const validator of validators) {
        const { method, parameters, messageError } = validator;
        const useNegate = validator.isNegate ?? false;
        const result = validations(inputElement.value)[method](...parameters);
        const isValid = useNegate ? !result : result;
        if (isValid) {
            isPassed = false
            messageElement.innerText = messageError;
            return;
        }
    }
    return isPassed;
}

export { validations, validate };