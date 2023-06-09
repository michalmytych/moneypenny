export const debugError = (data, response) => {
    const debugError = document.getElementById('debugError');
    const responseStatus = debugError.querySelector('.responseStatus');
    const responseData = debugError.querySelector('.responseData');
    const debugErrorClose = debugError.querySelector('.debugErrorClose');
    const responseURL = debugError.querySelector('.responseURL');

    if (debugError.style.top === '-10rem') {
        debugError.style.top = '4.5rem';
    }

    debugErrorClose.addEventListener('click', () => {
        debugError.style.top = '-10rem';
    });

    responseData.innerHTML = typeof data === "string" ? data : JSON.stringify(data);
    responseStatus.innerHTML = response.status;
    responseURL.innerHTML = response.url;
}
