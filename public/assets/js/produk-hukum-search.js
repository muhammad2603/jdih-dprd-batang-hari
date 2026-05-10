document.addEventListener("DOMContentLoaded", () => {
    const searchDocumentBtn = document.getElementById("searchDocumentBtn");
    const searchDocumentInput = document.getElementById("searchDocument");
    const selectCategoryDocument = document.getElementById("categoryDocument");
    const selectYearDocument = document.getElementById("yearDocument");
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