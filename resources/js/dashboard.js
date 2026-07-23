document.addEventListener('DOMContentLoaded', () => {
    const selects = [
        '#region_id',
        '#province_id',
        '#status_id',
        '#map_province_id'
    ];

    selects.forEach(selector => {
        const element = document.querySelector(selector);

        if (!element) return;

        // Prevent duplicate TomSelect initialization
        if (element.tomselect) return;

        const tom = new TomSelect(element, {
            create: false,
            allowEmptyOption: true,
            persist: false,
            controlInput: null
        });

        tom.on('change', function (value) {
            // Update original select value
            element.value = value;

            // Submit form automatically
            const form = element.closest('form');

            if (form) {
                form.submit();
            }
        });
    });
});