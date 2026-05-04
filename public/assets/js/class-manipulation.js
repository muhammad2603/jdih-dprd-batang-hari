/**
 * @typedef {Object} ClassManipulator
 * @property {HTMLElement} el - Element yang dimanipulasi
 * @property {function(string[]): ClassManipulator} add - Menambah satu atau lebih class
 * @property {function(string[]): ClassManipulator} remove - Menghapus satu atau lebih class
 */
/**
 * Manipulasi class pada element
 * @param {HTMLElement} element - Element yang akan dimanipulasi class-nya
 * @returns {ClassManipulator}
 */
export function classManipulation(element) {
    return {
        el: element,
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