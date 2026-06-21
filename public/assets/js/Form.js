import { classManipulation } from "./class-manipulation.js";
import { $id } from "./dom.js";
const hiddenTab = tab => {
    classManipulation(tab).add("hidden");
}
const hiddenAllTabs = listTabs => {
    listTabs.forEach(tab => hiddenTab(tab));
}
const inactiveButtonTab = button => {
    classManipulation(button)
        .remove("border-primary", "text-primary")
        .add("border-transparent", "text-gray-500", "hover:text-gray-700");
}
const inactiveAllButtonsTab = listButtons => {
    listButtons.forEach(btn => inactiveButtonTab(btn))
}
const activatedButtonTab = button => {
    classManipulation(button)
        .remove("border-transparent", "text-gray-500", "hover:text-gray-700")
        .add("border-primary", "text-primary");
}
const showTab = tab => {
    classManipulation(tab).remove('hidden')
}
class FormTab {
    constructor(listBtnTab, listTabs) {
        this.listBtnTab = listBtnTab;
        this.listTabs = listTabs;
    }

    openTab(currBtn) {
        const tabId = currBtn.dataset.tabId;
        const targetTabEl = $id(tabId);
        inactiveAllButtonsTab(this.listBtnTab)
        hiddenAllTabs(this.listTabs)
        activatedButtonTab(currBtn)
        showTab(targetTabEl)
    }
}
export { FormTab };