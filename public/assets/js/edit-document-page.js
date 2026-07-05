import { setValue, FormTab, Form } from "./Form.js";
import { classManipulation } from "./class-manipulation.js";
import { $, $id, $$ } from "./dom.js";
const form = new Form();
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
    const abstractSelected = $id('fileAbstractSelected');
    const btnDeleteSelectedAbstractFile = $id('deleteSelectedAbstractFile');
    let fileAbstract = null;
    inputSelectFileAbstract.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        // __COMMENT__ Tambahkan validasi untuk file disisi client
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
        return `<div class="w-full flex items-center gap-3"><label class="shrink-0"><span class="text-sm text-gray-500">Nama Berkas:</span></label><input type="text" value="${filename}" class="new-attachment w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" /><button type="button" title="Hapus" data-filename="${filename}" class="delete-file p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><use href="/assets/icons.svg#icon-trash-strip" /></svg></button></div>`;
    }
    const btnAddAttachments = $id('addAttachments');
    const attachmentsSelected = $id('attachmentsSelected');
    const attachmentInputFile = $id('attachment');
    let fileAttachmentsSelected = [];
    let filenameAttachmentsSelected = Array.from(attachmentsSelected.querySelectorAll('input[type=text]')).map(input => input.value);
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
        if (filenameAttachmentsSelected.length > 0) {
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
        if (filenameAttachmentsSelected.length === 1) {
            classManipulation(attachmentInputFile.parentElement).remove('hidden')
            classManipulation(btnAddAttachments.parentElement).remove('flex')
            classManipulation(btnAddAttachments.parentElement).add('hidden')
            classManipulation(attachmentsSelected).add('hidden')
        }
        fileAttachmentsSelected.splice(getIndexFilenameOnArraySelected, 1)
        filenameAttachmentsSelected.splice(getIndexFilenameOnArraySelected, 1)
    })
    btnAddAttachments.addEventListener('click', () => attachmentInputFile.click())

    const withoutHistory = $id('withoutHistory');
    const historyComment = $id('historyComment');
    const changeType = $id('changeType');
    withoutHistory.addEventListener('change', function () {
        const isChecked = this.checked;
        if (isChecked) {
            historyComment.disabled = true;
            changeType.disabled = true;
        } else {
            historyComment.disabled = false;
            changeType.disabled = false;
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
    currentDynamicValues["abstrak_pdf"] = $$(inputFilenameAbstract).getInputValue();
    currentDynamicValues["lampiran"] = [...filenameAttachmentsSelected];
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

    const btnSaveChanges = $id("saveChanges");
    btnSaveChanges.addEventListener("click", () => {
        console.log(fileAttachmentsSelected)
        console.log(filenameAttachmentsSelected)
        return;

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

        // const isHasChanges = Object.keys(changesValue).length > 0;
        // if (!isHasChanges) return alert("Tidak ada perubahan yang terjadi!");

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
         * Jika ada yang berubah, masukkan ke var dokumenTerkaitChanges diproperty changed
         * Jika ada yang dihapus, masukkan ke var dokumenTerkaitChanges diproperty deleted
        */
        const dokumenTerkaitChanges = {
            add: {},
            changed: {},
            deleted: []
        };
        Object.entries(currentDynamicValues["dokumen_terkait"]).forEach(([idx, obj]) => {
            const id = obj.id;
            const relatedDocument = document.querySelector(`[data-related-id='${id}']`);
            if (relatedDocument === null) {
                dokumenTerkaitChanges.deleted.push(id)
            } else {
                let isChanged = false;
                const inputs = relatedDocument.querySelectorAll("input[type='text']");
                const selects = relatedDocument.querySelectorAll("select");
                const values = {
                    judul_dokumen_terkait: $$(inputs[0]).getInputValue(),
                    nomor_tahun_dokumen_terkait: $$(inputs[1]).getInputValue(),
                    jenis_dokumen_terkait: $$(selects[0]).getInputValue(),
                    aksi_dokumen_terkait: $$(selects[1]).getInputValue()
                };
                for (const [key, value] of Object.entries(values)) {
                    const isValueChanges = value !== currentDynamicValues["dokumen_terkait"][idx][key];
                    if (!isValueChanges) {
                        delete values[key];
                        continue;
                    };
                    values[key] = value;
                    isChanged = true;
                }
                if (isChanged) {
                    dokumenTerkaitChanges.changed[id] = values;
                }
            }
        })
        /**
         * Simpan dokumen terkait yang baru (jika ditambahkan)
        */
        const getNewRelatedDocument = relatedDocumentWrapper.querySelectorAll('.related-document-inputs.new');
        getNewRelatedDocument.forEach((el, idx) => {
            const getInputs = el.querySelectorAll("input");
            const getTitleInput = getInputs[0];
            const getNoTahunInput = getInputs[1];
            if (getTitleInput.value.trim() === "" || getNoTahunInput.value.trim() === "") return;
            const getSelects = el.querySelectorAll("select");
            const getTypeSelect = getSelects[0];
            const getActionSelect = getSelects[1];
            dokumenTerkaitChanges.add[idx] = {
                judul_dokumen_terkait: $$(getTitleInput).getInputValue(),
                nomor_tahun_dokumen_terkait: $$(getNoTahunInput).getInputValue(),
                jenis_dokumen_terkait: $$(getTypeSelect).getInputValue(),
                aksi_dokumen_terkait: $$(getActionSelect).getInputValue()
            };
        })

        /**
         * Lacak perubahan yang terjadi diberkas/lampiran yang sudah tersimpan di Database.
        */
        const attachmentChanges = {
            add: {},
            changed: {},
            deleted: []
        };
        getInputsTitleAttachment.forEach((input, idx) => {
            const getAttachmentId = input.dataset.attachmentId;
            // Block if ini mengecek apakah input masih tersedia di-DOM, jika tidak tersedia berarti lampiran harus dihapus.
            if (!input.isConnected) return attachmentChanges.deleted.push(getAttachmentId);
            const value = $$(input).getInputValue();
            const isTitleAttachmentChange = value !== filenameAttachmentsSelected[idx];
            if (!isTitleAttachmentChange) return;
            attachmentChanges.changed[getAttachmentId] = { nama_berkas: value };
        })

        if (fileAttachmentsSelected.length > 0) {
            console.log("Ada lampiran baru.")
        }

        console.info("Lampiran baru:")
        console.log(fileAttachmentsSelected)
    })
})