class PopUp {
    constructor() {
        this.wrapper = document.getElementById("popUpWrapper");
        this.titlePopUp = document.getElementById("titlePopUp");
        this.warningTextPopUp = document.getElementById("warningTextPopUp");
        this.messagePopUp = document.getElementById("messagePopUp");
        this.btnClosePopUp = document.getElementById("closePopUp");
        this.btnConfirmationPopUp = document.getElementById("confirmationPopUp");
        this.iconWrapper = document.getElementById("iconWrapper");
        this.iconPopUp = document.getElementById("icon");
        this.iconInfo = "icon-information";
        this.iconEdit = "icon-pencil-square";
        this.iconDelete = "icon-triangle-alert";
    }
    #setIcon(icon, colors) {
        const { background, foreground } = colors;
        const getTargetIcon = this[icon];
        const getUseEl = popUp.iconPopUp.querySelector('use');
        const getUseHref = getUseEl.href;
        getUseEl.href.baseVal = `/assets/icons.svg#${getTargetIcon}`;
        this.iconWrapper.classList.add(background)
        this.iconPopUp.classList.add(foreground)
    }
    #elementConfig(config) {
        const { title, warning, message, btnConfirmationText, icons } = config;
        this.#setIcon(icons.type, icons.colors)
        this.titlePopUp.innerText = title ?? "";
        this.warningTextPopUp.innerText = warning ?? "";
        this.messagePopUp.innerText = message ?? "";
        this.btnConfirmationPopUp.innerText = btnConfirmationText ?? "Konfirmasi";
    }
    close() {
        this.wrapper.classList.remove('flex');
        this.wrapper.classList.add('hidden');
    }
    show() {
        this.wrapper.classList.remove('hidden');
        this.wrapper.classList.add('flex');
    }
    confirm(config) {
        this.#elementConfig(config)
        this.btnClosePopUp.innerText = config.btnCloseText ?? "Batal";
        this.show()
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
        const result = await response.json();
        if (!response.ok) throw result;
        success(result)
    } catch (error) {
        errors(error)
    }
}
const fetchDocuments = (url, elements) => useFetch({
    url: url,
    action: 'GET',
    headers: {
        "X-Requested-With": 'XMLHttpRequest'
    },
    success: data => {
        const { data_index, total, view } = data;
        elements.dataIndex.innerHTML = data_index;
        elements.dataView.innerHTML = view.produk_hukum;
        elements.pagination.innerHTML = view.pager;
    },
    errors: err => {
        console.error(err)
    }
});
const popUp = new PopUp();
const deleteDocument = (tokenCsrfInput, docId, titleDocument) => {
    const popUpConfig = {
        title: 'Hapus Dokumen',
        warning: 'Dokumen akan dihapus secara permanen dan tidak dapat dipulihkan. Apakah anda yakin?',
        message: titleDocument,
        icons: {
            type: "iconDelete",
            colors: {
                background: 'bg-red-100',
                foreground: 'text-red-600'
            }
        }
    };
    popUp.confirm(popUpConfig)
        .then(() => {
            useFetch({
                url: `/api/hapus-dokumen/${docId}`,
                action: 'DELETE',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": tokenCsrfInput.value.trim(),
                },
                success: resp => {
                    const { status, message, new_token } = resp;
                    tokenCsrfInput.value = new_token;
                    console.log(status ? "OK" : "FAIL")
                    console.log(message)
                },
                errors: err => {
                    const { message, new_token } = err;
                    tokenCsrfInput.value = new_token;
                    document.getElementById("dataIndex").innerText = message;
                }
            })
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
    const tokenCsrf = document.querySelector("input[name=csrf_token]");
    fetchDocuments(url, { dataIndex: dataIndex, dataView: tableProdukHukum, pagination: paginationWrapper })
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
        const urlQueries = url + query.toString();
        fetchDocuments(urlQueries, { dataIndex: dataIndex, dataView: tableProdukHukum, pagination: paginationWrapper })
    })
    tableProdukHukum.addEventListener("click", e => {
        const target = e.target;
        const btnDelete = target.closest('.delete-document');
        if (!btnDelete) return;
        const documentId = parseInt(btnDelete.dataset.documentId);
        const titleDocument = btnDelete.closest('tr').querySelector('.judul-dokumen').innerText;
        deleteDocument(tokenCsrf, documentId, titleDocument)
    })
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
        const urlQuery = url + querySearch.toString();
        fetchDocuments(urlQuery, { dataIndex: dataIndex, dataView: tableProdukHukum, pagination: paginationWrapper })
    })
})