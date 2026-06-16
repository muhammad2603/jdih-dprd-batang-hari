document.addEventListener('DOMContentLoaded', () => {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationPopUp = document.getElementById('notificationPopUp');
    const unreadNotification = document.getElementById('unreadNotification');
    const dotIconNotification = document.getElementById('dotIconNotification');
    let stateNotification = false;
    notificationBtn.addEventListener('click', function () {
        const dotNotification = notificationPopUp.querySelectorAll('.dot-notification');
        if (stateNotification === false) {
            stateNotification = true;
            notificationPopUp.classList.remove('hidden')
        } else {
            stateNotification = false;
            dotIconNotification.remove()
            notificationPopUp.classList.add('hidden')
            dotNotification.forEach(el => el.remove())
            if (!unreadNotification.classList.contains('hidden')) {
                unreadNotification.remove()
            }
        }
    })
})