import './bootstrap';

import {drawCharts} from "./drawCharts";
import {logoutApi} from "./logoutApi";
import {getCookie} from "./getCookie";

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.getCookie = drawCharts;
window.getCookie = getCookie;
window.logoutApi = logoutApi;

Alpine.start();
