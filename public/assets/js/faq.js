document.addEventListener("DOMContentLoaded", () => {
    const faqsBtn = Array.from(document.getElementById("faqWrapper").querySelectorAll(".faq > button.faq-toggle-btn"));
    const inputSearchFaq = document.getElementById("inputSearchFaq");
    const btnSearchFaq = document.getElementById("btnSearchFaq");
    let currentSearchParam = window.location.search;
    for (const btn of faqsBtn) {
        btn.addEventListener("click", function () {
            const getDetailsFaq = this.nextElementSibling;
            getDetailsFaq.classList.toggle("hidden")
        })
    }
    btnSearchFaq.addEventListener("click", () => {
        const inputSearchValue = inputSearchFaq.value.toLowerCase();
        if (inputSearchValue === "") return;
        const queryParams = new URLSearchParams();
        queryParams.append("keyword", inputSearchValue)
        if(currentSearchParam === "") {
            currentSearchParam += `?${queryParams.toString()}`;
        }else {
            currentSearchParam += `&${queryParams.toString()}`;
        }
        window.location.href = `/faq${currentSearchParam}`;
    })
})