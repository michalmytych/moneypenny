import Chart from 'chart.js/auto';

const fadeOutElement = (element) => {
    element.classList.add('fade-out-sm');

    setInterval(() => {
        element.style.display = 'none';
    }, 600);
}

const drawChart = (chartContextElementId) => {
    const chartContextElement = document.getElementById(chartContextElementId);
    const chartSkeleton = document.getElementById(`${chartContextElementId}Skeleton`);
    const chartRoute = chartContextElement.dataset.route;

    fetch(chartRoute, {
            headers: {
                "Content-Type": "application/json",
                'Accept-Type': 'application/json',
                'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
            },
        }
    )
        .then(response => response.json())
        .then(json => {
            fadeOutElement(chartSkeleton);
            new Chart(chartContextElement, json.config);
        });
}

export const drawCharts = (chartContextsIds) => {
    chartContextsIds.forEach((contextId) => {
        drawChart(contextId)
    });
}
