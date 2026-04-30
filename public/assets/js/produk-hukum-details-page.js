// const openPrintDropdown = (element, stateDropdown) => {
//     element.classList.remove("-translate-y-8")
//     element.classList.remove("opacity-0")
//     if (stateDropdown) {
//         setTimeout(() => element.classList.remove("pointer-events-none"), 300)
//         return;
//     }
//     element.classList.remove("pointer-events-none")
// }
// const closePrintDropdown = element => {
//     element.classList.add("-translate-y-8")
//     element.classList.add("opacity-0")
//     element.classList.add("pointer-events-none")
// }

class ShowDropdownByButton {
    constructor({ targetDropdownId }) {
        this.dropdownId = targetDropdownId;
    }

    openDropdown(stateDropdown) {
        this.dropdownId.classList.remove("-translate-y-8")
        this.dropdownId.classList.remove("opacity-0")
        if (stateDropdown) {
            setTimeout(() => this.dropdownId.classList.remove("pointer-events-none"), 300)
            return;
        }
        this.dropdownId.classList.remove("pointer-events-none")
    }

    closeDropdown(stateDropdown) {
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

    window.addEventListener("click", e => {
        const showDropdownPrint = new ShowDropdownByButton({ targetDropdownId: printDropdown });
        const showDropdownShare = new ShowDropdownByButton({ targetDropdownId: shareDropdown });

        // TODO Lakukan refactoring dari kode yang memiliki duplikasi 
        // #1
        const isTargetBtnPrintDropdown = e.target.closest("#btnPrintDropdown");
        const isTargetPrintDropdown = e.target.closest("#printDropdown");
        const isPrintNotTargeted = isTargetBtnPrintDropdown === null && isTargetPrintDropdown === null;
        // DUPLICATE TO #1
        const isTargetBtnShareDropdown = e.target.closest("#btnShareDropdown");
        const isTargetShareDropdown = e.target.closest("#shareDropdown");
        const isShareNotTargeted = isTargetBtnShareDropdown === null && isTargetShareDropdown === null;

        // #3
        // Jika tombol atau dropdown dari print dan share yang tidak menjadi target
        if (isPrintNotTargeted && isShareNotTargeted) {
            // Tutup semua dropdown-nya dan perbarui state-nya
            isPrintDropdownOpen = false;
            showDropdownPrint.closeDropdown(isPrintDropdownOpen)
            isShareDropdownOpen = false;
            showDropdownShare.closeDropdown(isShareDropdownOpen)
        }
        // #3
        // Jika yang menjadi target adalah dropdown print dan share
        if (isTargetPrintDropdown || isTargetShareDropdown) {
            // jangan lakukan aksi dibawah
            return;
        }

        // #4
        // Jika yang menjadi target adalah tombol print dan state dropdown print-nya false (masih tertutup)
        if (isTargetBtnPrintDropdown && isPrintDropdownOpen === false) {
            // Buka dropdown-nya
            isPrintDropdownOpen = true;
            showDropdownPrint.openDropdown(isPrintDropdownOpen)
            // #4_1
            // Jika state dropdown share masih atau sedang terbuka
            if (isShareDropdownOpen) {
                // Tutup dropdown-nya
                isShareDropdownOpen = false;
                showDropdownShare.closeDropdown()
            }
            // Hentikan eksekusi
            return;
        }

        // #5
        // Jika yang menjadi target adalah tombol print dan state dropdown print-nya true (masih terbuka)
        if (isTargetBtnPrintDropdown && isPrintDropdownOpen === true) {
            // Tutup dropdown-nya
            isPrintDropdownOpen = false;
            showDropdownPrint.closeDropdown()
            // Hentikan eksekusi
            return;
        }

        // DUPLICATE TO #4
        if (isTargetBtnShareDropdown && isShareDropdownOpen === false) {
            isShareDropdownOpen = true;
            showDropdownShare.openDropdown(isShareDropdownOpen)
            // DUPLICATE TO #4_1
            if (isPrintDropdownOpen) {
                isPrintDropdownOpen = false;
                showDropdownPrint.closeDropdown()
            }
            return;
        }

        // DUPLICATE TO #5
        if (isTargetBtnShareDropdown && isShareDropdownOpen === true) {
            isShareDropdownOpen = false;
            showDropdownShare.closeDropdown()
            return;
        }
    })
})