<!--suppress ALL -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="linear_chart_div" class="overflow-x-hidden overflow-y-hidden"></div>

<script>
    google.charts.load('current', {packages: ['corechart', 'line']});

    google.charts.setOnLoadCallback(drawAverageIncomesAndExpenditures);

    async function drawAverageExpenditures() {
        let expendituresData = new google.visualization.DataTable();
        expendituresData.addColumn('string', 'Day');
        expendituresData.addColumn('number', 'Average daily expenditures');

        await fetch("{{ route('api.report.avg_expenditures') }}", {
                headers: {
                    "Content-Type": "application/json",
                    'Accept-Type': 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                    'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                }
            }
        )
            .then(res => res.json())
            .then(json => {
                let rows = [];

                json.dataset.forEach(dayData => {
                    rows.push([
                        dayData.date.substring(5),
                        parseFloat(dayData.total)
                    ]);
                });

                expendituresData.addRows(rows);

                let options = {
                    hAxis: {
                        title: 'Days'
                    },
                    vAxis: {
                        title: 'Cash amount'
                    },
                    width: 550,
                    height: 300,
                    backgroundColor: 'rgba(241,248,233,0)'
                };

                let chart = new google.visualization.LineChart(document.getElementById('linear_chart_div'));
                chart.draw(expendituresData, options);
            });

    }

    async function drawAverageIncomesAndExpenditures() {
        let sumsData = new google.visualization.DataTable();

        sumsData.addColumn('string', 'Day');
        sumsData.addColumn('number', 'Average daily incomes');
        sumsData.addColumn('number', 'Average daily expenditures');

        let rows = [];

        const baseHeaders = {
            "Content-Type": "application/json",
            'Accept-Type': 'application/json',
            'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
            'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
        };

        const fetchIncomes = async () => {
            return fetch("{{ route('api.report.avg_incomes') }}", {
                    headers: baseHeaders
                }
            ).then(res => res.json());
        }

        const fetchExpenditures = async () => {
            return fetch("{{ route('api.report.avg_expenditures') }}", {
                    headers: baseHeaders
                }
            ).then(res => res.json());
        }

        const incomesDataset = await fetchIncomes();
        const expendituresDataset = await fetchExpenditures();

        incomesDataset.dataset.forEach((dayData, ix) => {
            console.log(dayData)
            console.log(expendituresDataset.dataset)
            rows.push([
                dayData.date.substring(5),
                parseFloat(dayData.total),
                // @todo - rm this hack
                expendituresDataset.dataset[ix] ? parseFloat(expendituresDataset.dataset[ix].total) : 0
            ]);
        });

        let options = {
            hAxis: {
                title: 'Days'
            },
            vAxis: {
                title: 'Cash amount'
            },
            width: 550,
            height: 300,
            backgroundColor: 'rgba(241,248,233,0)'
        };

        sumsData.addRows(rows);

        let chart = new google.visualization.LineChart(document.getElementById('linear_chart_div'));
        chart.draw(sumsData, options);
    }
</script>
