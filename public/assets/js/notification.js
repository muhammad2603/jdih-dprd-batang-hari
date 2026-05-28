import { classManipulation } from "./class-manipulation.js";
import { $$ } from './dom.js';
function showNotification(el) {
    classManipulation(el).useAnimFrame(el => classManipulation(el).remove('translate-x-2/4', 'opacity-75', 'pointer-events-none'))
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
export {
    showNotification,
    hideNotification,
    removeNotification,
    autoCloseNotification,
    manualCloseNotification,
}