import { PopUp } from "./Class/PopUp.js";
import { useFetch } from "./Class/Fetch.js";
import { $$ } from './dom.js';
const popUp = new PopUp();
const createPopUpConfig = () => {
    return {
        alert: (title = "Peringatan!", warning = "", message = "Tindakan ini harus dilakukan dengan hati-hati.") => {
            return {
                title: title,
                warning: warning,
                message: message,
                btnCloseText: "Batal",
                icon: "WARNING"
            }
        },
        info: (title = "Pemberitahuan", warning = "", message) => {
            return {
                title: title,
                warning: warning,
                message: message,
                btnConfirmationText: "OK",
                icon: "INFO"
            }
        },
        danger: (title = "Terjadi Kesalahan!", warning = "", message) => {
            return {
                title: title,
                warning: warning,
                message: message,
                btnConfirmationText: "OK",
                icon: "WARNING"
            }
        },
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
        const popUpConfig = createPopUpConfig().danger(
            "Terjadi Kesalahan!",
            "Permintaan gagal dipenuhi.",
            err.message
        );
        popUp.alert(popUpConfig)
    }
});
const deleteDocument = async (tokenCsrfInput, docId, titleDocument) => {
    const popUpConfig = createPopUpConfig().alert("Hapus Dokumen", 'Dokumen akan dihapus secara permanen dan tidak dapat dipulihkan. Apakah anda yakin?', titleDocument);
    const isConfirmed = await popUp.confirm(popUpConfig);
    if (isConfirmed) {
        useFetch({
            url: `/api/hapus-dokumen/${docId}`,
            action: 'DELETE',
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": $$(tokenCsrfInput).getInputValue(),
            },
            success: async resp => {
                const { status, message } = resp;
                const popUpConfig = createPopUpConfig().info("Dokumen berhasil dihapus!", `Status: success`, message)
                const stateClosedPopUp = await popUp.alert(popUpConfig)
                if (stateClosedPopUp) window.location.reload();
            },
            errors: err => {
                const { message, new_token } = err;
                tokenCsrfInput.value = new_token;
                const popUpConfig = createPopUpConfig().danger("Terjadi Kesalahan!", "Dokumen gagal dihapus.", err.message);
                popUp.alert(popUpConfig)
            }
        })
        popUp.close()
    }
};
const changeStatePublishDocument = async (tokenCsrfInput, docId, titleDocument, changeState) => {
    const setWarningMessage = (changeState === 1) ? "Dokumen akan ditampilkan diwebsite." : "Dokumen akan disembunyikan dan tidak akan ditampilkan diwebsite.";
    const setConfig = createPopUpConfig().alert("Ubah status publikasi?", setWarningMessage, titleDocument);
    const isConfirmed = await popUp.confirm(setConfig);
    if (isConfirmed) {
        const formData = new FormData();
        formData.append("_method", "PATCH")
        formData.append("is_publish", changeState)
        useFetch({
            action: "POST",
            url: `/api/update-dokumen/${docId}`,
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": $$(tokenCsrfInput).getInputValue(),
            },
            body: formData,
            success: async resp => {
                const { status } = resp;
                if (status) {
                    const setFinalMessage = (changeState === 1) ? "Dokumen telah ditampilkan diwebsite." : "Dokumen telah disembunyikan diwebsite.";
                    const setSuccessConfig = createPopUpConfig().info("Status Publikasi Berhasil Diubah!", "Status: success", setFinalMessage);
                    const showAlertPopUp = await popUp.alert(setSuccessConfig);
                    if (showAlertPopUp) window.location.reload();
                }
            },
            errors: err => {
                const { new_token } = err;
                tokenCsrfInput.value = new_token;
                const popUpConfig = createPopUpConfig().danger("Terjadi Kesalahan!", "Status publikasi gagal diubah.", "Jika ini terus berlanjut, mohon hubungi Administrator!");
                popUp.alert(popUpConfig)
            }
        })
    }
};
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
        const btnChangeStatePublish = target.closest('.change-state-publish');
        if (!btnDelete && !btnChangeStatePublish) return;
        const documentId = parseInt(target.closest('.actions-parent')?.dataset.documentId);
        const titleDocument = target.closest('tr').querySelector('.judul-dokumen').innerText;
        if (btnDelete) {
            deleteDocument(tokenCsrf, documentId, titleDocument)
        }
        if (btnChangeStatePublish) {
            const changeState = parseInt(btnChangeStatePublish.dataset.changeState);
            changeStatePublishDocument(tokenCsrf, documentId, titleDocument, changeState)
        }
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