import { classManipulation } from "./class-manipulation.js";
const firstStripAnimateWhenMenuOpened = ({ firstLineEl, secondLineEl, thirdLineEl }) => {
    classManipulation(firstLineEl).inlineStyle("transform", 'translateY(20.5px)')
    classManipulation(secondLineEl).add("delay-50").inlineStyle("transform", 'translateY(11.5px)')
    // strip menu pertama dan kedua akan berhenti sesuai dengan posisi strip ketiga
    classManipulation(thirdLineEl).add("delay-45").inlineStyle("transform", 'translateY(3px)')
}
const secondStripAnimateWhenMenuOpened = ({ firstLineEl, secondLineEl, thirdLineEl }) => {
    classManipulation(firstLineEl).inlineStyle("transform", 'translateY(250%) rotate(45deg)')
    classManipulation(secondLineEl).remove('delay-50').add('opacity-0')
    classManipulation(thirdLineEl).remove('delay-45').inlineStyle("transform", 'translateY(-250%) rotate(-45deg)')
}
const firstStripAnimateWhenMenuClosed = ({ firstLineEl, secondLineEl, thirdLineEl }) => {
    classManipulation(firstLineEl).inlineStyle("transform", 'translateY(20.5px) rotate(0deg)')
    classManipulation(thirdLineEl).inlineStyle("transform", 'translateY(3px) rotate(0deg)')
    classManipulation(secondLineEl).remove('opacity-0')
}
const secondStripAnimateWhenMenuClosed = ({ firstLineEl, secondLineEl, thirdLineEl }) => {
    classManipulation(firstLineEl).inlineStyle("transform", 'translateY(0px)')
    classManipulation(secondLineEl).inlineStyle("transform", 'translateY(0px)')
    classManipulation(thirdLineEl).inlineStyle("transform", 'translateY(0px)')
}
const openMenu = (elements, navMobileOpenedHeight) => {
    const { btnHamburgerEl, navMobileEl } = elements;
    classManipulation(btnHamburgerEl).add('pointer-events-none')
    // @Animate-Open-1: pindahkan posisi strip menu kebawah
    firstStripAnimateWhenMenuOpened(elements)
    classManipulation(navMobileEl).remove('opacity-0', 'pointer-events-none', 'h-0').inlineStyle("height", navMobileOpenedHeight)
    // @Animate-Open-2: berikan jeda agar strip terlihat menumpuk sebentar selama 450ms, setelah jeda, bentuknya akan menjadi "X"
    setTimeout(() => {
        secondStripAnimateWhenMenuOpened(elements)
        classManipulation(btnHamburgerEl).remove('pointer-events-none')
    }, 450)
}
const closeMenu = elements => {
    const { btnHamburgerEl, navMobileEl, firstLineEl, secondLineEl, thirdLineEl } = elements;
    classManipulation(btnHamburgerEl).add('pointer-events-none')
    // @Animate-Close-1: kembalikan posisi rotasi dan posisi strip
    firstStripAnimateWhenMenuClosed(elements)
    classManipulation(navMobileEl).add('pointer-events-none').inlineStyle("height", '0px')
    // Animate-Close-2: beri jeda sebelum mengembalikan strip
    setTimeout(() => {
        classManipulation(navMobileEl).add('opacity-0')
        secondStripAnimateWhenMenuClosed(elements)
        classManipulation(btnHamburgerEl).remove('pointer-events-none')
    }, 450)
}
document.addEventListener("DOMContentLoaded", () => {
    const btnHamburger = document.getElementById("hamburgerMenu");
    const elements = {
        btnHamburgerEl: btnHamburger,
        navMobileEl: document.getElementById("navMobile"),
        firstLineEl: btnHamburger.querySelector("span:nth-child(1)"),
        secondLineEl: btnHamburger.querySelector("span:nth-child(2)"),
        thirdLineEl: btnHamburger.querySelector("span:nth-child(3)")
    };
    let stateHamburger = false;
    const navMobileHeight = '185px';
    btnHamburger.addEventListener("click", function () {
        if (stateHamburger === false) {
            stateHamburger = true;
            openMenu(elements, navMobileHeight)
        } else {
            stateHamburger = false;
            closeMenu(elements)
        }
    })

})