import { $id, $$ } from './dom.js';
import { validations } from './validations.js';

const vld = new validations();

document.addEventListener("DOMContentLoaded", () => {
    const submitSearchBtn = $id("submitSearchBtn");
    const searchInput = $id("searchInput");
    const yearDocument = $id("yearDocument");
    const uriPath = window.location.pathname + '?';
    submitSearchBtn.addEventListener("click", () => {
        const searchValue = $$(searchInput).getInputValue().toLowerCase();
        const yearValue = $$(yearDocument).getInputValue();
        const queryParams = new URLSearchParams();
        const isEmptySearch = validations(searchValue).isEmptyValue();
        const isYearDefaultalue = validations(yearValue).isInvalidValue("*");
        if (!isEmptySearch) {
            queryParams.append("keyword", searchValue)
        }
        if (!isYearDefaultalue) {
            queryParams.append("year", yearValue)
        }
        window.location.href = uriPath + queryParams.toString();
    })
})