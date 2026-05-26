let payload = {};
document.addEventListener("DOMContentLoaded", () => {
    const btnSendMail = document.getElementById("btnSendMail");
    const inputEmail = document.getElementById("email");
    const inputNamaLengkap = document.getElementById("namaLengkap");
    const inputNomorTelpon = document.getElementById("noTelp");
    const inputSubjek = document.getElementById("subject");
    const inputPesan = document.getElementById("message");
    const toastNotification = document.getElementById("toastNotification");
    const csrfToken = document.querySelector("input[name=csrf_token]");
    //! Event listener pada toastNotification dibutuhkan karena notification tidak tersedia sejak awal
    toastNotification.addEventListener('click', e => {
        const closeNotificationBtn = e.target.closest('.close-notification');
        //! Jika bukan tombol close notification yang diklik, jangan eksekusi perintah selanjutnya
        if (!closeNotificationBtn) return;
        const getParentNotificationByCloseBtn = closeNotificationBtn.parentElement;
        getParentNotificationByCloseBtn.classList.add('translate-x-2/4', 'opacity-0', 'pointer-events-none')
        setTimeout(() => getParentNotificationByCloseBtn.remove(), 200)
    })
    btnSendMail.addEventListener("click", () => {
        payload.userEmail = inputEmail.value.trim();
        payload.namaLengkap = inputNamaLengkap.value.trim();
        payload.nomorTelpon = inputNomorTelpon.value.trim();
        payload.subjek = inputSubjek.value.trim();
        payload.pesan = inputPesan.value.trim();

        if (
            payload.userEmail === "" ||
            payload.namaLengkap === "" ||
            payload.nomorTelpon === "" ||
            payload.subjek === "#" ||
            payload.pesan === ""
        ) return;

        fetch('/api/sendmail', {
            method: 'POST',
            headers: {
                "ContentType": 'application/json',
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": csrfToken.value,
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
                const { message, notificationId, notification, newToken } = data;
                csrfToken.value = newToken;
                toastNotification.insertAdjacentHTML(
                    'afterbegin',
                    notification
                )
                const currentNotificationEl = document.getElementById(notificationId);
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        currentNotificationEl.classList.remove('translate-x-2/4', 'opacity-75', 'pointer-events-none')
                    })
                })
                setTimeout(() => {
                    currentNotificationEl.classList.add('pointer-events-none', 'translate-x-2/4', 'opacity-0')
                }, 4000) // delay untuk menutup notifikasi otomatis
                setTimeout(() => {
                    currentNotificationEl.remove()
                }, 4100) // delay untuk menghapus element notifikasi
            })
            .catch(err => {
                if (err.code === 403) return alert("Permintaan tidak diizinkan!");
                const { message, notificationId, notification, newToken } = err;
                csrfToken.value = newToken;
                toastNotification.insertAdjacentHTML(
                    'afterbegin',
                    notification
                )
                const currentNotificationEl = document.getElementById(notificationId);
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        currentNotificationEl.classList.remove('translate-x-2/4', 'opacity-75', 'pointer-events-none')
                    })
                })
                setTimeout(() => {
                    currentNotificationEl.classList.add('pointer-events-none', 'translate-x-2/4', 'opacity-0')
                }, 4000) // delay untuk menutup notifikasi otomatis
                setTimeout(() => {
                    currentNotificationEl.remove()
                }, 4100) // delay untuk menghapus element notifikasi
            });
    })
})