import { setValue, FormTab, Form } from "./Form.js";
import { classManipulation } from "./class-manipulation.js";
import { $, $id, $$ } from "./dom.js";
const form = new Form();
document.addEventListener("DOMContentLoaded", () => {
    const btnTab = document.querySelectorAll('.tabs-form > button');
    const tabs = document.querySelectorAll('.tab');
    const formTab = new FormTab(btnTab, tabs);
    btnTab.forEach(items => {
        items.addEventListener('click', function () {
            formTab.openTab(this);
        })
    })
    const withoutHistory = $id('withoutHistory');
    const historyComment = $id('historyComment');
    withoutHistory.addEventListener('change', function () {
        const isChecked = this.checked;
        if (isChecked) {
            historyComment.disabled = true;
        } else {
            historyComment.disabled = false;
        }
    })
    const salinTanggalPengundangan = $id('salinTanggalPengundangan');
    const inputTanggalPengundangan = $id('tanggalPengundangan');
    const inputTanggalBerlaku = $id('tanggalBerlaku');
    let isCheckedSalinTanggalPengundangan = false;
    inputTanggalPengundangan.addEventListener('change', function () {
        const input = this;
        if (isCheckedSalinTanggalPengundangan) {
            form.copyValueFromOtherInput(inputTanggalBerlaku, inputTanggalPengundangan)
        }
    })
    salinTanggalPengundangan.addEventListener('change', function () {
        const isChecked = this.checked;
        if (isChecked) {
            isCheckedSalinTanggalPengundangan = true;
            form.copyValueFromOtherInput(inputTanggalBerlaku, inputTanggalPengundangan)
            form.disableInputEvent(inputTanggalBerlaku)
        } else {
            isCheckedSalinTanggalPengundangan = false;
            form.enableInputEvent(inputTanggalBerlaku)
        }
    })
    const removeClassifiesSelected = (buttonDeleteOnCategory, listClassifiesSelected) => {
        const category = buttonDeleteOnCategory.parentElement;
        const getIndexClassifyOnListArray = listClassifiesSelected.indexOf(category.dataset.category);
        $$(category).removeEl()
        listClassifiesSelected.splice(getIndexClassifyOnListArray, 1)
    }
    const insertSelected = category => {
        return `<span data-category="${category}" class="selected h-fit inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full"><span>${category}</span><button type="button" title="Hapus" class="delete-selected cursor-pointer hover:text-red-600"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3"><use href="/assets/icons.svg#icon-trash-strip"></svg></button></span>`;
    };
    const btnAddBidangHukum = $id('tambahBidangHukum');
    const bidangHukumSelect = $id('bidangHukumSelect');
    const parentSelectedBidangHukum = $id('selectedBidangHukum');
    let bidangHukumSelectedList = [];
    btnAddBidangHukum.addEventListener('click', () => {
        const getCategoryText = bidangHukumSelect.options[bidangHukumSelect.selectedIndex].text;
        const isCategoryInserted = bidangHukumSelectedList.includes(getCategoryText);
        if (isCategoryInserted) {
            return alert(`Bidang hukum "${getCategoryText}" sudah dipilih.`);
        }
        bidangHukumSelectedList.push(getCategoryText);
        $$(parentSelectedBidangHukum).insertHTML(insertSelected(getCategoryText), 'beforeend');
    })
    parentSelectedBidangHukum.addEventListener('click', e => {
        const getBtnDeleteOnCategory = e.target.closest('.delete-selected');
        if (getBtnDeleteOnCategory) {
            removeClassifiesSelected(getBtnDeleteOnCategory, bidangHukumSelectedList)
        }
    })
    const btnAddSubject = $id('tambahSubject');
    const subjectSelect = $id('subjectSelect');
    const parentSelectedSubject = $id('selectedSubject');
    let subjectSelectedList = [];
    btnAddSubject.addEventListener('click', () => {
        const getCategoryText = subjectSelect.options[subjectSelect.selectedIndex].text;
        const isCategoryInserted = subjectSelectedList.includes(getCategoryText);
        if (isCategoryInserted) {
            return alert(`Subjek "${getCategoryText}" sudah dipilih.`);
        }
        subjectSelectedList.push(getCategoryText);
        $$(parentSelectedSubject).insertHTML(insertSelected(getCategoryText), 'beforeend');
    })
    parentSelectedSubject.addEventListener('click', e => {
        const getBtnDeleteOnCategory = e.target.closest('.delete-selected');
        if (getBtnDeleteOnCategory) {
            removeClassifiesSelected(getBtnDeleteOnCategory, subjectSelectedList)
        }
    })
    const inputFileAbstractWrapper = $id('inputFileAbstractWrapper');
    const inputSelectFileAbstract = $id('inputSelectFileAbstract');
    const inputFilenameAbstract = $id('inputFilenameAbstract');
    const abstractSelected = $id('fileAbstractSelected');
    const btnDeleteSelectedAbstractFile = $id('deleteSelectedAbstractFile');
    let fileAbstract = null;
    inputSelectFileAbstract.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        // __COMMENT__ Tambahkan validasi untuk file disisi client
        fileAbstract = file;
        const replaceFilenameExtension = file.name.replace('.pdf', '')
        classManipulation(abstractSelected).remove('hidden')
        classManipulation(inputFileAbstractWrapper).add('hidden')
        setValue(inputFilenameAbstract, replaceFilenameExtension)
    })
    btnDeleteSelectedAbstractFile.addEventListener('click', () => {
        if (!fileAbstract) return;
        fileAbstract = null;
        setValue(inputFilenameAbstract, "")
        classManipulation(abstractSelected).add('hidden')
        classManipulation(inputFileAbstractWrapper).remove('hidden')
    })
    const relatedDocumentWrapper = $id('relatedDocumentWrapper');
    const btnAddRelatedDoc = $id('addRelated');
    const relatedDocumentInputs = $('.related-document-inputs');
    const selectFirstBtnDeleteRelated = () => $('.related-document-inputs > .btn-delete-related');
    let relatedDocumentCounter = 1;
    btnAddRelatedDoc.addEventListener('click', () => {
        classManipulation(selectFirstBtnDeleteRelated()).remove('hidden')
        const clone = relatedDocumentInputs.cloneNode(true);
        $$(relatedDocumentWrapper).insertHTML(clone.outerHTML, 'beforeend')
        relatedDocumentCounter++;
    })
    relatedDocumentWrapper.addEventListener('click', e => {
        const targetBtnDeleteRelatedDocument = e.target.closest('.btn-delete-related');
        if (!targetBtnDeleteRelatedDocument) return;
        relatedDocumentCounter--;
        $$(targetBtnDeleteRelatedDocument.parentElement).removeEl()
        if (relatedDocumentCounter === 1) {
            classManipulation(selectFirstBtnDeleteRelated()).add('hidden')
        }
    })
    const createInputFileNameAttachment = filename => {
        return `<div class="w-full flex items-center gap-3"><label class="shrink-0"><span class="text-sm text-gray-500">Nama Berkas:</span></label><input type="text" value="${filename}" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" /><button type="button" title="Hapus" data-filename="${filename}" class="delete-file p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><use href="/assets/icons.svg#icon-trash-strip" /></svg></button></div>`;
    }
    const btnAddAttachments = $id('addAttachments');
    const attachmentsSelected = $id('attachmentsSelected');
    const attachmentInputFile = $id('attachment');
    let fileAttachmentsSelected = [];
    let filenameAttachmentsSelected = [];
    attachmentInputFile.addEventListener('change', function () {
        const files = Array.from(this.files);
        if (!files[0]) return;
        for (const file of files) {
            const filename = file.name;
            const replacePdfExtension = filename.replace('.pdf', '');
            if (filenameAttachmentsSelected.includes(replacePdfExtension)) {
                alert(`File ${filename} sudah ditambahkan`);
                continue;
            }
            filenameAttachmentsSelected.push(replacePdfExtension);
            fileAttachmentsSelected.push(file);
            $$(attachmentsSelected).insertHTML(
                createInputFileNameAttachment(replacePdfExtension),
                'beforeend'
            );
        }
        // note: value input file dikosongkan karena semua file yang dipilih disimpan ke-array fileAttachmentsSelected dan filenameAttachmentsSelecteds
        this.value = '';
        if (fileAttachmentsSelected.length > 0) {
            classManipulation(this.parentElement).add('hidden')
            classManipulation(btnAddAttachments.parentElement).remove('hidden')
            classManipulation(btnAddAttachments.parentElement).add('flex')
            classManipulation(attachmentsSelected).remove('hidden')
        }
    })
    attachmentsSelected.addEventListener('click', e => {
        const btnDeleteAttachment = e.target.closest('.delete-file');
        if (!btnDeleteAttachment) return;
        const inputsWrapper = btnDeleteAttachment.parentElement;
        const getFilename = btnDeleteAttachment.dataset.filename;
        const getIndexFilenameOnArraySelected = filenameAttachmentsSelected.indexOf(getFilename);
        $$(inputsWrapper).removeEl(inputsWrapper)
        fileAttachmentsSelected.splice(getIndexFilenameOnArraySelected, 1)
        filenameAttachmentsSelected.splice(getIndexFilenameOnArraySelected, 1)
        if (filenameAttachmentsSelected.length === 0) {
            classManipulation(attachmentInputFile.parentElement).remove('hidden')
            classManipulation(btnAddAttachments.parentElement).remove('flex')
            classManipulation(btnAddAttachments.parentElement).add('hidden')
            classManipulation(attachmentsSelected).add('hidden')
        }
    })
    btnAddAttachments.addEventListener('click', () => attachmentInputFile.click())
})