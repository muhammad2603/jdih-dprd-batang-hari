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
 * @property {PopupIconType} icon
 * Konfigurasi Icon Pop Up
 */

/**
 * @typedef {Object} PopupIconColors
 *
 * @property {string} background
 * Warna background icon, gunakan class dari utility tailwind
 * @property {string} foreground
 * Warna vektor icon svg, gunakan class dari utility tailwind
 */

/**
 * @typedef {Object} PopupIconDefinition
 * 
 * @property {string} ICON
 * ID icon di SVG sprite
 * @property {PopupIconColors} ICON_COLORS
 * Konfigurasi warna icon
 * @property {string[]} BUTTON_CONFIRM_COLORS
 */

class PopUp {
    /**
     * Daftar icons yang tersedia
     * 
     * Tambahkan entri baru jika ingin memperluas icon.
     * Gunakan key sebagai identitas dan value adalah ID icon SVG sprite
     * 
     * @readonly
     * @type {Readonly<Record<PopupIconType, PopupIconDefinition>>}
    */
    static ICONS = Object.freeze({
        INFO: {
            ICON: "icon-information",
            ICON_COLORS: {
                background: 'bg-blue-100',
                foreground: 'text-blue-600'
            },
            BUTTON_CONFIRM_COLORS: ["bg-blue-600", "hover:bg-blue-700", "focus:bg-blue-700"],
        },
        CHANGE: {
            ICON: "icon-pencil-square",
            ICON_COLORS: {
                background: 'bg-indigo-100',
                foreground: 'text-indigo-600'
            },
            BUTTON_CONFIRM_COLORS: ["bg-indigo-600", "hover:bg-indigo-700", "focus:bg-indigo-700"],
        },
        WARNING: {
            ICON: "icon-triangle-alert",
            ICON_COLORS: {
                background: 'bg-red-100',
                foreground: 'text-red-600'
            },
            BUTTON_CONFIRM_COLORS: ["bg-red-600", "hover:bg-red-700", "focus:bg-red-700"],
        },
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
     * Hapus semua warna icon SVG Pop Up dan warna background dan event ditombol konfirmasi menggunakan looping
     * 
     * @returns {void}
     */
    #loopForRemoveColorIcons() {
        Object.entries(PopUp.ICONS).forEach(([key, values]) => {
            const { ICON_COLORS, BUTTON_CONFIRM_COLORS } = values;
            this.iconWrapper.classList.remove(ICON_COLORS.background)
            this.iconPopUp.classList.remove(ICON_COLORS.foreground)
            BUTTON_CONFIRM_COLORS.forEach(color => this.btnConfirmationPopUp.classList.remove(color))
        })
    }

    /**
     * Setting Icon Pop Up
     * 
     * @param {PopupIconType} icon
     */
    #setIcon(icon) {
        this.#loopForRemoveColorIcons();
        const getTargetIcon = PopUp.ICONS[icon];
        const getUseEl = this.iconPopUp.querySelector('use');
        const getUseHref = getUseEl.href;
        getUseEl.href.baseVal = `/assets/icons.svg#${getTargetIcon.ICON}`;
        this.iconWrapper.classList.add(getTargetIcon.ICON_COLORS.background)
        this.iconPopUp.classList.add(getTargetIcon.ICON_COLORS.foreground)
        this.btnConfirmationPopUp.classList.add(...getTargetIcon.BUTTON_CONFIRM_COLORS)
    }

    /**
     * Atur konfigurasi elemen pop up
     * @param {PopupConfig} config
     * @param {"confirm"|"alert"} [type]
     * Tipe pop up, default adalah "confirm".
     * @returns {void}
     */
    #elementConfig(config, type = "confirm") {
        const { title, warning, message, btnCloseText, btnConfirmationText, icon } = config;
        this.#setIcon(icon)
        this.titlePopUp.innerText = title ?? "";
        this.warningTextPopUp.innerText = warning ?? "";
        this.messagePopUp.innerText = message ?? "";
        if (btnCloseText && type === "confirm") {
            this.btnClosePopUp.classList.remove('hidden')
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