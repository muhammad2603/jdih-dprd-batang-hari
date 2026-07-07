import { setValue, FormTab, Form } from "./Form.js";
import { classManipulation } from "./class-manipulation.js";
import { $, $id, $$ } from "./dom.js";
import { validate, validations } from "./validations.js";
const form = new Form();
/**
 * Filter pengambilan hanya pada perubahan
 * @param object object yang akan digunakan untuk melakukan filterisasi
 * @return {[string, string[]][]} mengembalikan array tuple yang berisi array[key object: string, operation: array]
*/
const changesFilterFromObjectEntries = object => {
    return Object.entries(object).filter(([_, operation]) => operation.length !== 0);
}
document.addEventListener("DOMContentLoaded", () => {
    const judulDokumenInput = $id("titleDocument");
    const noTahunInput = $id("nomorTahun");
    const jenisDokumenSelect = $id("typeDocument");
    const statusDokumenSelect = $id("statusDocument");
    const teuDokumenSelect = $id("teuDocument");
    const tanggalPenetapanDate = $id("tanggalPenetapan");
    const pembuatPeraturanSelect = $id("pembuatPeraturan");
    const penandatangananSelect = $id("penandatanganan");
    const pejabatPenetapSelect = $id("pejabatPenetap");
    const tempatPenetapanSelect = $id("tempatPenetapan");
    const sumberSelect = $id("sumber");
    const noTahunTldInput = $id("noTahunTld");
    const noteInput = $id("note");

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
    if (salinTanggalPengundangan.checked) {
        isCheckedSalinTanggalPengundangan = true;
        form.copyValueFromOtherInput(inputTanggalBerlaku, inputTanggalPengundangan)
        form.disableInputEvent(inputTanggalBerlaku)
    }
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
        const getIndexClassifyOnListArray = listClassifiesSelected.indexOf(category.dataset.categoryId);
        $$(category).removeEl()
        listClassifiesSelected.splice(getIndexClassifyOnListArray, 1)
    }
    const insertSelected = (categoryId, category) => {
        return `<span data-category-id="${categoryId}" data-category="${category}" class="selected h-fit inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full"><span>${category}</span><button type="button" title="Hapus" class="delete-selected cursor-pointer hover:text-red-600"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3"><use href="/assets/icons.svg#icon-trash-strip"></svg></button></span>`;
    };
    const btnAddBidangHukum = $id('tambahBidangHukum');
    const bidangHukumSelect = $id('bidangHukumSelect');
    const parentSelectedBidangHukum = $id('selectedBidangHukum');
    const getInitSelectedBidangHukum = parentSelectedBidangHukum.querySelectorAll('span.selected');
    let bidangHukumSelectedList = Array.from(getInitSelectedBidangHukum).map(element => element.dataset.categoryId);
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
    const getInitSelectedSubject = parentSelectedSubject.querySelectorAll('span.selected');
    let subjectSelectedList = Array.from(getInitSelectedSubject).map(element => element.dataset.categoryId);
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
    const getCurrentFilenameAbstract = $$(inputFilenameAbstract).getInputValue();
    const abstractSelected = $id('fileAbstractSelected');
    const btnDeleteSelectedAbstractFile = $id('deleteSelectedAbstractFile');
    let fileAbstract = null;
    const allowedExtensions = ['pdf'];
    const maximum_mb = 5;
    const allowedMimes = ['application/pdf'];
    inputSelectFileAbstract.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (!validations(file.name).isAllowedFileExtension(allowedExtensions)) {
            return alert("Ekstensi file abstrak tidak diizinkan. Silahkan pilih file kembali dengan ekstensi pdf.")
        }
        if (!validations(file.type).isAllowedMimesType(allowedMimes)) {
            return alert(`File abstrak bukan tipe PDF. Ganti file atau pastikan formatnya PDF.`);
        }
        const isFileSizeLarge = validations(file.size).isFileSizeTooLarge(maximum_mb);
        if (isFileSizeLarge) {
            return alert(`Ukuran file abstrak terlalu besar (maks. ${maximum_mb} MB). Silahkan pilih file kembali!`);
        }
        fileAbstract = file;
        classManipulation(abstractSelected).remove('hidden')
        classManipulation(inputFileAbstractWrapper).add('hidden')
        setValue(inputFilenameAbstract, file.name)
    })
    // __COMMENT__ Disaat ingin refactoring, perhatikan kode event-nya, logika tidak mirip dengan script add-document-page.js
    btnDeleteSelectedAbstractFile.addEventListener('click', () => {
        const isFileExist = inputFilenameAbstract.dataset.fileExist;
        if (!fileAbstract && isFileExist != 1) return;
        fileAbstract = null;
        setValue(inputFilenameAbstract, "")
        classManipulation(abstractSelected).add('hidden')
        classManipulation(inputFileAbstractWrapper).remove('hidden')
        $$(inputFilenameAbstract).removeAttr('data-file-exist', '0')
    })

    // __COMMENT__ Interaksi dokumen terkait tidak lagi menggunakan counter, karena perilakunya berbeda dengan script add-document-page.js
    const relatedDocumentWrapper = $id('relatedDocumentWrapper');
    const btnAddRelatedDoc = $id('addRelated');
    const newRelatedDocumentInputs = $('.related-document-inputs.new').cloneNode(true);
    const selectFirstBtnDeleteRelated = () => $('.related-document-inputs.new > .btn-delete-related');
    const selectAllBtnDeleteRelated = () => document.querySelectorAll('.related-document-inputs.new > .btn-delete-related');
    classManipulation(selectFirstBtnDeleteRelated()).add('opacity-0', 'pointer-events-none')
    btnAddRelatedDoc.addEventListener('click', () => {
        $$(relatedDocumentWrapper).insertHTML(newRelatedDocumentInputs.outerHTML, 'beforeend')
        classManipulation(selectFirstBtnDeleteRelated()).remove('opacity-0', 'pointer-events-none')
    })
    relatedDocumentWrapper.addEventListener('click', e => {
        const targetBtnDeleteRelatedDocument = e.target.closest('.btn-delete-related');
        if (!targetBtnDeleteRelatedDocument) return;
        $$(targetBtnDeleteRelatedDocument.parentElement).removeEl()
        // __COMMENT__ Block if ini pengganti counter, karena tombol dihilangkan events-nya melalui tracking jumlah tombol delete
        if (Array.from(selectAllBtnDeleteRelated()).length === 1) {
            classManipulation(selectFirstBtnDeleteRelated()).add('opacity-0', 'pointer-events-none')
        }
    })

    const createInputFileNameAttachment = filename => {
        return `<div class="w-full flex items-center gap-3"><label class="shrink-0"><span class="text-sm text-gray-500">Nama Berkas:</span></label><input type="text" placeholder="Masukkan nama berkas..." value="${filename}" class="new-attachment w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" /><button type="button" title="Hapus" data-filename="${filename}" class="delete-file p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><use href="/assets/icons.svg#icon-trash-strip" /></svg></button></div>`;
    }
    const btnAddAttachments = $id('addAttachments');
    const attachmentsSelected = $id('attachmentsSelected');
    const attachmentInputFile = $id('attachment');
    const getCurrentAttachments = attachmentsSelected.querySelectorAll('input[data-attachment-id]');
    const isAttachmentExist = getCurrentAttachments.length > 0;
    let fileAttachmentsSelected = [];
    let filenameAttachmentsSelected = [];
    const maximumSizeMB = 30;
    attachmentInputFile.addEventListener('change', function () {
        const files = Array.from(this.files);
        if (!files[0]) return;
        // note: value input file dikosongkan karena semua file yang dipilih disimpan ke-array fileAttachmentsSelected dan filenameAttachmentsSelecteds
        setValue(this, '')
        for (const file of files) {
            const filename = file.name;
            const isExtensionFileAllowed = !validations(filename).isAllowedFileExtension(allowedExtensions);
            if (isExtensionFileAllowed) {
                alert(`Ekstensi file ${filename} tidak diizinkan. Silahkan pilih file kembali dengan ekstensi pdf.`)
                continue;
            }
            if (!validations(file.type).isAllowedMimesType(allowedMimes)) {
                alert(`File ${filename} bukan tipe PDF. Ganti file atau pastikan formatnya PDF.`)
                continue;
            }
            const isSizeTooLarge = validations(file.size).isFileSizeTooLarge(maximumSizeMB);
            if (isSizeTooLarge) {
                alert(`Ukuran file ${filename} terlalu besar (maks. ${maximumSizeMB} MB). Silahkan perkecil/kompres file terlebih dahulu.`)
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
        if (getIndexFilenameOnArraySelected !== -1) {
            fileAttachmentsSelected.splice(getIndexFilenameOnArraySelected, 1)
            filenameAttachmentsSelected.splice(getIndexFilenameOnArraySelected, 1)
        };
        if (
            (isAttachmentExist && (attachmentsSelected.querySelectorAll('input[data-attachment-id]').length === 0 && filenameAttachmentsSelected.length === 0))
        ) {
            classManipulation(attachmentInputFile.parentElement).remove('hidden')
            classManipulation(btnAddAttachments.parentElement).remove('flex')
            classManipulation(btnAddAttachments.parentElement).add('hidden')
            classManipulation(attachmentsSelected).add('hidden')
        }
    })
    btnAddAttachments.addEventListener('click', () => attachmentInputFile.click())

    const withoutHistory = $id('withoutHistory');
    const historyComment = $id('historyComment');
    const changeType = $id('changeType');
    const historyCommentError = $id('historyCommentError');
    withoutHistory.addEventListener('change', function () {
        const isChecked = this.checked;
        if (isChecked) {
            historyComment.disabled = true;
            changeType.disabled = true;
            classManipulation(historyCommentError).add("hidden")
        } else {
            historyComment.disabled = false;
            changeType.disabled = false;
            if ($$(historyComment).getInputValue() === "") {
                $$(historyCommentError).text('Harap isi bidang ini atau berikan tanda centang pada Tanpa Riwayat.')
                classManipulation(historyCommentError).remove("hidden")
            }
        }
    })

    const currentValues = {};
    currentValues["judul_dokumen"] = $$(judulDokumenInput).getInputValue();
    currentValues["nomor_tahun_dokumen"] = $$(noTahunInput).getInputValue();
    currentValues["jenis_dokumen"] = $$(jenisDokumenSelect).getInputValue();
    currentValues["status_dokumen"] = $$(statusDokumenSelect).getInputValue();
    currentValues["teu_dokumen"] = $$(teuDokumenSelect).getInputValue();
    currentValues["tanggal_penetapan"] = $$(tanggalPenetapanDate).getInputValue();
    currentValues["tanggal_pengundangan"] = $$(inputTanggalPengundangan).getInputValue();
    currentValues["tanggal_berlaku"] = $$(inputTanggalBerlaku).getInputValue();
    currentValues["pembuat_peraturan"] = $$(pembuatPeraturanSelect).getInputValue();
    currentValues["penandatanganan"] = $$(penandatangananSelect).getInputValue();
    currentValues["pejabat_penetap"] = $$(pejabatPenetapSelect).getInputValue();
    currentValues["tempat_penetapan"] = $$(tempatPenetapanSelect).getInputValue();
    currentValues["sumber"] = $$(sumberSelect).getInputValue();
    currentValues["nomor_tahun_tld"] = $$(noTahunTldInput).getInputValue();
    currentValues["catatan"] = $$(noteInput).getInputValue();

    const currentDynamicValues = {};
    currentDynamicValues["bidang_hukum"] = [...bidangHukumSelectedList];
    currentDynamicValues["subjek"] = [...subjectSelectedList];
    currentDynamicValues["abstrak_pdf"] = getCurrentFilenameAbstract !== "" ? getCurrentFilenameAbstract : null;
    currentDynamicValues["lampiran"] = Array.from(getCurrentAttachments).map(input => input.value);
    currentDynamicValues["dokumen_terkait"] = {};
    const getCurrentRelatedDocuments = relatedDocumentWrapper.querySelectorAll(".related-document-inputs[data-related-id]");
    getCurrentRelatedDocuments.forEach((wrapper, idx) => {
        const inputs = wrapper.querySelectorAll("input[type='text']");
        const selects = wrapper.querySelectorAll("select");
        const judulInput = inputs[0];
        const noTahunInput = inputs[1];
        const jenisSelect = selects[0];
        const aksiSelect = selects[1];
        currentDynamicValues["dokumen_terkait"][idx] = {
            id: wrapper.dataset.relatedId,
            judul_dokumen_terkait: $$(judulInput).getInputValue(),
            nomor_tahun_dokumen_terkait: $$(noTahunInput).getInputValue(),
            jenis_dokumen_terkait: $$(jenisSelect).getInputValue(),
            aksi_dokumen_terkait: $$(aksiSelect).getInputValue()
        }
    })

    const getInputsTitleAttachment = Array.from(document.querySelectorAll('[data-attachment-id]'));
    const noTahunError = $$(noTahunInput).nextEl();
    const noTahunTldError = $$(noTahunTldInput).nextEl();

    const validationConfig = [
        {
            identityField: "judul_dokumen",
            messageElement: $$(judulDokumenInput).nextEl(),
            validators: [
                {
                    method: "isEmptyValue",
                    parameters: [],
                    messageError: "Harap isi bidang ini.",
                },
                {
                    method: "isValidValueLength",
                    parameters: [5, 255],
                    messageError: "Judul dokumen tidak valid (min. 5 karakter dan maks. 255 karakter)."
                }
            ]
        },
        {
            identityField: "tanggal_penetapan",
            messageElement: $$(tanggalPenetapanDate).nextEl(),
            validators: [
                {
                    method: "isInvalidDate",
                    parameters: [],
                    messageError: "Tanggal penetapan tidak dapat diatur lebih dari tanggal saat ini"
                },
            ]
        },
        {
            identityField: "tanggal_pengundangan",
            messageElement: $$(inputTanggalPengundangan).nextEl(),
            validators: [
                {
                    method: "isInvalidDate",
                    parameters: [],
                    messageError: "Tanggal pengundangan tidak dapat diatur lebih dari tanggal saat ini"
                },
            ]
        },
        {
            identityField: "tanggal_berlaku",
            messageElement: $$(inputTanggalBerlaku).nextEl(),
            validators: [
                {
                    method: "isInvalidDate",
                    parameters: [],
                    messageError: "Tanggal berlaku tidak dapat diatur lebih dari tanggal saat ini"
                },
            ]
        },
        {
            identityField: "catatan",
            messageElement: $$(noteInput).nextEl(),
            validators: [
                {
                    method: "isValidOptionalValueLength",
                    parameters: [8, 255],
                    messageError: "Catatan tidak valid (min. 8 karakter dan maks. 255 karakter) atau kosongkan jika tanpa catatan."
                }
            ]
        }
    ];

    const btnSaveChanges = $id("saveChanges");
    btnSaveChanges.addEventListener("click", () => {
        [noTahunError, noTahunTldError, historyCommentError].forEach(el => $$(el).text(''));

        let isValid = true;
        const changesValue = {};

        /**
         * Set perubahan value pada input, dan jangan sertakan value yang tidak ada perubahan
         */
        Object.entries(currentValues).forEach(([attrName, currValue]) => {
            const getElement = $$(document.querySelector(`[name=${attrName}]`));
            const newValue = getElement.getInputValue();
            const isValueChanged = newValue !== currValue;
            if (!isValueChanged) return;
            changesValue[attrName] = newValue;
        })

        /**
         * Perubahan bidang hukum
         */
        const currBidangHukumSet = new Set(currentDynamicValues["bidang_hukum"]);
        const newBidangHukumSet = new Set(bidangHukumSelectedList);
        const bidangHukumChanges = {
            add: bidangHukumSelectedList.filter(id => !currBidangHukumSet.has(id)),
            delete: currentDynamicValues["bidang_hukum"].filter(id => !newBidangHukumSet.has(id))
        };

        /**
         * Perubahan subjek
         */
        const currSubjekSet = new Set(currentDynamicValues["subjek"]);
        const newSubjekSet = new Set(subjectSelectedList);
        const subjekChanges = {
            add: subjectSelectedList.filter(id => !currSubjekSet.has(id)),
            delete: currentDynamicValues["subjek"].filter(id => !newSubjekSet.has(id))
        };

        /**
         * Lacak perubahan yang terjadi didokumen terkait yang sudah tersimpan di Database.
        */
        const dokumenTerkaitChanges = {
            add: [],
            changed: [],
            deleted: []
        };
        Object.entries(currentDynamicValues["dokumen_terkait"]).forEach(([idx, obj]) => {
            const id = obj.id;
            const relatedDocument = document.querySelector(`[data-related-id='${id}']`);
            if (relatedDocument === null) {
                dokumenTerkaitChanges.deleted.push(id)
            } else {
                let isRelatedDocumentChanged = false;
                const inputs = relatedDocument.querySelectorAll("input[type='text']");
                const titleValue = $$(inputs[0]).getInputValue();
                const isTitleEmpty = validations(titleValue).isEmptyValue();
                const noTahunValue = $$(inputs[1]).getInputValue();
                const isNomorTahunEmpty = validations(noTahunValue).isEmptyValue();
                if (isTitleEmpty) return;
                if (!isTitleEmpty && isNomorTahunEmpty) {
                    isValid = false;
                    alert(`Format nomor dan tahun pada "${titleValue}" didokumen terkait tidak benar. Contoh: 15/2021`);
                    return;
                }
                if (!isTitleEmpty && validations(titleValue).isValidValueLength(8, 255)) {
                    isValid = false;
                    alert(`Judul dokumen terkait pada "${titleValue}" tidak valid (min. 8 karakter dan maks. 255 karakter)`);
                    return;
                }
                const [number, year] = noTahunValue.split("/");
                const isInvalidNumber = validations(number).isInvalidValue(/\D/);
                const isInvalidYear = validations(year).isInvalidValue(/\D/);
                // Jika judul dokumen terkait tidak kosong, cek apakah nomor/tahunnya valid? (harus mengandung digit/angka)
                if (!isTitleEmpty && (isInvalidNumber || isInvalidYear)) {
                    isValid = false;
                    alert(`Format nomor dan tahun pada "${titleValue}" didokumen terkait harus mengandung angka. Contoh: 15/2021`);
                    return;
                }
                const isInvalidYearLength = validations(year).isValidValueLength(4, 4);
                // Jika judul dokumen terkait tidak kosong, dan nomor/tahun valid semua, cek apakah format tahun benar? (harus 4 digit/angka)
                if (!isTitleEmpty && (!isInvalidNumber && !isInvalidYear) && isInvalidYearLength) {
                    isValid = false;
                    alert(`Format tahun pada "${titleValue}" didokumen terkait adalah 4 digit. Contoh: 2020, 2021, dst.`);
                    return;
                }
                const selects = relatedDocument.querySelectorAll("select");
                const typeValue = $$(selects[0]).getInputValue();
                const actionValue = $$(selects[1]).getInputValue();
                const values = {
                    judul_dokumen_terkait: titleValue,
                    nomor_tahun_dokumen_terkait: noTahunValue,
                    jenis_dokumen_terkait: typeValue,
                    aksi_dokumen_terkait: actionValue
                };
                for (const [key, value] of Object.entries(values)) {
                    const isValueChanges = value !== currentDynamicValues["dokumen_terkait"][idx][key];
                    if (!isValueChanges) {
                        delete values[key];
                        continue;
                    };
                    values[key] = value;
                    isRelatedDocumentChanged = true;
                }
                if (isRelatedDocumentChanged) {
                    values["id"] = id;
                    dokumenTerkaitChanges.changed.push(values);
                }
            }
        })

        /**
         * Simpan dokumen terkait yang baru (jika ditambahkan)
        */
        const getNewRelatedDocument = relatedDocumentWrapper.querySelectorAll('.related-document-inputs.new');
        getNewRelatedDocument.forEach((el, idx) => {
            const getInputs = el.querySelectorAll("input");
            const titleValue = $$(getInputs[0]).getInputValue();
            const isTitleEmpty = validations(titleValue).isEmptyValue();
            const noTahunValue = $$(getInputs[1]).getInputValue();
            const isNomorTahunEmpty = validations(noTahunValue).isEmptyValue();
            if (isTitleEmpty) return;
            if (!isTitleEmpty && isNomorTahunEmpty) {
                isValid = false;
                alert(`Format nomor dan tahun pada "${titleValue}" didokumen terkait tidak benar. Contoh: 15/2021`);
            }
            if (!isTitleEmpty && validations(titleValue).isValidValueLength(8, 255)) {
                isValid = false;
                alert(`Judul dokumen terkait pada "${titleValue}" tidak valid (min. 8 karakter dan maks. 255 karakter)`);
            }
            const [number, year] = noTahunValue.split("/");
            const isInvalidNumber = validations(number).isInvalidValue(/\D/);
            const isInvalidYear = validations(year).isInvalidValue(/\D/);
            // Jika judul dokumen terkait tidak kosong, cek apakah nomor/tahunnya valid? (harus mengandung digit/angka)
            if (!isTitleEmpty && (isInvalidNumber || isInvalidYear)) {
                isValid = false;
                alert(`Format nomor dan tahun pada "${titleValue}" didokumen terkait harus mengandung angka. Contoh: 15/2021`);
            }
            const isInvalidYearLength = validations(year).isValidValueLength(4, 4);
            // Jika judul dokumen terkait tidak kosong, dan nomor/tahun valid semua, cek apakah format tahun benar? (harus 4 digit/angka)
            if (!isTitleEmpty && (!isInvalidNumber && !isInvalidYear) && isInvalidYearLength) {
                isValid = false;
                alert(`Format tahun pada "${titleValue}" didokumen terkait adalah 4 digit. Contoh: 2020, 2021, dst.`);
            }
            const getSelects = el.querySelectorAll("select");
            const typeValue = $$(getSelects[0]).getInputValue();
            const actionValue = $$(getSelects[1]).getInputValue();
            dokumenTerkaitChanges.add.push({
                judul_dokumen_terkait: titleValue,
                nomor_tahun_dokumen_terkait: noTahunValue,
                jenis_dokumen_terkait: typeValue,
                aksi_dokumen_terkait: actionValue
            });
        })

        /**
         * Lacak perubahan yang terjadi diberkas/lampiran yang sudah tersimpan di Database.
        */
        const attachmentChanges = {
            add: [],
            changed: [],
            deleted: []
        };

        for (let idx = 0; idx < getInputsTitleAttachment.length; idx++) {
            const input = getInputsTitleAttachment[idx];
            const getAttachmentId = input.dataset.attachmentId;
            // Block if ini mengecek apakah input masih tersedia di-DOM, jika tidak tersedia berarti lampiran harus dihapus.
            if (!input.isConnected) {
                attachmentChanges.deleted.push(getAttachmentId)
                continue;
            };
            const value = $$(input).getInputValue();
            classManipulation(input).remove("border-input-error")
            const isTitleAttachmentChange = value !== currentDynamicValues["lampiran"][idx];
            if (!isTitleAttachmentChange) break;
            const isFileTitleEmpty = validations(value).isEmptyValue();
            if (isFileTitleEmpty) {
                isValid = false;
                classManipulation(input).add("border-input-error")
                alert("Nama berkas tidak ada yang boleh kosong.");
                break;
            }
            const isFileTitleValidLength = validations(value).isValidValueLength(8, 255);
            if (isFileTitleValidLength) {
                isValid = false;
                classManipulation(input).add("border-input-error")
                alert("Nama berkas tidak valid (min. 8 karakter dan maks. 255 karakter)");
                break;
            }
            attachmentChanges.changed.push({ id: getAttachmentId, nama_berkas: value });
        }

        const getTitleNewAttachments = document.querySelectorAll('input.new-attachment');
        if (fileAttachmentsSelected.length > 0) {
            fileAttachmentsSelected.forEach((file, idx) => {
                const input = getTitleNewAttachments[idx];
                classManipulation(input).remove("border-input-error")
                const value = $$(input).getInputValue();
                const isFileTitleEmpty = validations(value).isEmptyValue();
                if (isFileTitleEmpty) {
                    isValid = false;
                    classManipulation(input).add("border-input-error")
                    return alert("Nama berkas tidak ada yang boleh kosong.");
                }
                if (validations(value).isValidValueLength(8, 255)) {
                    isValid = false;
                    classManipulation(input).add("border-input-error")
                    return alert("Nama berkas tidak valid (min. 8 karakter dan maks. 255 karakter)");
                }
                attachmentChanges.add.push({
                    nama_berkas: value,
                    file: file
                });
            })
        }

        let fileAbstractModify = {};
        if (validations($$(inputFilenameAbstract).getInputValue()).isEmptyValue() && currentDynamicValues["abstrak_pdf"] !== null) {
            const isDeleteFileAbstractConfirmed = confirm("Apakah anda yakin ingin menghapus File Abstrak dokumen ini?");
            if (!isDeleteFileAbstractConfirmed) return;
            fileAbstractModify.delete = true;
        }
        if (fileAbstract !== null && currentDynamicValues["abstrak_pdf"] !== null) {
            fileAbstractModify.changed = fileAbstract;
        }

        const historyCommentValue = $$(historyComment).getInputValue();
        const isHistoryCommentDisabled = historyComment.disabled;
        if (!isHistoryCommentDisabled && validations(historyCommentValue).isValidOptionalValueLength(8, 255)) {
            isValid = false;
            $$(historyCommentError).text('Komentar perubahan tidak valid (min. 8 karakter dan maks. 255 karakter).')
        }

        const changesValueEntries = Object.entries(changesValue);
        const bidangHukumChangesEntries = changesFilterFromObjectEntries(bidangHukumChanges);
        const subjekChangesEntries = changesFilterFromObjectEntries(subjekChanges);
        const isFileAbstractModified = changesFilterFromObjectEntries(fileAbstractModify);
        const relatedDocumentChangesEntries = changesFilterFromObjectEntries(dokumenTerkaitChanges);
        const attachmentChangesEntries = changesFilterFromObjectEntries(attachmentChanges);

        // __COMMENT__ Block if ini mencegah saat tidak ada perubahan sama sekali.
        if (
            changesValueEntries.length === 0 &&
            isFileAbstractModified.length === 0 &&
            bidangHukumChangesEntries.length === 0 &&
            subjekChangesEntries.length === 0 &&
            relatedDocumentChangesEntries.length === 0 &&
            attachmentChangesEntries.length === 0 &&
            isValid === true
        ) return alert("Tidak ada perubahan yang dilakukan.");

        for (const [key, value] of changesValueEntries) {
            const getValidationConfig = validationConfig.find(config => config.identityField === key);
            if (!getValidationConfig) continue;
            getValidationConfig.value = value;
            const result = validate(getValidationConfig);
            isValid = result;
        }

        if (changesValue["nomor_tahun_dokumen"] !== undefined) {
            $$(noTahunError).text('')
            const noTahunValue = $$(noTahunInput).getInputValue();
            const numberAndYearSplit = noTahunValue.split("/");
            const [number, year] = numberAndYearSplit;
            if (validations(noTahunValue).isEmptyValue()) {
                isValid = false;
                $$(noTahunError).text("Harap isi bidang ini.")
            } else if (!validations(noTahunValue).isValueIncludedChar("/") || (validations(number).isEmptyValue() || validations(year).isEmptyValue())) {
                isValid = false;
                $$(noTahunError).text("Format nomor dan tahun dokumen tidak valid. Contoh: 15/2021")
            } else if (validations(number).isInvalidValue(/\D/) || validations(year).isInvalidValue(/\D/)) {
                isValid = false;
                $$(noTahunError).text("Format nomor dan tahun dokumen harus mengandung angka. Contoh: 15/2021.")
            } else if (!validations(year).isInvalidValue(undefined) && validations(year).isValidValueLength(4, 4)) { // __COMMENT__ menggunakan isInvalid diperlukan, karena, jika year memiliki nilai undefined, tidak akan bisa diambil lengthnya.
                isValid = false;
                $$(noTahunError).text("Format tahun dokumen adalah 4 digit. Contoh: 2020, 2021, dst.")
            }
        }

        if (changesValue["nomor_tahun_tld"] !== undefined) {
            $$(noTahunTldError).text('')
            const noTahunTldValue = $$(noTahunTldInput).getInputValue();
            const numberAndYearTldSplit = noTahunTldValue.split("/");
            const [numberTld, yearTld] = numberAndYearTldSplit;
            if (validations(noTahunTldValue).isEmptyValue()) {
                isValid = false;
                $$(noTahunTldError).text("Harap isi bidang ini.")
            } else if (!validations(noTahunTldValue).isValueIncludedChar("/") || (validations(numberTld).isEmptyValue() || validations(yearTld).isEmptyValue())) {
                isValid = false;
                $$(noTahunTldError).text("Format nomor dan tahun TLD dokumen tidak valid. Contoh: 15/2021")
            } else if (validations(numberTld).isInvalidValue(/\D/) || validations(yearTld).isInvalidValue(/\D/)) {
                isValid = false;
                $$(noTahunTldError).text("Format nomor dan tahun TLD dokumen harus mengandung angka. Contoh: 15/2021.")
            } else if (!validations(yearTld).isInvalidValue(undefined) && validations(yearTld).isValidValueLength(4, 4)) { // __COMMENT__ menggunakan isInvalid diperlukan, karena, jika yearTld memiliki nilai undefined, tidak akan bisa diambil lengthnya.
                isValid = false;
                $$(noTahunTldError).text("Format tahun TLD dokumen adalah 4 digit. Contoh: 2020, 2021, dst.")
            }
        }

        if (!isValid) return alert("Ada input yang tidak valid mohon cek kembali!");

        const formData = new FormData();
    })
})