import { classManipulation } from "./class-manipulation.js";
/**
 * Memberikan disabled pada tombol didalam NodeList
 * @param {NodeList} buttons - NodeList elemen yang akan di-disabled
 * @param {Boolean} isDisabled - Status disabled. Default true.
 * @returns {void}
 */
const disabledButtons = (buttons, isDisabled = true) => buttons.forEach(el => el.disabled = isDisabled);
// Endpoint pencariang
const pathLocationSearch = '/produk-hukum?';
document.addEventListener("DOMContentLoaded", () => {
    const btnFilterSearchDocument = document.getElementById("filterSearchDocument");
    const filterDropdown = document.getElementById("filterDropdown");
    const searchDocumentInput = document.getElementById("searchDocument");
    const getFilterDropdownFullHeightByChildren = Array.from(filterDropdown.children)
        .map(child => child.getBoundingClientRect().height + parseFloat(getComputedStyle(child).marginTop))
        .reduce((acc, num) => num + acc);
    const initHeight = `${getFilterDropdownFullHeightByChildren}px`;
    const filtersValue = {
        category: null,
        year: null,
        status: null,
    };
    const selectsFilter = document.querySelectorAll("#filterDropdown select");
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
            state = false;
            filterDropdown.style.height = '0px';
            classManipulation(btnFilterSearchDocument)
                .remove("bg-primary/90", "text-foreground")
                .add("hover:bg-primary/90", "hover:text-foreground", "bg-muted")
        }
    })
    btnFastFilters.forEach(el => el.addEventListener("click", function () {
        const isCurrentFilterActive = this.classList.contains("active");
        if (isCurrentFilterActive === true) return
        const getSelectedFilters = this.dataset.categoryValue;
        if (getSelectedFilters === "*") {
            filtersValue.category = null;
        } else {
            filtersValue.category = getSelectedFilters;
        }
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
    selectsFilter.forEach((el, idx) => el.addEventListener("input", () => {
        const filterIdentity = el.dataset.filterIdentity;
        const value = el.value;
        disabledButtons(btnFastFilters)
        if (value !== "off") {
            filtersValue[filterIdentity] = value;
        } else {
            filtersValue[filterIdentity] = null;
        }
        const isAllFiltersValueNull = filtersValue.category === null && filtersValue.year === null && filtersValue.status === null;
        if (isAllFiltersValueNull) {
            disabledButtons(btnFastFilters, false)
            const getLastFastFilterSelected = document.querySelector("#fastFilter > button[type=button].active").dataset.categoryValue;
            filtersValue.category = getLastFastFilterSelected !== "*" ? getLastFastFilterSelected : null;
        }
    }))
    btnResetFilter.addEventListener("click", () => {
        selectsFilter.forEach(el => el.selectedIndex = 0)
        disabledButtons(btnFastFilters, false)
        const getLastFastFilterSelected = document.querySelector("#fastFilter > button[type=button].active").dataset.categoryValue;
        filtersValue.category = getLastFastFilterSelected !== "*" ? getLastFastFilterSelected : null;
        filtersValue.year = null;
        filtersValue.status = null;
    })
    const btnSearch = document.getElementById("btnSearch");
    btnSearch.addEventListener("click", () => {
        const searchValue = searchDocumentInput.value.toLowerCase();
        const isAllFiltersValueNull = searchValue === "" && filtersValue.category === null && filtersValue.year === null && filtersValue.status === null;
        if (isAllFiltersValueNull) return;
        const queryParams = new URLSearchParams();
        queryParams.append("keyword", searchValue)
        Object.entries(filtersValue).forEach(([name, value]) => {
            if (value !== null) {
                queryParams.append(name, value)
            }
        })
        window.location.href = pathLocationSearch + queryParams.toString();
    })
})