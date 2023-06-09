import './bootstrap';

import {drawCharts} from "./drawCharts";
import {logoutApi} from "./logoutApi";
import {getCookie} from "./getCookie";
import {debugError} from "./debugError";

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.drawCharts = drawCharts;
window.getCookie = getCookie;
window.logoutApi = logoutApi;
window.debugError = debugError;

const {fetch: originalFetch} = window;

/**
 * DEBUG @todo - only in debug
 */
window.fetch = async (...args) => {
    let [resource, config] = args;

    const response = await originalFetch(resource, config);

    response
        .clone()
        .json()
        .catch(reason => debugError(reason, response));


    return response;
};
/**
 * DEBUG @todo - only in debug
 */

Alpine.start();
