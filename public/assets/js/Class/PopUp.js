/** @typedef {"INFO"|"CHANGE"|"WARNING"} PopupIconType */

/**
 * @typedef {Object} PopupConfig
 * 
 * @property {string} title
 * Judul Pop Up
 * @property {string} warning
 * Pesan warning atau peringatan dibawah judul
 * @property {string} message
 * Pesan dibody Pop Up
 * @property {string} [btnCloseText]
 * Text pada tombol close. Nilai default adalah "Batal"
 * @property {string} [btnConfirmationText]
 * Text pada tombol konfirmasi. Nilai default adalah "Konfirmasi"
 * @property {PopupIcon} icons
 * Konfigurasi Icon Pop Up
 */

/**
 * @typedef {Object} PopupIcon
 *
 * @property {PopupIconType} type
 * Tipe Icon.
 * @property {PopupIconColors} colors
 */

/**
 * @typedef {Object} PopupIconColors
 *
 * @property {string} background
 * Warna background icon, gunakan class dari utility tailwind
 * @property {string} foreground
 * Warna vektor icon svg, gunakan class dari utility tailwind
 */

class PopUp {
    /**
     * Daftar icons yang tersedia
     * 
     * Tambahkan entri baru jika ingin memperluas icon.
     * Gunakan key sebagai identitas dan value adalah ID icon SVG sprite
     * 
     * @readonly
    */
    static ICONS = Object.freeze({
        INFO: "icon-information",
        CHANGE: "icon-pencil-square",
        WARNING: "icon-triangle-alert",
    });

    constructor() {
        /** @type {HTMLDivElement} Element Pop Up Wrapper */
        this.wrapper = document.getElementById("popUpWrapper");
        /** @type {HTMLHeadingElement} Element title Pop Up */
        this.titlePopUp = document.getElementById("titlePopUp");
        /** @type {HTMLParagraphElement} Element warning Pop Up */
        this.warningTextPopUp = document.getElementById("warningTextPopUp");
        /** @type {HTMLParagraphElement} Element body message Pop Up */
        this.messagePopUp = document.getElementById("messagePopUp");
        /** @type {HTMLButtonElement} Element button close Pop Up */
        this.btnClosePopUp = document.getElementById("closePopUp");
        /** @type {HTMLButtonElement} Element button confirm Pop Up */
        this.btnConfirmationPopUp = document.getElementById("confirmationPopUp");
        /** @type {HTMLDivElement} Element icon wrapper Pop Up */
        this.iconWrapper = document.getElementById("iconWrapper");
        /** @type {SVGElement} Element svg icon Pop Up */
        this.iconPopUp = document.getElementById("icon");
    }

    /**
     * Setting Icon Pop Up
     * 
     * @param {PopupIconType} icon 
     * @param {PopupIconColors} colors 
     */
    #setIcon(icon, colors) {
        const { background, foreground } = colors;
        const getTargetIcon = PopUp.ICONS[icon];
        const getUseEl = this.iconPopUp.querySelector('use');
        const getUseHref = getUseEl.href;
        getUseEl.href.baseVal = `/assets/icons.svg#${getTargetIcon}`;
        this.iconWrapper.classList.add(background)
        this.iconPopUp.classList.add(foreground)
    }

    /**
     * Atur konfigurasi elemen pop up
     * @param {PopupConfig} config
     * @param {"confirm"|"alert"} [type]
     * Tipe pop up, default adalah "confirm".
     * @returns {void}
     */
    #elementConfig(config, type = "confirm") {
        const { title, warning, message, btnCloseText, btnConfirmationText, icons } = config;
        this.#setIcon(icons.type, icons.colors)
        this.titlePopUp.innerText = title ?? "";
        this.warningTextPopUp.innerText = warning ?? "";
        this.messagePopUp.innerText = message ?? "";
        if (btnCloseText && type === "confirm") {
            this.btnClosePopUp.innerText = config.btnCloseText ?? "Batal";
        } else {
            this.btnClosePopUp.classList.add('hidden')
        }
        this.btnConfirmationPopUp.innerText = btnConfirmationText ?? "Konfirmasi";
    }

    /**
     * Tutup Pop Up Wrapper
     * @returns {void}
     */
    close() {
        this.wrapper.classList.remove('flex');
        this.wrapper.classList.add('hidden');
    }

    /**
     * Buka Pop Up Wrapper
     * @returns {void}
     */
    show() {
        this.wrapper.classList.remove('hidden');
        this.wrapper.classList.add('flex');
    }

    /**
     * Pop Up confirmation event
     *
     * @param {PopupConfig} config
     * Konfigurasi Pop Up
     * @returns {Promise<boolean>} Pop Up akan tertutup ketika tombol close diklik
     */
    confirm(config) {
        this.#elementConfig(config)
        this.show()
        return new Promise(resolve => {
            this.btnConfirmationPopUp.onclick = () => {
                resolve(true)
            }
            this.btnClosePopUp.onclick = () => {
                this.close()
                resolve(false)
            }
        })
    }

    /**
     * Pop Up info event
     * 
     * @param {PopupConfig} config 
     * @returns {Promise<boolean>} Pop Up akan tertutup ketika tombol konfirmasi diklik
     */
    alert(config) {
        this.#elementConfig(config, "alert")
        this.show()
        return new Promise(resolve => {
            this.btnConfirmationPopUp.onclick = () => {
                this.close()
                resolve(true)
            }
        })
    }
}

export { PopUp };