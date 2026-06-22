import { setValue, FormTab, Form } from "./Form.js";
import { classManipulation } from "./class-manipulation.js";
import { $id, $$ } from "./dom.js";
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
})