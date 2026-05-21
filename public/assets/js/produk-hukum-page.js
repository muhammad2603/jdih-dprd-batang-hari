import { classManipulation } from "./class-manipulation.js";
/**
 * Memberikan disabled pada tombol didalam NodeList
 * @param {NodeList} buttons - NodeList elemen yang akan di-disabled
 * @param {Boolean} isDisabled - Status disabled. Default true.
 * @returns {void}
 */
const disabledButtons = (buttons, isDisabled = true) => buttons.forEach(el => el.disabled = isDisabled);
class FilterManipulation {
    constructor() {
        this.state = false;
    }
    openDropdown(filterDropdownBtn, filterDropdownEl, height) {
        this.state = true;
        classManipulation(filterDropdownEl).inlineStyle("height", height)
        classManipulation(filterDropdownBtn)
            .remove("bg-muted")
            .add("bg-primary/90", "text-foreground");
    }
    closeDropdown(filterDropdownBtn, filterDropdownEl) {
        this.state = false;
        classManipulation(filterDropdownEl).inlineStyle("height", '0px')
        classManipulation(filterDropdownBtn)
            .remove("bg-primary/90", "text-foreground")
            .add("bg-muted");
    }
}
const getDataAttributeElement = (el, dataValue) => el.dataset[dataValue];
const appendQueryParam = (URLSearchParams, name, value) => {
    if (!value) return;
    URLSearchParams.append(name, value)
};
const appendQueryParamFromObject = (URLSearchParams, object) => {
    Object.entries(object).forEach(([name, value]) => {
        if (!value) return;
        appendQueryParam(URLSearchParams, name, value)
    })
};
const getHeightContainerByChildrens = (childrensEl, callback) => {
    return Array.from(childrensEl)
        .map(child => callback(child))
        .reduce((acc, num) => num + acc);
}
// Endpoint pencarian
const pathLocationSearch = '/produk-hukum?';
const filterDropdownClass = new FilterManipulation();
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
    const btnFastFilters = document.querySelectorAll("#fastFilter > button[type=button]");
    btnFilterSearchDocument.addEventListener("click", function () {
        if (filterDropdownClass.state === false) {
            filterDropdownClass.openDropdown(btnFilterSearchDocument, filterDropdown, initHeight)
        } else {
            filterDropdownClass.closeDropdown(btnFilterSearchDocument, filterDropdown)
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
            const getLastFastFilterSelected = getDataAttributeElement(document.querySelector("#fastFilter > button[type=button].active"), "categoryValue");
            filtersValue.category = getLastFastFilterSelected !== "*" ? getLastFastFilterSelected : null;
        }
    }))
    btnResetFilter.addEventListener("click", () => {
        selectsFilter.forEach(el => el.selectedIndex = 0)
        disabledButtons(btnFastFilters, false)
        const getLastFastFilterSelected = getDataAttributeElement(document.querySelector("#fastFilter > button[type=button].active"), "categoryValue");
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
        appendQueryParam(queryParams, "keyword", searchValue)
        appendQueryParamFromObject(queryParams, filtersValue)
        window.location.href = pathLocationSearch + queryParams.toString();
    })
})