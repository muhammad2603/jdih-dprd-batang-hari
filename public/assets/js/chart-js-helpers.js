/**
 * @param {Object} config
 * @param {string} config.containerElementId - ID Chart Container
 * @param {string} config.customLabelClass - Class kustom label
 */
const setCustomHtmlLabels = (config) => {
    let totalDataDatasets = null;
    const { containerElementId, customLabelClass } = config;
    return {
        id: 'customHTMLLabels',
        afterRender: (chart) => {
            const container = document.getElementById(containerElementId);
            if (!container) return;
            // Hapus label lama
            const oldLabels = container.querySelectorAll(customLabelClass);
            oldLabels.forEach(l => l.remove());
            const meta = chart.getDatasetMeta(0);
            if (!meta || !meta.data) return;
            // @explain kondisi ini mencegah dua kali eksekusi yang dilakukan afterRender Chart JS
            if (totalDataDatasets === null) {
                totalDataDatasets = chart.data.datasets[0].data.reduce((acc, num) => num + acc, 0);
            }
            meta.data.forEach((datapoint, index) => {
                // 1. Hitung sudut tengah sektor (dalam radian)
                const angle = (datapoint.startAngle + datapoint.endAngle) / 2;
                // 2. Tentukan seberapa jauh label ingin digeser ke luar
                const JarakKeluar = datapoint.outerRadius + 40;
                // 3. Hitung koordinat X dan Y baru menggunakan Sin & Cos
                const x = datapoint.x + Math.cos(angle) * JarakKeluar;
                const y = datapoint.y + Math.sin(angle) * JarakKeluar;
                const label = document.createElement('div');
                const labelName = chart.data.labels[index];
                const labelColor = chart.data.datasets[0].backgroundColor[index];
                const data = chart.data.datasets[0].data[index];
                const calculatePercent = ((data / totalDataDatasets) * 100).toFixed(2);
                label.className = 'custom-label text-sm text-shadow-sm';
                label.innerText = `${labelName}: ${calculatePercent}%`;
                // Ambil offset canvas agar posisi presisi
                const canvasLeft = chart.canvas.offsetLeft;
                const canvasTop = chart.canvas.offsetTop;
                const setX = x + canvasLeft;
                const setY = y + canvasTop;
                const modifyX = setX < 50 ? setX - 50 : (setX > 230 ? setX + 50 : setX);
                Object.assign(label.style, {
                    position: 'absolute',
                    left: `${modifyX}px`,
                    top: `${setY}px`,
                    transform: 'translate(-50%, -50%)', // Agar titik tengah teks pas di koordinat
                    zIndex: '1',
                    pointerEvents: 'none',
                    whiteSpace: 'nowrap',
                    fontWeight: 'semibold',
                    color: labelColor
                });
                container.appendChild(label);
            });
        }
    }
}
class ChartInit {
    /**
     * 
     * @param {string | HTMLCanvasElement} element - Elemen chart, bisa menggunakan string ID atau document.getElement...()
     * @param {string} type - Tipe chart, pie, bar, line, dll.
     * @param {Object} options - Option chart {opsional}
     * @param {Object} plugins - Plugin tambahan {opsional}
     */
    constructor({ element, type, data, options = {}, plugins = [] }) {
        Object.assign(this, { element, type, data, options, plugins })
    }
    create() {
        const ctx = typeof this.element === 'string'
            ? document.getElementById(this.element)
            : this.element;
        if (!ctx) {
            throw new Error("Error: Element Chart tidak ditemukan")
        }
        return new Chart(ctx, {
            type: this.type,
            data: this.data,
            options: this.options,
            plugins: this.plugins
        })
    }
}
export { setCustomHtmlLabels, ChartInit }