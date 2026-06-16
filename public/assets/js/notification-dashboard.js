function openNotification(notificationPopUp) {
    notificationPopUp.classList.remove('hidden')
}
function closeNotification(notificationPopUp, dotIconNotification, unreadNotification, dotNotification) {
    dotIconNotification.remove()
    notificationPopUp.classList.add('hidden')
    dotNotification.forEach(el => el.remove())
    if (!unreadNotification.classList.contains('hidden')) {
        unreadNotification.remove()
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationPopUp = document.getElementById('notificationPopUp');
    const unreadNotification = document.getElementById('unreadNotification');
    const dotIconNotification = document.getElementById('dotIconNotification');
    let stateNotification = false;
    window.addEventListener("click", e => {
        const isNotifBtnClicked = e.target.closest("#notificationBtn");
        const isNotifPopUpClicked = e.target.closest("#notificationPopUp");
        const dotNotification = notificationPopUp.querySelectorAll('.dot-notification');
        if (isNotifPopUpClicked) return;
        if (!isNotifBtnClicked) {
            if (stateNotification === true) {
                stateNotification = false;
                closeNotification(notificationPopUp, dotIconNotification, unreadNotification, dotNotification)
            }
            return;
        }
        if (stateNotification === false) {
            stateNotification = true;
            openNotification(notificationPopUp)
        } else {
            stateNotification = false;
            closeNotification(notificationPopUp, dotIconNotification, unreadNotification, dotNotification)
        }
    })

})