import { classManipulation } from "./class-manipulation.js";
/**
 * Memberikan disabled pada tombol didalam NodeList
 * @param {NodeList} buttons - NodeList elemen yang akan di-disabled
 * @param {Boolean} isDisabled - Status disabled. Default true.
 * @returns {void}
 */
const disabledButtons = (buttons, isDisabled = true) => buttons.forEach(el => el.disabled = isDisabled);
document.addEventListener("DOMContentLoaded", () => {
    const btnFilterSearchDocument = document.getElementById("filterSearchDocument");
    const filterDropdown = document.getElementById("filterDropdown");
    const initHeight = "167px";
    const filtersValue = {
        jenisDokumen: null,
        tahun: null,
        statusBerlaku: null,
    }
    let state = false;
    const btnFastFilters = document.querySelectorAll("#fastFilter > button[type=button]");
    btnFilterSearchDocument.addEventListener("click", function () {
        if (state === false) {
            state = true;
            filterDropdown.style.height = initHeight;
            classManipulation(btnFilterSearchDocument)
                .remove("hover:bg-primary/90", "hover:text-foreground", "bg-muted")
                .add("bg-primary/90", "text-foreground")
        } else {
            const isAllFiltersValueNull = filtersValue.jenisDokumen === null && filtersValue.tahun === null && filtersValue.statusBerlaku === null;
            state = false;
            filterDropdown.style.height = '0px';
            classManipulation(btnFilterSearchDocument)
                .remove("bg-primary/90", "text-foreground")
                .add("hover:bg-primary/90", "hover:text-foreground", "bg-muted")
            if (isAllFiltersValueNull) {
                disabledButtons(btnFastFilters, false)
            }
        }
    })
    btnFastFilters.forEach(el => el.addEventListener("click", function () {
        const isCurrentFilterActive = this.classList.contains("active");
        if (isCurrentFilterActive === true) return
        btnFastFilters.forEach(el => {
            classManipulation(el)
                .add("bg-muted", "hover:bg-primary", "hover:text-white")
                .remove("active", "bg-primary", "text-white")
        })
        classManipulation(el)
            .add(["active", "bg-primary", "text-white"])
            .remove(["bg-muted", "hover:bg-primary", "hover:text-white"])
    }))
    const btnResetFilter = document.getElementById("resetFilter");
    const selectsFilter = document.querySelectorAll("#filterDropdown select");
    selectsFilter.forEach((el, idx) => el.addEventListener("input", () => {
        const identity = el.dataset.filterIdentity;
        const value = el.value;
        disabledButtons(btnFastFilters)
        if (value !== "off") {
            filtersValue[identity] = value;
        } else {
            filtersValue[identity] = null;
        }
    }))
    btnResetFilter.addEventListener("click", () => {
        selectsFilter.forEach(el => el.selectedIndex = 0)
        disabledButtons(btnFastFilters, false)
    })
})