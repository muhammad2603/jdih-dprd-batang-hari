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

export { Validations };