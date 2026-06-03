import { classManipulation } from './class-manipulation.js';
import { $id, $$, $ } from './dom.js';
document.addEventListener("DOMContentLoaded", () => {
    const { pdfjsLib } = globalThis;
    pdfjsLib.GlobalWorkerOptions.workerSrc = "/assets/third-party/pdfjs/build/pdf.worker.mjs";
    let pdfDoc = null;
    let totalPage = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    const scale = 1.2;
    const canvas = $id("pdfContent");
    const ctx = canvas.getContext('2d');
    const src = $id("pdfViewer").dataset.src;
    const currPage = $id('currPage');
    const totalPageSpan = $id('totalPage');
    const prevPageBtn = $id('prevPage');
    const nextPageBtn = $id('nextPage');
    /**
     * Render halaman PDF berdasarkan nomor halaman
     * @param num Page number.
     */
    function renderPage(num) {
        if (num <= 1) {
            $$(prevPageBtn).setAttr("disabled", true)
        } else {
            $$(prevPageBtn).removeAttr("disabled")
        }
        if (num >= totalPage) {
            $$(nextPageBtn).setAttr("disabled", true)
        } else {
            $$(nextPageBtn).removeAttr("disabled")
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
            renderTask.promise.then(function () {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
        $$(currPage).text(num)
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
        if (pageNum >= totalPage) {
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
        $$(totalPageSpan).text(getTotalPage)
        $$(prevPageBtn).removeAttr("hidden")
        renderPage(pageNum);
    });
})