import { ShowDropdownByButton } from "./dropdown-by-button-class.js";
/**
 * Fungsi akan membuka dropdown target dan menghapus dropdown lain agar tidak terjadi tabrakan atau collapse satu sama lain.
 * @param {ShowDropdownByButton} classForDropdownToOpen - Class dropdown yang diinisialisasi untuk membuka dropdown.
 * @param {ShowDropdownByButton|null} classForDropdownToClose - Class dropdown yang diinisialisasi untuk menutup dropdown, biarkan null jika dropdown tidak tumpang tindih.
 */
function openDropdownAndCloseOther(classForDropdownToOpen, classForDropdownToClose = null) {
    classForDropdownToOpen.openDropdown()
    if (classForDropdownToClose !== null && classForDropdownToClose.stateDropdown === true) {
        classForDropdownToClose.closeDropdown()
    }
}
/**
 * Async Function: Untuk menyalin teks ke-clipboard
 * @param {string} text - Teks yang akan disalin
 * @returns {boolean}
 */
async function copyText(text) {
    try {
        await navigator.clipboard.writeText(text)
        alert("Link berhasil disalin.")
        return true;
    } catch (error) {
        alert("Error: Gagal menyalin link.")
        return false;
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const showDropdownShare = new ShowDropdownByButton({ targetButtonId: "btnShareDropdown", targetDropdownId: "shareDropdown" });
    const btnDownloads = document.getElementById("btnDownloads");
    const btnCopyLink = document.getElementById("btnCopyLink");
    const getLink = window.location.href;
    btnCopyLink.addEventListener("click", () => copyText(getLink))
    const gap = 18;
    btnDownloads.addEventListener("click", function () {
        const heightHeaderNav = document.getElementById("headerNav").getBoundingClientRect().height;
        const heightBaseParentBtn = document.getElementById("stickyTop").getBoundingClientRect().height;
        const positionTopAttachmentsWrapper = document.getElementById("lampiran").offsetTop;
        const calcPosition = (positionTopAttachmentsWrapper - heightBaseParentBtn) - heightBaseParentBtn - gap;
        window.scrollTo(0, calcPosition)
    })
    window.addEventListener("click", e => {
        const eventTarget = e.target;
        const {
            isTargetButton: isTargetBtnShareDropdown,
            isTargetDropdown: isTargetShareDropdown,
            isNotTargetsClicked: isShareNotTargeted
        } = showDropdownShare.checkClosestTarget(eventTarget)
        if (isShareNotTargeted) {
            showDropdownShare.closeDropdown()
        }
        if (isTargetShareDropdown) return;
        if (isTargetBtnShareDropdown && showDropdownShare.stateDropdown === false) {
            return openDropdownAndCloseOther(showDropdownShare);
        }
        if (isTargetBtnShareDropdown && showDropdownShare.stateDropdown === true) {
            showDropdownShare.closeDropdown()
        }
    })
})