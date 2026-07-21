import ApexCharts from 'apexcharts';
import TomSelect from 'tom-select';
import L from 'leaflet';

import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

window.ApexCharts = ApexCharts;
window.TomSelect = TomSelect;

L.Marker.prototype.options.icon = L.icon({
    iconUrl: markerIcon,
    shadowUrl: markerShadow
})

window.L = L;

import './dashboard';
import './map/map';