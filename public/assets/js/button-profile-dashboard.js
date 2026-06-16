let state = false;
document.addEventListener("DOMContentLoaded", () => {
    const btnProfile = document.getElementById("btnProfile");
    const profileDropdown = document.getElementById("profileDropdown");
    window.addEventListener("click", e => {
        const target = e.target;
        const isBtnProfileClicked = target.closest("#btnProfile");
        const isProfileDropdownClicked = target.closest("#profileDropdown");
        if (isProfileDropdownClicked) return;
        if (!isBtnProfileClicked) {
            if (state === true) {
                state = false;
                profileDropdown.classList.add("opacity-0")
                profileDropdown.classList.add("pointer-events-none")
            }
            return;
        }
        if (state === false) {
            state = true;
            profileDropdown.classList.remove("opacity-0")
            profileDropdown.classList.remove("pointer-events-none")
        } else {
            state = false;
            profileDropdown.classList.add("opacity-0")
            profileDropdown.classList.add("pointer-events-none")
        }
    })
})