document.addEventListener("DOMContentLoaded", () => {
    const submitSearchBtn = document.getElementById("submitSearchBtn");
    const searchInput = document.getElementById("searchInput");
    const yearDocument = document.getElementById("yearDocument");
    const uriPath = window.location.pathname + '?';
    submitSearchBtn.addEventListener("click", () => {
        if (searchInput.value === "") {
            return alert("Silahkan isi input pencarian!")
        };
        const searchValue = searchInput.value.toLowerCase();
        const yearValue = yearDocument.value;
        const queryParams = new URLSearchParams();
        queryParams.append("keyword", searchValue.trim())
        if (yearValue !== "*") {
            queryParams.append("year", yearValue)
        }
        window.location.href = uriPath + queryParams.toString();
    })
})