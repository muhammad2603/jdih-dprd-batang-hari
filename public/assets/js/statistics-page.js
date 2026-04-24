import {
    setCustomHtmlLabels,
    ChartInit
} from './chart-js-helpers.js';
document.addEventListener("DOMContentLoaded", function () {
    const ctxChartDistributedByType = document.getElementById('chartDistributedByType');
    const ctxChartDocumentByYear = document.getElementById('chartDocumentByYear');
    const ctxTrendMonths = document.getElementById('chartTrendMonths');
    const customHTMLLabels = setCustomHtmlLabels({
        containerElementId: 'chartContainer',
        customLabelClass: '.custom-label'
    });
    const dataChartPie = {
        labels: ["Peraturan Bupati", "Keputusan Bupati", "Instruksi Bupati", "Keputusan DPRD", "Peraturan Daerah"],
        datasets: [{
            label: "Total Dokumen",
            data: [287, 198, 42, 76, 145],
            borderWidth: 1.5,
            backgroundColor: [
                "#C9A961",
                "#6B7280",
                "#D1D5DB",
                "#9CA3AF",
                "#8B1538"
            ],
            hoverOffset: 0,
            hoverBackgroundColor: [
                "#C9A961",
                "#6B7280",
                "#D1D5DB",
                "#9CA3AF",
                "#8B1538"
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
    const chartBarData = {
        labels: [2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026],
        datasets: [{
            label: 'Total',
            data: [68, 72, 85, 94, 108, 115, 98, 35],
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
                max: 150,
                ticks: {
                    stepSize: 30
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
    const chartLineData = {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Total Dokumen',
            data: [8, 12, 15, 10, 18, 14, 16, 20, 13, 17, 19, 22],
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
                // max: 150,
                ticks: {
                    stepSize: 6
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