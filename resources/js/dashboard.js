document.addEventListener('DOMContentLoaded', () => {

    const province = document.querySelector('#province_id');
    const status = document.querySelector('#status_id');
    const mapProvince = document.querySelector('#map_province_id');

    if (province) {
        new TomSelect(province, {
            create: false,
            allowEmptyOption: true,
            persist: false
        });
    }

    if (status) {
        new TomSelect(status, {
            create: false,
            allowEmptyOption: true,
            persist: false
        });
    }

    if (mapProvince) {
        new TomSelect(mapProvince, {
            create: false,
            allowEmptyOption: true,
            persist: false
        });
    }

});

