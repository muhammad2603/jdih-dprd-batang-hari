import EmbedPDF from '/assets/third-party/embedpdf/snippet/dist/embedpdf.js'
const pdfViewer = document.getElementById('pdfViewer');
const src = pdfViewer.dataset.src;
const viewer = EmbedPDF.init({
    type: 'container',
    target: pdfViewer,
    documentManager: {
        initialDocuments: [{
            url: src,
            documentId: 'document',
        }]
    },
    theme: {
        preference: 'system'
    },
    disabledCategories: [
        'annotation',
        'insert',
        'form',
        'history',
        'redaction',
        'document',
        'panel-search',
        'panel-comment',
        'tools'
    ],
    pan: {
        defaultMode: 'mobile'
    }
});

const registry = await viewer.registry;
const panPlugin = registry.getPlugin('pan').provides();
const docPan = panPlugin.forDocument('document');
docPan.enablePan();