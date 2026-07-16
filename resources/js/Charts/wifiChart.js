let chart;

function renderWifiChart() {

    const el = document.querySelector('#locationChart');
    if (!el) return;

    const chartData = JSON.parse(el.dataset.chart);

    const categories = chartData.map(d => d.label);
    const counts = chartData.map(d => d.count);

    const isDark = document.documentElement.classList.contains('dark');

    // Switch to horizontal when many locations
    const isHorizontal = categories.length > 6;


    const maxValue = Math.max(...counts);
    const yAxisMax = maxValue + Math.max(Math.ceil(maxValue * 0.25), 2);


    // Remove old chart before redraw
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


        theme: {
            mode: isDark ? 'dark' : 'light',
        },


        series: [
            {
                name: 'Locations',
                data: counts,
            }
        ],


        plotOptions: {

            bar: {

                horizontal: isHorizontal,

                borderRadius: 8,

                columnWidth: '45%',

                barHeight: '55%',
            }

        },


        // Remove numbers on bars
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

                    colors: isDark
                        ? '#94A3B8'
                        : '#64748B',
                },

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

                    colors: isDark
                        ? '#94A3B8'
                        : '#64748B',

                    fontSize: '12px',
                },

            },

        },


        colors: [

            isDark
                ? '#A78BFA'
                : '#7C3AED'

        ],


        grid: {

            borderColor: isDark
                ? '#1E293B'
                : '#EDE9FE',

            strokeDashArray: 4,

        },


        tooltip: {

            theme: isDark
                ? 'dark'
                : 'light',

            y: {

                formatter: val =>
                    val + ' location(s)',

            },

        },


        noData: {

            text: 'No locations found for the selected filters.',

            style: {

                color: '#94A3B8',

                fontSize: '14px',

            },

        },


    };


    chart = new ApexCharts(el, options);

    chart.render();

}


// Initial render
document.addEventListener(
    'DOMContentLoaded',
    renderWifiChart
);


// Redraw after dark/light toggle
window.addEventListener(
    'themeChanged',
    renderWifiChart
);