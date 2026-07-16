import ApexCharts from 'apexcharts';
import TomSelect from 'tom-select';

window.ApexCharts = ApexCharts;
window.TomSelect = TomSelect;


    // Load saved theme first
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }

    const themeToggle = document.getElementById('theme-toggle');

    if (themeToggle) {

        themeToggle.addEventListener('click', () => {

            document.documentElement.classList.toggle('dark');

            const isDark = document.documentElement.classList.contains('dark');

            localStorage.setItem(
                'theme',
                isDark ? 'dark' : 'light'
            );

            window.dispatchEvent(new Event('themeChanged'));

        });

    }

import './dashboard';