document.addEventListener("DOMContentLoaded", () => {
    const { pdfjsLib } = globalThis;
    pdfjsLib.GlobalWorkerOptions.workerSrc = "/assets/third-party/pdfjs/build/pdf.worker.mjs";
    let pdfDoc = null;
    let totalPage = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    const scale = 1.2;
    const canvas = document.getElementById("pdfContent");
    const ctx = canvas.getContext('2d');
    const src = document.getElementById("pdfViewer").dataset.src;
    const currPage = document.getElementById('currPage');
    const totalPageSpan = document.getElementById('totalPage');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    /**
     * Render halaman PDF berdasarkan nomor halaman
     * @param num Page number.
     */
    function renderPage(num) {
        if (num <= 1) {
            prevPageBtn.setAttribute("disabled", true)
        } else {
            prevPageBtn.removeAttribute("disabled")
        }
        if (num >= totalPage) {
            nextPageBtn.setAttribute("disabled", true)
        } else {
            nextPageBtn.removeAttribute("disabled")
        }
        pageRendering = true;
        pdfDoc.getPage(num).then(function (page) {
            const viewport = page.getViewport({ scale: scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            const renderTask = page.render(renderContext);

            // Wait for rendering to finish
            renderTask.promise.then(function () {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
        currPage.textContent = num;
    }
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }
    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }
    prevPageBtn.addEventListener('click', onPrevPage);
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }
    nextPageBtn.addEventListener('click', onNextPage);
    pdfjsLib.getDocument({ data: atob(src) }).promise.then(function (pdfDoc_) {
        pdfDoc = pdfDoc_;
        const getTotalPage = pdfDoc.numPages;
        totalPage = getTotalPage;
        totalPageSpan.textContent = getTotalPage;
        renderPage(pageNum);
    });
})