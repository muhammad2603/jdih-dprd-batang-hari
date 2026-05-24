let payload = {};
document.addEventListener("DOMContentLoaded", () => {
    const btnSendMail = document.getElementById("btnSendMail");
    const inputEmail = document.getElementById("email");
    const inputNamaLengkap = document.getElementById("namaLengkap");
    const inputNomorTelpon = document.getElementById("noTelp");
    const inputSubjek = document.getElementById("subject");
    const inputPesan = document.getElementById("message");
    const toastNotification = document.getElementById("toastNotification");
    const notificationTitle = toastNotification.querySelector(".title");
    const notificationMessage = toastNotification.querySelector(".message");
    btnSendMail.addEventListener("click", () => {
        payload.userEmail = inputEmail.value;
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
            .then(async (resp) => {
                const data = await resp.json();
                if (!resp.ok) {
                    throw data;
                };
                return data;
            })
            .then(data => {
                const { message } = data;
                notificationTitle.textContent = "Pengiriman Pesan";
                notificationMessage.textContent = message;
            })
            .catch(err => {
                const { message } = err;
                notificationTitle.textContent = "Pengiriman Pesan";
                notificationMessage.textContent = message;
            });
    })
})