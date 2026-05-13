import { classManipulation } from './class-manipulation.js';
document.addEventListener("DOMContentLoaded", () => {
    const openSearchBtn = document.getElementById("openSearch");
    const searchWrapper = document.getElementById("searchWrapper");
    const searchDocumentBtn = document.getElementById("searchDocumentBtn");
    const searchDocumentInput = document.getElementById("searchDocument");
    const selectCategoryDocument = document.getElementById("categoryDocument");
    const selectYearDocument = document.getElementById("yearDocument");
    let stateSearch = false;
    openSearchBtn.addEventListener("click", function () {
        const iconOpenSearchBtn = this.querySelector('svg');
        if (stateSearch === false) {
            classManipulation(iconOpenSearchBtn).toggle('rotate-180')
            classManipulation(searchWrapper).toggle('hidden', 'grid')
            stateSearch = true;
        } else {
            classManipulation(iconOpenSearchBtn).toggle('rotate-180')
            classManipulation(searchWrapper).toggle('grid', 'hidden')
            stateSearch = false;
        }
    })
    searchDocumentBtn.addEventListener("click", () => {
        const searchDocumentValue = searchDocumentInput.value;
        const categoryDocument = selectCategoryDocument.value;
        const yearDocument = selectYearDocument.value;
        const keyword = searchDocumentValue !== '' ? searchDocumentValue.toLowerCase() : false;
        const category = categoryDocument !== '*' ? parseInt(categoryDocument) : false;
        const year = yearDocument !== "*" ? yearDocument : false;
        const queryParams = new URLSearchParams();
        if (keyword !== false) {
            queryParams.append("keyword", keyword)
        }
        if (category !== false) {
            queryParams.append("category", category)
        }
        if (year !== false) {
            queryParams.append("year", year)
        }
        const endpoint = '/produk-hukum?' + queryParams;
        window.location.href = endpoint;
    })
})