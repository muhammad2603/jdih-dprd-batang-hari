let payload = {};
document.addEventListener("DOMContentLoaded", () => {
    const btnSendMail = document.getElementById("btnSendMail");
    const inputNamaLengkap = document.getElementById("namaLengkap");
    const inputNomorTelpon = document.getElementById("noTelp");
    const inputSubjek = document.getElementById("subject");
    const inputPesan = document.getElementById("message");
    btnSendMail.addEventListener("click", () => {
        payload.namaLengkap = inputNamaLengkap.value;
        payload.nomorTelpon = inputNomorTelpon.value;
        payload.subjek = inputSubjek.value;
        payload.pesan = inputPesan.value;
        fetch('/api/sendmail', {
            method: 'POST',
            headers: {
                "ContentType": 'application/json',
            },
            body: JSON.stringify(payload)
        })
            .then(resp => resp.json())
            .then(data => console.table(data))
            .catch(err => console.error(err));
    })
})