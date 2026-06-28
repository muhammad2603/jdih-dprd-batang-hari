import { setValue, FormTab, Form } from "./Form.js";
import { classManipulation } from "./class-manipulation.js";
import { $, $id, $$ } from "./dom.js";
import { validate, validations } from "./validations.js";
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
    const insertSelected = (categoryId, category) => {
        return `<span data-category-id="${categoryId}" data-category="${category}" class="selected h-fit inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full"><span>${category}</span><button type="button" title="Hapus" class="delete-selected cursor-pointer hover:text-red-600"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3"><use href="/assets/icons.svg#icon-trash-strip"></svg></button></span>`;
    };
    const btnAddBidangHukum = $id('tambahBidangHukum');
    const bidangHukumSelect = $id('bidangHukumSelect');
    const parentSelectedBidangHukum = $id('selectedBidangHukum');
    let bidangHukumSelectedList = [];
    btnAddBidangHukum.addEventListener('click', () => {
        const getOptionSelected = bidangHukumSelect.options[bidangHukumSelect.selectedIndex];
        const getCategoryId = getOptionSelected.dataset.id;
        const getCategoryText = getOptionSelected.text;
        const isCategoryInserted = bidangHukumSelectedList.includes(getCategoryId);
        if (isCategoryInserted) {
            return alert(`Bidang hukum "${getCategoryText}" sudah dipilih.`);
        }
        bidangHukumSelectedList.push(getCategoryId);
        $$(parentSelectedBidangHukum).insertHTML(insertSelected(getCategoryId, getCategoryText), 'beforeend');
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
        const getOptionSelected = subjectSelect.options[subjectSelect.selectedIndex];
        const getCategoryId = getOptionSelected.dataset.id;
        const getCategoryText = getOptionSelected.text;
        const isCategoryInserted = subjectSelectedList.includes(getCategoryId);
        if (isCategoryInserted) {
            return alert(`Subjek "${getCategoryText}" sudah dipilih.`);
        }
        subjectSelectedList.push(getCategoryId);
        $$(parentSelectedSubject).insertHTML(insertSelected(getCategoryId, getCategoryText), 'beforeend');
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
        const allowedExtensions = ['pdf'];
        if (!validations(file.name).isAllowedFileExtension(allowedExtensions)) {
            setValue(this, "")
            return alert("Ekstensi file tidak diizinkan. Silahkan pilih file kembali dengan ekstensi pdf.")
        }
        const maximum_mb = 5;
        const isFileSizeLarge = validations(file.size).isFileSizeTooLarge(maximum_mb);
        if (isFileSizeLarge) {
            setValue(this, "")
            return alert(`Ukuran file terlalu besar (maks. ${maximum_mb} MB). Silahkan pilih file kembali!`);
        }
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
        const allowedExtensions = ['pdf'];
        for (const file of files) {
            const filename = file.name;
            const allowedExtensions = ['pdf'];
            const isExtensionFileAllowed = !validations(filename).isAllowedFileExtension(allowedExtensions);
            if (isExtensionFileAllowed) {
                setValue(this, '')
                alert(`Ekstensi file ${filename} tidak diizinkan. Silahkan pilih file kembali dengan ekstensi pdf.`)
                continue;
            }
            const maximumSizeMB = 30;
            const isSizeTooLarge = validations(file.size).isFileSizeTooLarge(maximumSizeMB);
            if (isSizeTooLarge) {
                alert(`Ukuran file ${filename} terlalu besar (maks. 30 MB). Silahkan perkecil/kompres file terlebih dahulu.`)
                continue;
            }
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
        setValue(this, '')
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
    const tokenCsrf = document.querySelector("input[name=csrf_token]");
    const titleDocument = document.getElementById("titleDocument");
    const numberAndYearDocument = document.getElementById("nomorTahun");
    const typeDocument = document.getElementById("typeDocument");
    const statusDocument = document.getElementById("statusDocument");
    const teuDocument = document.getElementById("teuDocument");
    const inputTanggalPenetapan = document.getElementById("tanggalPenetapan");
    const pembuatPeraturan = document.getElementById("pembuatPeraturan");
    const pejabatPenandatanganan = document.getElementById("penandatanganan");
    const pejabatPenetap = document.getElementById("pejabatPenetap");
    const tempatPenetapan = document.getElementById("tempatPenetapan");
    const sumber = document.getElementById("sumber");
    const noTahunTld = document.getElementById("noTahunTld");
    const note = document.getElementById("note");

    const messageTitleError = document.getElementById("titleError");
    const messageNoTahunError = document.getElementById("noTahunError");
    const messageNoTahunTldError = document.getElementById("noTahunTldError");
    const messageFilenameAbstractError = document.getElementById("filenameAbstractError");
    const messageHistoryCommentError = document.getElementById("historyCommentError");

    const withoutHistory = $id('withoutHistory');
    const historyComment = $id('historyComment');
    withoutHistory.addEventListener('change', function () {
        const isChecked = this.checked;
        if (isChecked) {
            historyComment.disabled = true;
            messageHistoryCommentError.innerText = "";
        } else {
            historyComment.disabled = false;
        }
    })
    const btnSubmit = document.getElementById("btnSubmit");
    btnSubmit.addEventListener('click', () => {
        const judulDokumenValue = titleDocument.value.trim();
        const numberAndYearDocumentValue = numberAndYearDocument.value.trim();
        const typeDocumentValue = typeDocument.value.trim();
        const statusDocumentValue = statusDocument.value.trim();
        const teuDocumentValue = teuDocument.value.trim();
        const tanggalPenetapanValue = inputTanggalPenetapan.value.trim();
        const tanggalPengundanganValue = inputTanggalPengundangan.value.trim();
        const tanggalBerlakuValue = inputTanggalBerlaku.value.trim();
        const pembuatPeraturanValue = pembuatPeraturan.value.trim();
        const pejabatPenandatangananValue = pejabatPenandatanganan.value.trim();
        const pejabatPenetapValue = pejabatPenetap.value.trim();
        const tempatPenetapanValue = tempatPenetapan.value.trim();
        const sumberValue = sumber.value.trim();
        const noTahunTldValue = noTahunTld.value.trim();
        const noteValue = note.value.trim();
        const filenameAbstractValue = inputFilenameAbstract.value.trim();
        const rules = [
            {
                value: judulDokumenValue, messageElement: messageTitleError,
                validators: [
                    { method: "isEmptyValue", parameters: [], messageError: "Harap isi bidang ini." },
                    { method: "isValidValueLength", parameters: [5, 255], messageError: "Judul terlalu pendek (min. 5 karakter dan maks. 255 karakter)." },
                ]
            },
            {
                value: filenameAbstractValue, messageElement: messageFilenameAbstractError,
                validators: [
                    { method: "isEmptyValue", parameters: [], messageError: "Judul file abstrak tidak boleh kosong." },
                    { method: "isValidValueLength", parameters: [5], messageError: "Judul file terlalu pendek (min. 5 karakter)." },
                ]
            }
        ];
        const isHasInvalid = [];
        for (const rule of rules) {
            isHasInvalid.push(!validate(rule));
        }
        const numberAndYearSplit = numberAndYearDocumentValue.split("/");
        const [number, year] = numberAndYearSplit;
        if (validations(numberAndYearDocumentValue).isEmptyValue()) {
            isHasInvalid.push(true)
            messageNoTahunError.innerText = "Harap isi bidang ini.";
        } else if (!validations(numberAndYearDocumentValue).isValueIncludedChar("/") || (validations(number).isEmptyValue() || validations(year).isEmptyValue())) {
            isHasInvalid.push(true)
            messageNoTahunError.innerText = "Format nomor dan tahun dokumen tidak valid. Contoh: 15/2021";
        } else if (validations(number).isInvalidValue(/\D/) || validations(year).isInvalidValue(/\D/)) {
            isHasInvalid.push(true)
            messageNoTahunError.innerText = "Format nomor dan tahun dokumen harus mengandung angka. Contoh: 15/2021.";
        } else if (!validations(year).isInvalidValue(undefined) && validations(year).isValidValueLength(4, 4)) { // __COMMENT__ menggunakan isInvalid diperlukan, karena, jika year memiliki nilai undefined, tidak akan bisa diambil lengthnya.
            isHasInvalid.push(true)
            messageNoTahunError.innerText = "Format tahun dokumen adalah 4 digit. Contoh: 2020, 2021, dst.";
        } else {
            messageNoTahunError.innerText = "";
        }
        const numberAndYearTldSplit = noTahunTldValue.split("/");
        const [numberTld, yearTld] = numberAndYearTldSplit;
        if (validations(noTahunTldValue).isEmptyValue()) {
            isHasInvalid.push(true)
            messageNoTahunTldError.innerText = "Harap isi bidang ini.";
        } else if (!validations(noTahunTldValue).isValueIncludedChar("/") || (validations(numberTld).isEmptyValue() || validations(yearTld).isEmptyValue())) {
            isHasInvalid.push(true)
            messageNoTahunTldError.innerText = "Format nomor dan tahun dokumen TLD tidak valid. Contoh: 15/2021.";
        } else if (validations(numberTld).isInvalidValue(/\D/) || validations(yearTld).isInvalidValue(/\D/)) {
            isHasInvalid.push(true)
            messageNoTahunTldError.innerText = "Format nomor dan tahun dokumen TLD harus mengandung angka. Contoh: 15/2021.";
        } else if (!validations(yearTld).isInvalidValue(undefined) && validations(yearTld).isValidValueLength(4, 4)) { // __COMMENT__ menggunakan isInvalid diperlukan, karena, jika yearTld memiliki nilai undefined, tidak akan bisa diambil lengthnya.
            isHasInvalid.push(true)
            messageNoTahunTldError.innerText = "Format tahun dokumen TLD adalah 4 digit. Contoh: 2020, 2021, dst.";
        } else {
            messageNoTahunTldError.innerText = "";
        }
        let relatedDocuments = {};
        relatedDocumentWrapper.querySelectorAll('.related-document-inputs')
            .forEach((element, idx) => {
                const getInputs = element.querySelectorAll('input[type=text]');
                const getSelects = element.querySelectorAll('select');
                const title = getInputs[0].value.trim();
                const numberAndYear = getInputs[1].value.trim();
                const type = getSelects[0].value.trim();
                const action = getSelects[1].value.trim();
                const isTitleEmpty = validations(title).isEmptyValue();
                const isNumberAndYearEmpty = validations(numberAndYear).isEmptyValue();
                const messageElement = element.querySelector('.related-document-error');
                if (isTitleEmpty) return;
                if (!isTitleEmpty && isNumberAndYearEmpty) {
                    return alert(`Format nomor dan tahun pada "${title}" didokumen terkait tidak benar. Contoh: 15/2021`);
                }
                const numberAndYearSplit = numberAndYear.split("/");
                const [number, year] = numberAndYearSplit;
                const isInvalidNumber = validations(number).isInvalidValue(/\D/);
                const isInvalidYear = validations(year).isInvalidValue(/\D/);
                if (!isTitleEmpty && (isInvalidNumber || isInvalidYear)) {
                    return alert(`Format nomor dan tahun pada "${title}" didokumen terkait harus mengandung angka. Contoh: 15/2021`);
                }
                const isInvalidYearLength = validations(year).isValidValueLength(4, 4);
                if (!isTitleEmpty && isInvalidYearLength) {
                    return alert(`Format tahun pada "${title}" didokumen terkait adalah 4 digit. Contoh: 2020, 2021, dst.`);
                }
                relatedDocuments[idx] = {
                    judul_dokumen_terkait: title,
                    nomor_dokumen_terkait: number,
                    tahun_dokumen_terkait: year,
                    jenis_dokumen_terkait: type,
                    aksi_dokumen_terkait: action
                }
            });
        const isHistoryCommentDisabled = historyComment.disabled;
        if (!isHistoryCommentDisabled && validations(historyComment.value.trim()).isEmptyValue()) {
            isHasInvalid.push(true)
            return messageHistoryCommentError.innerText = "Harap isi bidang ini atau berikan tanda centang pada Tanpa Riwayat.";
        } else if (!isHistoryCommentDisabled && validations(historyComment.value.trim()).isValidValueLength(8, 255)) {
            isHasInvalid.push(true)
            return messageHistoryCommentError.innerText = "Komentar riwayat perubahan terlalu pendek atau panjang (min. 8 karakter dan maks. 255 karakter).";
        } else {
            messageHistoryCommentError.innerText = "";
        }
        if (isHasInvalid.includes(true)) return;
        const formData = new FormData();
        formData.append("judul_dokumen", judulDokumenValue);
        formData.append("nomor_dokumen", number);
        formData.append("tahun_dokumen", year);
        formData.append("jenis_dokumen", typeDocumentValue);
        formData.append("status_dokumen", statusDocumentValue);
        formData.append("teu_dokumen", teuDocumentValue);
        formData.append("tanggal_penetapan", tanggalPenetapanValue);
        formData.append("tanggal_pengundangan", tanggalPengundanganValue);
        formData.append("tanggal_berlaku", tanggalBerlakuValue);
        formData.append("pembuat_peraturan", pembuatPeraturanValue);
        formData.append("pejabat_penandatanganan", pejabatPenandatangananValue);
        formData.append("pejabat_penetap", pejabatPenetapValue);
        formData.append("tempat_penetapan", tempatPenetapanValue);
        formData.append("sumber", sumberValue);
        formData.append("nomor_tld", numberTld);
        formData.append("tahun_tld", yearTld);
        if (bidangHukumSelectedList.length > 0) {
            formData.append("kategori_bidang_hukum", bidangHukumSelectedList);
        }
        if (subjectSelectedList.length > 0) {
            formData.append("kategori_subjek", subjectSelectedList);
        }
        if (noteValue !== "") {
            formData.append("catatan", noteValue);
        }
        if (fileAbstract !== null && filenameAbstractValue !== "") {
            formData.append("judul_abstrak_pdf", filenameAbstractValue)
            formData.append("abstrak_pdf", fileAbstract)
        }

        if (relatedDocumentsJsonStr !== '{}') {
            formData.append("dokumen_terkait", JSON.stringify(relatedDocuments))
        }
        let saveFilenameAttachments = [];
        filenameAttachmentsSelected.forEach((fn, idx) => {
            const key = crypto.randomUUID();
            formData.append(`files[${key}]`, fileAttachmentsSelected[idx])
            saveFilenameAttachments.push({
                key: key,
                judul: filenameAttachmentsSelected[idx]
            })
        })
        formData.append("nama_berkas", JSON.stringify(saveFilenameAttachments))
        if (!isHistoryCommentDisabled) {
            const historyCommentValue = historyComment.value.trim();
            formData.append("komentar_perubahan", historyCommentValue)
        }
        // TODO Kirim data ke back-end setelah divalidasi disisi client
    })
})