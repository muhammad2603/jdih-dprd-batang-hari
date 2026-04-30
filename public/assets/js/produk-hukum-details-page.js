const openPrintDropdown = (element, stateDropdown) => {
    element.classList.remove("-translate-y-8")
    element.classList.remove("opacity-0")
    if (stateDropdown) {
        setTimeout(() => element.classList.remove("pointer-events-none"), 300)
        return;
    }
    element.classList.remove("pointer-events-none")
}
const closePrintDropdown = element => {
    element.classList.add("-translate-y-8")
    element.classList.add("opacity-0")
    element.classList.add("pointer-events-none")
}
document.addEventListener("DOMContentLoaded", function () {
    const btnDownloads = document.getElementById("btnDownloads");
    const gap = 18;
    btnDownloads.addEventListener("click", function () {
        const heightHeaderNav = document.getElementById("headerNav").getBoundingClientRect().height;
        const heightBaseParentBtn = document.getElementById("stickyTop").getBoundingClientRect().height;
        const positionTopAttachmentsWrapper = document.getElementById("lampiran").offsetTop;
        const calcPosition = (positionTopAttachmentsWrapper - heightBaseParentBtn) - heightBaseParentBtn - gap;
        window.scrollTo(0, calcPosition)
    })
    const btnPrintPdf = document.querySelectorAll("#printDropdown > button.print-btn");
    btnPrintPdf.forEach(btn => {
        btn.addEventListener('click', function () {
            const dataBtn = this.dataset.indexToDocument;
            const iframedDocument = document.querySelector(`iframe[data-document-index=${dataBtn}]`);
            iframedDocument.contentWindow.print();
        })
    })
    const btnPrintDropdown = document.getElementById("btnPrintDropdown");
    const printDropdown = document.getElementById("printDropdown");
    let isPrintDropdownOpen = false;
    window.addEventListener("click", e => {
        const targetEl = e.target;
        const isTargetBtnPrintDropdown = targetEl.closest("#btnPrintDropdown");
        const isTargetPrintDropdown = targetEl.closest("#printDropdown");
        if (isTargetPrintDropdown) {
            return;
        } else if (isTargetBtnPrintDropdown && isPrintDropdownOpen === false) {
            isPrintDropdownOpen = true;
            openPrintDropdown(printDropdown, isPrintDropdownOpen)
            return;
        } else {
            isPrintDropdownOpen = false;
            closePrintDropdown(printDropdown)
        }
    })
})