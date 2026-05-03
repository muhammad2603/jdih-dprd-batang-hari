/**
 * Function: Membuka dropdown
 * @param {boolean} state - Digunakan untuk menghapus class pointer-events-none dengan timeout jika ingin membuka dropdown.  
 * @param {HTMLElement} dropdownElement - Element dropdown yang ingin dibuka
 * @return {void}
 */
function setDropdownToShowed(state, dropdownElement) {
    dropdownElement.classList.remove("-translate-y-8")
    dropdownElement.classList.remove("opacity-0")
    if (state) {
        setTimeout(() => dropdownElement.classList.remove("pointer-events-none"), 300)
    }
}
/**
 * Function: Menutup Dropdown
 * @param {HTMLElement} dropdownElement - Element dropdown yang ingin ditutup
 * @return {void}
 */
function setDropdownToClosed(dropdownElement) {
    dropdownElement.classList.add("-translate-y-8")
    dropdownElement.classList.add("opacity-0")
    dropdownElement.classList.add("pointer-events-none")
}
export class ShowDropdownByButton {
    constructor({ targetButtonId, targetDropdownId }) {
        this.stateDropdown = false;
        this.buttonId = targetButtonId;
        this.buttonEl = document.getElementById(targetButtonId);
        this.dropdownId = targetDropdownId;
        this.dropdownEl = document.getElementById(targetDropdownId);
    }
    checkClosestTarget(eventTarget) {
        return {
            isTargetButton: eventTarget.closest(`#${this.buttonId}`),
            isTargetDropdown: eventTarget.closest(`#${this.dropdownId}`),
            get isNotTargetsClicked() {
                return this.isTargetButton === null && this.isTargetDropdown === null
            }
        }
    }
    openDropdown() {
        this.stateDropdown = true;
        setDropdownToShowed(this.stateDropdown, this.dropdownEl)
    }
    closeDropdown() {
        this.stateDropdown = false;
        setDropdownToClosed(this.dropdownEl)
    }
}