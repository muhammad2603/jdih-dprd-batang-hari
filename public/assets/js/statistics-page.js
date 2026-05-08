import {
    setCustomHtmlLabels,
    ChartInit
} from './chart-js-helpers.js';
function createDataChartFromInputElement(inputId, separator, separatorKeyValue = ":") {
    const valueInput = document.getElementById(inputId).value;
    const splitValueInput = valueInput.split(separator);
    const key = [];
    const value = [];
    splitValueInput.forEach(item => {
        let [keyItem, valueItem] = item.split(separatorKeyValue);
        keyItem = !isNaN(parseInt(keyItem)) ? parseInt(keyItem) : keyItem;
        valueItem = !isNaN(parseInt(valueItem)) ? parseInt(valueItem) : valueItem;
        key.push(keyItem)
        value.push(valueItem)
    })
    return [
        key,
        value
    ];
}

function setTrend(item, arrayRef, arrayFilled) {
    const [month, total] = item.split(":");
    const indexMonth = arrayRef.indexOf(month);
    arrayFilled[indexMonth] = parseInt(total);
}

function createNewArray(length, fill) {
    return Array.from({ length: length }).fill(fill);
}
document.addEventListener("DOMContentLoaded", function () {
    const ctxChartDistributedByType = document.getElementById('chartDistributedByType');
    const ctxChartDocumentByYear = document.getElementById('chartDocumentByYear');
    const ctxTrendMonths = document.getElementById('chartTrendMonths');
    const customHTMLLabels = setCustomHtmlLabels({
        containerElementId: 'chartContainer',
        customLabelClass: '.custom-label'
    });
    const [categoriesArray, totalArray] = createDataChartFromInputElement("distributedByCategories", ",");
    const dataChartPie = {
        labels: categoriesArray,
        datasets: [{
            label: "Total Dokumen",
            data: totalArray,
            borderWidth: 1.5,
            backgroundColor: [
                "#8b1538",
                "#c9a961",
                "#6B7280",
                "#9CA3AF",
                "#D1D5DB"
            ],
            hoverOffset: 0,
            hoverBackgroundColor: [
                "#8b1538",
                "#c9a961",
                "#6B7280",
                "#9CA3AF",
                "#D1D5DB"
            ]
        }]
    };
    const optionsChartPie = {
        layout: {
            padding: 50
        },
        rotation: 90,
        animation: {
            duration: 2500
        },
        plugins: {
            legend: {
                display: false
            }
        }
    };
    const chartPieInit = new ChartInit({
        element: ctxChartDistributedByType,
        type: "pie",
        data: dataChartPie,
        options: optionsChartPie,
        plugins: [customHTMLLabels]
    });
    chartPieInit.create();
    const [yearArray, dataTotalArray] = createDataChartFromInputElement("yearProdukHukumUploadRange", ",");
    const getMaxTotal = Math.max(...dataTotalArray);
    const paddingMax = 20;
    const calcMaxBarChart = (getMaxTotal - (getMaxTotal % paddingMax)) + paddingMax;
    const chartBarData = {
        labels: yearArray,
        datasets: [{
            label: 'Total',
            data: dataTotalArray,
            backgroundColor: "#8b1538",
            borderRadius: 8
        }],
    };
    const chartBarOptions = {
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                grid: {
                    color: '#E5E7EB',
                    tickColor: "#6B7280"
                },
                border: {
                    dash: [2.5, 2.5],
                    color: "#6B7280",
                }
            },
            y: {
                grid: {
                    color: '#E5E7EB',
                    tickColor: "#6B7280"
                },
                border: {
                    dash: [2.5, 2.5],
                    color: "#6B7280",
                },
                beginAtZero: true,
                max: calcMaxBarChart,
                ticks: {
                    stepSize: paddingMax / 4
                }
            }
        },
        animation: false,
        animations: {
            colors: false,
            x: false
        },
        transitions: {
            active: {
                animation: {
                    duration: 0
                }
            }
        }
    };
    const chartBarInit = new ChartInit({
        element: ctxChartDocumentByYear,
        type: "bar",
        data: chartBarData,
        options: chartBarOptions
    });
    chartBarInit.create();
    const fullMonth = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    const getMonthsTrend = document.getElementById("monthsTrend").value;
    const splitMonths = getMonthsTrend.split(", ");
    const totalsTrend = createNewArray(fullMonth.length, 0);
    splitMonths.forEach(item => setTrend(item, fullMonth, totalsTrend))
    const maxTotalTrend = Math.max(...totalsTrend)
    const yMaxLineChart = maxTotalTrend < 10 ? 10 : maxTotalTrend + 10;
    const stepTicksLineChart = yMaxLineChart === 10 ? 2 : Math.floor(yMaxLineChart / 3);
    const chartLineData = {
        labels: fullMonth,
        datasets: [{
            label: 'Total Dokumen',
            data: totalsTrend,
            fill: false,
            borderColor: '#C9A961',
            borderWidth: 3,
            tension: 0,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointBackgroundColor: "#C9A961",
            pointHoverBackgroundColor: "#C9A961",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointHoverBorderColor: "#FFF",
        }],
    };
    const chartLineOptions = {
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                grid: {
                    color: '#E5E7EB',
                    tickColor: "#6B7280"
                },
                border: {
                    dash: [2.5, 2.5],
                    color: "#6B7280",
                }
            },
            y: {
                grid: {
                    color: '#E5E7EB',
                    tickColor: "#6B7280"
                },
                border: {
                    dash: [2.5, 2.5],
                    color: "#6B7280",
                },
                beginAtZero: true,
                max: yMaxLineChart,
                ticks: {
                    stepSize: stepTicksLineChart
                }
            }
        },
        animations: {
            tension: {
                duration: 1200,
                easing: 'easeInOutCubic',
                from: 0,
                to: 0.45,
                loop: false
            }
        },
        maintainAspectRatio: false,
    };
    const chartLineInit = new ChartInit({
        element: ctxTrendMonths,
        type: "line",
        data: chartLineData,
        options: chartLineOptions
    });
    chartLineInit.create();
})