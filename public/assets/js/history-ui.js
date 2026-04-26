// __COMMENT__ Jika tracking history juga digunakan dihalaman selain view/produk_hukum_details, pindahkan ke-dalam Class agar penggunaan lebih re-usable
document.addEventListener("DOMContentLoaded", function () {
    const changeHistoryWrapper = document.getElementById("changeHistoryWrapper");
    const contentHistoryWrapper = document.getElementById("contentHistoryWrapper");
    const contents = contentHistoryWrapper.querySelectorAll(".change-history");
    const dotHistoryWrapper = document.createElement("div");
    const dot = document.createElement("div");
    dotHistoryWrapper.classList.add("dot-history", "absolute", "left-3", "w-6", "h-6", "rounded-full", "border-2", "flex", "items-center", "justify-center")
    dot.classList.add("dot", "w-2", "h-2", "rounded-full", "bg-current")
    dotHistoryWrapper.append(dot)
    const dotsFragment = document.createDocumentFragment();
    const gapPosFromTop = 12;
    contents.forEach((el, idx) => {
        const offsetTopEl = el.offsetTop;
        const cloneDot = dotHistoryWrapper.cloneNode(true);
        let calcPosWithGap;
        if (offsetTopEl === 0) {
            calcPosWithGap = offsetTopEl;
            cloneDot.classList.add("bg-green-100", "border-green-300")
        } else {
            calcPosWithGap = offsetTopEl + gapPosFromTop;
            cloneDot.classList.add("bg-gray-100", "border-gray-300")
        }
        cloneDot.style.top = `${calcPosWithGap}px`;
        dotsFragment.appendChild(cloneDot)
    })
    changeHistoryWrapper.appendChild(dotsFragment);
})