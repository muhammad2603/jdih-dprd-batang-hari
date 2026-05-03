import { ShowDropdownByButton } from "./dropdown-by-button-class.js";
function openDropdownAndCloseOther(classForDropdownToOpen, classForDropdownToClose) {
    classForDropdownToOpen.openDropdown()
    if (classForDropdownToClose.stateDropdown === true) {
        classForDropdownToClose.closeDropdown()
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const showDropdownPrint = new ShowDropdownByButton({ targetButtonId: "btnPrintDropdown", targetDropdownId: "printDropdown" });
    const showDropdownShare = new ShowDropdownByButton({ targetButtonId: "btnShareDropdown", targetDropdownId: "shareDropdown" });
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
    window.addEventListener("click", e => {
        const eventTarget = e.target;
        const {
            isTargetButton: isTargetBtnPrintDropdown,
            isTargetDropdown: isTargetPrintDropdown,
            isNotTargetsClicked: isPrintNotTargeted
        } = showDropdownPrint.checkClosestTarget(eventTarget)
        const {
            isTargetButton: isTargetBtnShareDropdown,
            isTargetDropdown: isTargetShareDropdown,
            isNotTargetsClicked: isShareNotTargeted
        } = showDropdownShare.checkClosestTarget(eventTarget)
        if (isPrintNotTargeted && isShareNotTargeted) {
            showDropdownPrint.closeDropdown()
            showDropdownShare.closeDropdown()
        }
        if (isTargetPrintDropdown || isTargetShareDropdown) return;
        if (isTargetBtnPrintDropdown && showDropdownPrint.stateDropdown === false) {
            return openDropdownAndCloseOther(showDropdownPrint, showDropdownShare);
        }
        if (isTargetBtnShareDropdown && showDropdownShare.stateDropdown === false) {
            return openDropdownAndCloseOther(showDropdownShare, showDropdownPrint);
        }
        if (isTargetBtnPrintDropdown && showDropdownPrint.stateDropdown === true) {
            showDropdownPrint.closeDropdown()
        }
        if (isTargetBtnShareDropdown && showDropdownShare.stateDropdown === true) {
            showDropdownShare.closeDropdown()
        }
    })
})