document.addEventListener('DOMContentLoaded', function () {
    const el = document.querySelector('#locationChart');
    if (!el) return;
    
    const chartData  = JSON.parse(el.dataset.chart);
    const categories = chartData.map(d => d.label);
    const counts     = chartData.map(d => d.count);

    const isCrowded    = categories.length > 8;
    const isOverloaded = categories.length > 12;

    // ← fix: calculate before options
    const maxValue = Math.max(...counts);
    const yAxisMax = maxValue + Math.max(Math.ceil(maxValue * 0.25), 2);

    const options = {
        chart: {
            type: 'bar',
            height: isOverloaded ? Math.max(360, categories.length * 36) : 360,
            toolbar: { show: false },
            fontFamily: 'inherit',
            animations: { enabled: true, speed: 400 },
        },
        series: [{
            name: 'Locations',
            data: counts,
        }],
        plotOptions: {
            bar: {
                horizontal: isOverloaded,
                borderRadius: 4,
                columnWidth: categories.length <= 4 ? '30%' : '55%',
                barHeight: '60%',
                dataLabels: { position: 'top' },
            },
        },
        dataLabels: {
            enabled: !isCrowded,
            offsetY: -25,
            offsetX: isOverloaded ? 5 : 0,
            style: {
                fontSize: '11px',
                fontWeight: '600',
                colors: ['#374151'],
            },
            formatter: val => val === 0 ? '' : val,
        },
        xaxis: {
            categories: categories,
            labels: {
                style: { fontSize: '12px', colors: '#6B7280' },
                rotate: isCrowded && !isOverloaded ? -40 : 0,
                trim: true,
                maxHeight: 80,
            },
            axisBorder: { show: false },
            axisTicks:  { show: false },
        },
        yaxis: {
            max: yAxisMax,    // ← plain number now, not a function
            labels: {
                formatter: val => Math.round(val),
                style: { colors: '#9CA3AF', fontSize: '12px' },
            },
        },
        colors: ['#10b981'],
        grid: {
            borderColor: '#F3F4F6',
            strokeDashArray: 4,
            yaxis: { lines: { show: !isOverloaded } },
            xaxis: { lines: { show: isOverloaded  } },
        },
        tooltip: {
            y: { formatter: val => val + ' location(s)' },
        },
        noData: {
            text: 'No locations found for the selected filters.',
            style: { color: '#9CA3AF', fontSize: '14px' },
        },
    };

    new ApexCharts(el, options).render();
});