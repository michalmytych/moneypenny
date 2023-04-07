<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="analyzer_type">
                    Select analyzer
                </label>
                <select
                        id="analyzer_type"
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="analyzer_type">
                    <option selected>Select one</option>
                    @foreach($analyzers as $analyzerAlias)
                        <option value="{{ $analyzerAlias }}">
                            {{  Illuminate\Support\Str::of($analyzerAlias)->ucfirst()->replace('_', ' ')->toString()  }}
                        </option>
                    @endforeach
                </select>
            </div>

            <details>
                <summary>Pokaż wykres</summary>
                <div id="chart_div" style="overflow-x: scroll;">Pusto</div>
            </details>

            <details open>
                <summary>Pokaż dane</summary>
                <div id="container" style="overflow-x: scroll;">Pusto</div>
            </details>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function transformData(data) {
                    let result = [Object.keys(data[0])];
                    for (let i = 0; i < data.length; i++) {
                        let row = [];
                        for (let key in data[i]) {
                            let value = data[i][key];
                            if (typeof value === "string" && value.includes("-")) {
                                row.push(value);
                            } else if (!isNaN(parseFloat(value))) {
                                row.push(parseFloat(value));
                            } else {
                                row.push(value);
                            }
                        }
                        result.push(row);
                    }
                    return result;
                }

                function drawChart(_data) {
                    // Dane do wyświetlenia
                    _data = transformData(_data)
                    let data = google.visualization.arrayToDataTable(_data);
                    const chartDiv = document.getElementById('chart_div')

                    // Opcje wykresu
                    let options = {
                        width: 1400,
                        height: 400,
                        legend: { position: 'none' },
                        hAxis: {
                            title: _data[0][0]
                        },
                        vAxis: {
                            title: _data[0][1]
                        }
                    };

                    // Tworzenie i wyświetlanie wykresu słupkowego
                    chartDiv.innerHTML = '';
                    let chart = new google.visualization.ColumnChart(chartDiv);
                    chart.draw(data, options);
                }
            </script>

            <script>
                const analyzerTypeSelect = document.getElementById('analyzer_type');
                const container = document.getElementById("container");

                function displayObject(obj, element) {
                    const pre = document.createElement("pre");
                    const code = document.createElement("code");
                    pre.appendChild(code);
                    element.appendChild(pre);

                    code.textContent = JSON.stringify(obj, null, 2);
                }

                analyzerTypeSelect.addEventListener('change', () => {
                    const data = {analyzer_type: analyzerTypeSelect.value};
                    container.innerHTML = '';

                    fetch("{{ route('api.analysis') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                'Accept-Type': 'application/json',
                            },
                            body: JSON.stringify(data)
                        }
                    )
                        .then(res => res.json())
                        .then(json => {
                            try {
                                drawChart(json)
                            } catch (e) {}
                            displayObject(json, container)
                        })
                });
            </script>

        </div>
    </div>
</x-guest-layout>
