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
                reject({
                    closed: true
                })
            }
        })
    }
}

const popUp = new PopUp();
function deleteDocument(btnIdx, docId, titleDocument) {
    const popUpConfig = {
        "title": 'Hapus Dokumen',
        "warning": 'Dokumen akan dihapus sementara dan dapat dipulihkan kapan saja',
        "message": titleDocument,
    };
    popUp.confirm(popUpConfig)
        .then(() => {
            console.log("Dikonfirmasi.")
        })
}
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
    btnSubmitSearch.addEventListener("click", () => {
        const searchValue = searchInput.value.trim();
        const type = documentTypeSelect.value.trim();
        const status = documentStatusSelect.value.trim();
        const year = documentYearSelect.value.trim();
        let url = '/api/cari-dokumen?';
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
        fetch(url + querySearch.toString(), {
            method: 'GET',
            headers: {
                "Content-Type": 'application/x-www-form-urlencoded',
                "X-Requested-With": 'XMLHttpRequest'
            }
        })
            .then(xhr => {
                return xhr.json();
            })
            .then(data => {
                const { total, view } = data;
                totalDocumentFound.innerText = total;
                tableProdukHukum.innerHTML = view;
            })
            .catch(err => console.error("Terjadi kesalahan saat mengambil data."))
    })

})