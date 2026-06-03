function $(selector) {
    return document.querySelector(selector)
}
function $id(id) {
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
        },
        setAttr(atr, value) {
            return this.element.setAttribute(atr, value);
        },
        removeAttr(atr, value) {
            return this.element.removeAttribute(atr, value);
        },
        text(str) {
            return this.element.textContent = str;
        }
    }
}

export {
    $,
    $id,
    $$,
};