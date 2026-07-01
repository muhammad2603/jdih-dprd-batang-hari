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
document.addEventListener('DOMContentLoaded', () => {
    const deleteDocumentBtn = document.querySelectorAll('.delete-document');
    const documentsList = document.querySelectorAll('.judul-dokumen');
    const searchInput = document.getElementById("search");
    const documentTypeSelect = document.getElementById("documentType");
    const documentStatusSelect = document.getElementById("documentStatus");
    const documentYearSelect = document.getElementById("documentYear");
    const btnSubmitSearch = document.getElementById("submitSearch");
    const tableProdukHukum = document.getElementById("tableProdukHukum");
    const totalDocumentFound = document.getElementById("totalDocumentFound");
    deleteDocumentBtn.forEach((btn, btnIdx) => btn.addEventListener("click", () => {
        const documentId = parseInt(btn.dataset.documentId);
        const titleDocument = documentsList[btnIdx].textContent;
        deleteDocument(btnIdx, documentId, titleDocument)
    }))
    btnSubmitSearch.addEventListener("click", async () => {
        const searchValue = searchInput.value.trim();
        const type = documentTypeSelect.value.trim();
        const status = documentStatusSelect.value.trim();
        const year = documentYearSelect.value.trim();
        const querySearch = new URLSearchParams();
        if (searchValue !== "") {
            querySearch.append("judul", searchValue)
        }
        if (type !== "semua") {
            querySearch.append("jenis", type)
        }
        if (status !== "semua") {
            querySearch.append("status", status)
        }
        if (year !== "semua") {
            querySearch.append("tahun", year)
        }
        useFetch({
            url: url + querySearch.toString(),
            action: 'GET',
            headers: {
                "X-Requested-With": 'XMLHttpRequest'
            },
            success: data => {
                const { total, view } = data;
                totalDocumentFound.innerText = total;
                tableProdukHukum.innerHTML = view;
            },
            errors: err => {
                console.error(err)
            }
        })
    })
})