let chart;

function renderWifiChart() {

    const el = document.querySelector('#locationChart');
    if (!el) return;

    const chartData = JSON.parse(el.dataset.chart);

    const categories = chartData.map(d => d.label);
    const counts = chartData.map(d => d.count);

    const isHorizontal = categories.length > 6;

    const maxValue = Math.max(...counts, 0);
    const yAxisMax = maxValue + Math.max(Math.ceil(maxValue * 0.25), 2);

    if (chart) {
        chart.destroy();
    }

    const options = {

        chart: {
            type: 'bar',
            height: isHorizontal
                ? Math.max(360, categories.length * 40)
                : 360,

            toolbar: {
                show: false
            },

            fontFamily: 'inherit',

            animations: {
                enabled: true,
                speed: 400
            },

            background: 'transparent',
        },

        series: [{
            name: 'Locations',
            data: counts,
        }],

        colors: ['#7C3AED'],

        plotOptions: {
            bar: {
                horizontal: isHorizontal,
                borderRadius: 8,
                columnWidth: '45%',
                barHeight: '55%',
            }
        },

        dataLabels: {
            enabled: false,
        },

        xaxis: {
            categories: categories,

            labels: {
                rotate: 0,
                trim: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 500,
                }
            },

            axisBorder: {
                show: false
            },

            axisTicks: {
                show: false
            },
        },

        yaxis: {
            max: yAxisMax,

            labels: {
                formatter: val => Math.round(val),
                style: {
                    colors: '#64748B',
                    fontSize: '12px',
                }
            }
        },

        grid: {
            borderColor: '#EDE9FE',
            strokeDashArray: 4,
        },

        tooltip: {
            theme: 'light',
            y: {
                formatter: val => `${val} location(s)`
            }
        },

        noData: {
            text: 'No locations found for the selected filters.',
            style: {
                color: '#94A3B8',
                fontSize: '14px',
            }
        }

    };

    chart = new ApexCharts(el, options);
    chart.render();
}

document.addEventListener('DOMContentLoaded', renderWifiChart);