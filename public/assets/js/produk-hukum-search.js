const fetchData = (config, success) => {
    const { url, method, contentType } = config;
    fetch(url, {
        method: method,
        headers: {
            "Content-Type": contentType
        },
        // body: JSON.stringify(payload)
    })
        .then(resp => {
            return resp.json()
        })
        .then(data => success(data))
        .catch(e => console.error(e))
        .finally(() => console.log('Request ditutup.'));
}

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
        const endpoint = '/api/cari-dokumen?' + queryParams;

        if (keyword === false && category === false && year === false) return alert("Tentukan kata kunci pencarian, kategori, atau tahun.");
        if (year !== false && keyword === false && category === false) return alert("Tentukan kata kunci pencarian atau kategori.");

        fetchData({
            url: endpoint,
            method: 'GET',
        }, res => {
            const { data, pagination } = res;
            document.getElementById('listDokumen').innerHTML = data;
            document.getElementById('paginationWrapper').innerHTML = pagination.pager;
        });
    })
})