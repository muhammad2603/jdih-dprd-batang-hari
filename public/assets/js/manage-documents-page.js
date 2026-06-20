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
    deleteDocumentBtn.forEach((btn, btnIdx) => btn.addEventListener("click", () => {
        const documentId = parseInt(btn.dataset.documentId);
        const titleDocument = documentsList[btnIdx].textContent;
        deleteDocument(btnIdx, documentId, titleDocument)
    }))
})