window.addEventListener("keydown", e => {
    if (e.key !== "F5") {
        e.preventDefault()
    }
})
window.addEventListener("contextmenu", e => e.preventDefault())