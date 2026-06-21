const hiddenTab = tab => {
    tab.classList.add("hidden")
}
const hiddenAllTabs = listTabs => {
    listTabs.forEach(tab => hiddenTab(tab));
}
const inactiveButtonTab = button => {
    button.classList.remove("border-primary", "text-primary")
    button.classList.add("border-transparent", "text-gray-500", "hover:text-gray-700")
}
const inactiveAllButtonsTab = listButtons => {
    listButtons.forEach(btn => inactiveButtonTab(btn))
}
const activatedButtonTab = button => {
    button.classList.remove("border-transparent", "text-gray-500", "hover:text-gray-700")
    button.classList.add("border-primary", "text-primary")
}
const showTab = tab => {
    tab.classList.remove('hidden')
}
class FormTab {
    constructor(listBtnTab, listTabs) {
        this.listBtnTab = listBtnTab;
        this.listTabs = listTabs;
    }

    openTab(currBtn) {
        const tabId = currBtn.dataset.tabId;
        const targetTabEl = document.getElementById(tabId);
        inactiveAllButtonsTab(this.listBtnTab)
        hiddenAllTabs(this.listTabs)
        activatedButtonTab(currBtn)
        showTab(targetTabEl)
    }
}
export { FormTab };