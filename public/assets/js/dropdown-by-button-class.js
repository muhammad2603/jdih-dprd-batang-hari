export class ShowDropdownByButton {
    constructor({ targetDropdownId }) {
        this.dropdownId = targetDropdownId;
        this.stateDropdown = false;
    }

    checkClosestTarget(eventTarget, buttonId, dropdownId) {
        return {
            isTargetButton: eventTarget.closest(`#${buttonId}`),
            isTargetDropdown: eventTarget.closest(`#${dropdownId}`),
            get isNotTargetsClicked() {
                return this.isTargetButton === null && this.isTargetDropdown === null
            }
        }
    }

    openDropdown(stateDropdown) {
        this.stateDropdown = true;
        this.dropdownId.classList.remove("-translate-y-8")
        this.dropdownId.classList.remove("opacity-0")
        if (stateDropdown) {
            setTimeout(() => this.dropdownId.classList.remove("pointer-events-none"), 300)
            return;
        }
        this.dropdownId.classList.remove("pointer-events-none")
    }

    closeDropdown(stateDropdown) {
        this.stateDropdown = false;
        this.dropdownId.classList.add("-translate-y-8")
        this.dropdownId.classList.add("opacity-0")
        this.dropdownId.classList.add("pointer-events-none")
    }
}