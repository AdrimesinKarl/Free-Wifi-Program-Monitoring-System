let chart;

function cleanYAxis(safeMax) {

    if (safeMax <= 5) {
        return {
            max: safeMax + 1,
            tickAmount: safeMax + 1
        };
    }

    const steps = [1, 2, 5, 10, 20, 50, 100, 500];

    for (const step of steps) {

        const tickAmount = Math.ceil(safeMax / step) + 1;

        if (tickAmount <= 8) {
            return {
                max: tickAmount * step,
                tickAmount
            };
        }
    }

    return {
        max: Math.ceil(safeMax * 1.2),
        tickAmount: 6
    };
}


function renderWifiChart() {

    const el = document.querySelector('#locationChart');

    if (!el) return;


    let chartData = [];

    try {

        const raw = JSON.parse(el.dataset.chart || '[]');

        chartData = Array.isArray(raw)
            ? raw
            : [];

    } catch (error) {

        console.error('Chart data error:', error);

        return;
    }



    const categories = chartData.map(item => item.label ?? '');

    const counts = chartData.map(item => {

        const value = Number(item.count);

        return Number.isFinite(value)
            ? Math.round(value)
            : 0;

    });



    // Province = horizontal
    // Municipality = vertical
    const isHorizontal = el.dataset.type === 'province';



    const safeMax = counts.length
        ? Math.max(...counts)
        : 0;



    const {
        max: yAxisMax,
        tickAmount
    } = cleanYAxis(safeMax);



    if (chart) {

        chart.destroy();

        chart = null;

    }



    const options = {

        chart: {

            type: 'bar',

            height: isHorizontal
                ? Math.max(360, categories.length * 45)
                : 360,


            toolbar: {
                show: false
            },


            fontFamily: 'inherit',


            animations: {

                enabled: true,

                speed: 400

            },


            background: 'transparent'

        },



        series: [

            {

                name: 'Locations',

                data: counts

            }

        ],



        colors: ['#7C3AED'],



        plotOptions: {

            bar: {

                horizontal: isHorizontal,


                borderRadius: 8,


                columnWidth: '45%',


                barHeight: '55%'

            }

        },



        dataLabels: {

            enabled: false

        },



        xaxis: {

            categories,


            labels: {

                rotate: isHorizontal
                    ? 0
                    : (categories.length > 6 ? -45 : 0),


                trim: false,


                style: {

                    colors: '#334155',

                    fontSize: '12px',

                    fontWeight: 500

                }

            },


            axisBorder: {

                show: false

            },


            axisTicks: {

                show: false

            }

        },



        yaxis: {

            min: 0,


            max: isHorizontal
                ? undefined
                : yAxisMax,


            tickAmount: isHorizontal
                ? undefined
                : tickAmount,


            labels: {

                formatter: function(val) {

                    return Number.isInteger(val)
                        ? val
                        : '';

                },


                style: {

                    colors: '#94A3B8',

                    fontSize: '12px'

                }

            }

        },



        grid: {

            borderColor: '#F1F5F9',

            strokeDashArray: 4

        },



        tooltip: {

            theme: 'light',

            y: {

                formatter: function(val) {

                    return `${val} location(s)`;

                }

            }

        },



        noData: {

            text: 'No locations found for the selected filters.',

            style: {

                color: '#94A3B8',

                fontSize: '14px'

            }

        }

    };



    chart = new ApexCharts(el, options);

    chart.render();

}



document.addEventListener(
    'DOMContentLoaded',
    renderWifiChart
);