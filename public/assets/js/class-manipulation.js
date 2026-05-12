/**
 * @typedef {Object} ClassManipulator
 * @property {(property: string, value: string) => ClassManipulator} inlineStyle
 * Membuat property dan value pada atribut style element
 * @property {(...classes: string[])=> ClassManipulator} add
 * Menambah satu atau lebih class
 * @property {(...classes: string[])=> ClassManipulator} remove
 * Menghapus satu atau lebih class
 */
/**
 * Manipulasi class pada element
 * @param {HTMLElement} element - Element yang akan dimanipulasi class-nya
 * @returns {ClassManipulator}
 */
export function classManipulation(element) {
    return {
        el: element,
        inlineStyle: function (property, value) {
            this.el.style[property] = value;
            return this;
        },
        add: function (...classes) {
            const cls = !Array.isArray(classes[0]) ? classes : classes[0];
            cls.forEach((cls) => this.el.classList.add(cls));
            return this;
        },
        remove: function (...classes) {
            const cls = !Array.isArray(classes[0]) ? classes : classes[0];
            cls.forEach((cls) => this.el.classList.remove(cls));
            return this;
        },
    }
}