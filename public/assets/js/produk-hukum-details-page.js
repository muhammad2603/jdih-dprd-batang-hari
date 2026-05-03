class ShowDropdownByButton {
    constructor({ targetDropdownId }) {
        this.dropdownId = targetDropdownId;
        this.stateDropdown = false;
    }

    updateStateDropdown(state = null) {
        return this.stateDropdown = state === null ? !this.stateDropdown : state;
    }

    checkClosestTarget(eventTarget, buttonId, dropdownId) {
        return {
            isTargetButton: eventTarget.closest(`#${buttonId}`),
            isTargetDropdown: eventTarget.closest(`#${dropdownId}`),
            get isNotTargetsClicked() {
                return this.isTargetButton === null && this.isTargetDropdown === null
            }
        }
    }

    openDropdown(stateDropdown) {
        this.updateStateDropdown(true)
        this.dropdownId.classList.remove("-translate-y-8")
        this.dropdownId.classList.remove("opacity-0")
        if (stateDropdown) {
            setTimeout(() => this.dropdownId.classList.remove("pointer-events-none"), 300)
            return;
        }
        this.dropdownId.classList.remove("pointer-events-none")
    }

    closeDropdown(stateDropdown) {
        this.updateStateDropdown(false)
        this.dropdownId.classList.add("-translate-y-8")
        this.dropdownId.classList.add("opacity-0")
        this.dropdownId.classList.add("pointer-events-none")
    }
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

    const btnShareDropdown = document.getElementById("btnShareDropdown");
    const shareDropdown = document.getElementById("shareDropdown");
    let isShareDropdownOpen = false;

    const showDropdownPrint = new ShowDropdownByButton({ targetDropdownId: printDropdown });
    const showDropdownShare = new ShowDropdownByButton({ targetDropdownId: shareDropdown });

    window.addEventListener("click", e => {
        const eventTarget = e.target;
        const {
            isTargetButton: isTargetBtnPrintDropdown,
            isTargetDropdown: isTargetPrintDropdown,
            isNotTargetsClicked: isPrintNotTargeted
        } = showDropdownPrint.checkClosestTarget(eventTarget, "btnPrintDropdown", "printDropdown")
        const {
            isTargetButton: isTargetBtnShareDropdown,
            isTargetDropdown: isTargetShareDropdown,
            isNotTargetsClicked: isShareNotTargeted
        } = showDropdownShare.checkClosestTarget(eventTarget, "btnShareDropdown", "shareDropdown")

        // #3
        if (isPrintNotTargeted && isShareNotTargeted) {
            showDropdownPrint.closeDropdown()
            showDropdownShare.closeDropdown()
        }

        // #3
        if (isTargetPrintDropdown || isTargetShareDropdown) {
            return;
        }

        // #4
        // Jika yang menjadi target adalah tombol print dan state dropdown print-nya false (masih tertutup)
        if (isTargetBtnPrintDropdown && showDropdownPrint.stateDropdown === false) {
            // Buka dropdown-nya
            showDropdownPrint.openDropdown()
            // #4_1
            // Jika state dropdown share masih atau sedang terbuka
            if (showDropdownShare.stateDropdown === true) {
                // Tutup dropdown-nya
                showDropdownShare.closeDropdown()
            }
            // Hentikan eksekusi
            return;
        }

        // #5
        // Jika yang menjadi target adalah tombol print dan state dropdown print-nya true (masih terbuka)
        if (isTargetBtnPrintDropdown && showDropdownPrint.stateDropdown === true) {
            // Tutup dropdown-nya
            showDropdownPrint.closeDropdown()
            // Hentikan eksekusi
            return;
        }

        // DUPLICATE TO #4
        if (isTargetBtnShareDropdown && showDropdownShare.stateDropdown === false) {
            showDropdownShare.openDropdown()
            // DUPLICATE TO #4_1
            if (showDropdownPrint.stateDropdown === true) {
                showDropdownPrint.closeDropdown()
            }
            return;
        }

        // DUPLICATE TO #5
        if (isTargetBtnShareDropdown && showDropdownShare.stateDropdown === true) {
            showDropdownShare.closeDropdown()
        }
    })
})