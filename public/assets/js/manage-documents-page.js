class PopUp {
    constructor() {
        this.wrapper = document.getElementById("popUpWrapper");
        this.titlePopUp = document.getElementById("titlePopUp");
        this.warningTextPopUp = document.getElementById("warningTextPopUp");
        this.messagePopUp = document.getElementById("messagePopUp");
        this.btnClosePopUp = document.getElementById("closePopUp");
        this.btnConfirmationPopUp = document.getElementById("confirmationPopUp");
    }
    close() {
        this.wrapper.classList.remove('flex');
        this.wrapper.classList.add('hidden');
    }
    show(config) {
        this.wrapper.classList.remove('hidden');
        this.wrapper.classList.add('flex');
        this.titlePopUp.innerText = config.title ?? "";
        this.warningTextPopUp.innerText = config.warning ?? "";
        this.messagePopUp.innerText = config.message ?? "";
        this.btnClosePopUp.innerText = config.btnCloseText ?? "Batal";
        this.btnConfirmationPopUp.innerText = config.btnConfirmationText ?? "Konfirmasi";
    }
    confirm(config) {
        this.show(config)
        return new Promise((resolve, reject) => {
            this.btnConfirmationPopUp.onclick = () => {
                resolve(true)
            }
            this.btnClosePopUp.onclick = () => {
                this.close()
                reject({ closed: true })
            }
        })
    }
}
const useFetch = async (fetchConfig) => {
    const { url, action, headers, success, errors } = fetchConfig;
    try {
        const response = await fetch(url, { method: action, headers: headers });
        if (!response.ok) throw new Error(`${response.status} (${response.statusText}).`);
        const result = await response.json();
        success(result)
    } catch (error) {
        errors(error)
    }
}
const popUp = new PopUp();
const deleteDocument = (btnIdx, docId, titleDocument) => {
    const popUpConfig = {
        "title": 'Hapus Dokumen',
        "warning": 'Dokumen akan dihapus secara permanen dan tidak dapat dipulihkan. Apakah anda yakin?',
        "message": titleDocument,
    };
    popUp.confirm(popUpConfig)
        .then(() => {
            console.log("ID Dokumen:", docId)
            popUp.close()
        })
        .catch(err => false)
}
const url = '/api/cari-dokumen?';
let querySaved = {};
document.addEventListener('DOMContentLoaded', () => {
    const deleteDocumentBtn = document.querySelectorAll('.delete-document');
    const documentsList = document.querySelectorAll('.judul-dokumen');
    const searchInput = document.getElementById("search");
    const documentTypeSelect = document.getElementById("documentType");
    const documentStatusSelect = document.getElementById("documentStatus");
    const documentYearSelect = document.getElementById("documentYear");
    const btnSubmitSearch = document.getElementById("submitSearch");
    const tableProdukHukum = document.getElementById("tableProdukHukum");
    const dataIndex = document.getElementById("dataIndex");
    const paginationWrapper = document.getElementById("paginationWrapper");
    useFetch({
        url: url,
        action: 'GET',
        headers: {
            "X-Requested-With": 'XMLHttpRequest'
        },
        success: data => {
            const { data_index, total, view } = data;
            dataIndex.innerHTML = data_index;
            tableProdukHukum.innerHTML = view.produk_hukum;
            paginationWrapper.innerHTML = view.pager;
        },
        errors: err => {
            console.error(err)
        }
    })
    paginationWrapper.addEventListener("click", e => {
        const target = e.target;
        const isPaginationClicked = target.closest("li[data-page]");
        if (!isPaginationClicked) return;
        const getPage = isPaginationClicked.dataset.page;
        const query = new URLSearchParams();
        query.append("page", getPage);
        const getSavedQuery = Object.entries(querySaved);
        if (getSavedQuery.length > 0) {
            getSavedQuery.forEach(([param, value]) => {
                query.append(param, value)
            })
        }
        useFetch({
            url: url + query.toString(),
            action: 'GET',
            headers: {
                "X-Requested-With": 'XMLHttpRequest'
            },
            success: data => {
                const { data_index, total, view } = data;
                dataIndex.innerHTML = data_index;
                tableProdukHukum.innerHTML = view.produk_hukum;
                paginationWrapper.innerHTML = view.pager;
            },
            errors: err => {
                console.error(err)
            }
        })
    })
    deleteDocumentBtn.forEach((btn, btnIdx) => btn.addEventListener("click", () => {
        const documentId = parseInt(btn.dataset.documentId);
        const titleDocument = documentsList[btnIdx].textContent;
        deleteDocument(btnIdx, documentId, titleDocument)
    }))
    btnSubmitSearch.addEventListener("click", async () => {
        querySaved = {};
        const searchValue = searchInput.value.trim();
        const type = documentTypeSelect.value.trim();
        const status = documentStatusSelect.value.trim();
        const year = documentYearSelect.value.trim();
        const querySearch = new URLSearchParams();
        if (searchValue !== "") {
            querySaved["judul"] = searchValue;
            querySearch.append("judul", searchValue)
        }
        if (type !== "semua") {
            querySaved["jenis"] = type;
            querySearch.append("jenis", type)
        }
        if (status !== "semua") {
            querySaved["status"] = status;
            querySearch.append("status", status)
        }
        if (year !== "semua") {
            querySaved["tahun"] = year;
            querySearch.append("tahun", year)
        }
        useFetch({
            url: url + querySearch.toString(),
            action: 'GET',
            headers: {
                "X-Requested-With": 'XMLHttpRequest'
            },
            success: data => {
                const { data_index, total, view } = data;
                dataIndex.innerHTML = data_index;
                tableProdukHukum.innerHTML = view.produk_hukum;
                paginationWrapper.innerHTML = view.pager;
            },
            errors: err => {
                console.error(err)
            }
        })
    })
})