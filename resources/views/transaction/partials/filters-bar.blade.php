<div class="w-full mb-6">
    <h2 class="text-black font-bold text-xl pb-3">
        {{ __('Filter transactions') }}
    </h2>
    <form action="{{ $route }}" method="GET">
        <div class="flex items-center" id="filters-box-0">
            <select name="column" id="column" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md w-full shadow-sm mt-1 mr-2">
                <option>Select attribute</option>
                @foreach($filterableColumns->keys() as $column)
                    <option value="{{ $column }}">
                        {{ \Illuminate\Support\Str::of($column)->ucfirst()->replace('_', ' ') }}
                    </option>
                @endforeach
            </select>

            <select name="operator" id="operator" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md w-full shadow-sm mt-1 mr-2">
                <option>Select operator</option>
            </select>

            <input
                    name="value"
                    id="value"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md w-full shadow-sm mt-1 mr-2"
                    type="text"
                    placeholder="Attribute value"
                    autocomplete="off"
            />

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-8 rounded-md py-2 mt-[4px]">
                Apply
            </button>
        </div>
    </form>
</div>

<script>
    const columnSelect = document.getElementById('column');
    const operatorSelect = document.getElementById('operator');
    const attrValueInput = document.getElementById('value');
    const filterableColumns = JSON.parse('{!! json_encode($filterableColumns) !!}');

    const emptyOption = '<option>Select operator</option>';

    const operatorsMapping = {
        gt: '<option value="gt">Większe od</option>',
        lt: '<option value="lt">Mniejsze od</option>',
        gte: '<option value="gte">Większe lub równe od</option>',
        lte: '<option value="lte">Mniejsze lub równe od</option>',
        eq: '<option value="eq">Równe</option>',
        starts: '<option value="starts">Zaczyna się na</option>',
        ends: '<option value="ends">Kończy się na</option>',
        contains: '<option value="contains">Zawiera</option>'
    }

    function setSelectedOptionByIndex(selectElement, ix = 0) {
        console.log(selectElement.options)
        selectElement.selectedIndex = ix;
        selectElement.options[ix].selected = true;
    }

    const clearOperators = () => operatorSelect.innerHTML = emptyOption;

    const setValidOperators = () => {
        const attribute = columnSelect.value;
        let operators = [];
        let inputType = 'text';

        try {
            operators = filterableColumns[attribute].operators;
            inputType = filterableColumns[attribute].input;
        } catch (e) {
            console.error('Invalid filterableColumns value: ');
            console.log(filterableColumns);
            throw e;
        }

        if (operators.length > 0) {
            operators.forEach((operatorAlias) => {
                const optionCode = operatorsMapping[operatorAlias];
                operatorSelect.innerHTML = operatorSelect.innerHTML + optionCode;
            });
            setSelectedOptionByIndex(operatorSelect);
        }

        if (inputType) {
            attrValueInput.value = null;
            attrValueInput.type = inputType;
        }
    }

    function setFormValuesFromUrlParams(url) {
        const urlParams = new URLSearchParams(url);
        const column = urlParams.get('column');
        const operator = urlParams.get('operator');
        const value = urlParams.get('value');

        if (!column || !operator) {
            return;
        }

        columnSelect.value = column;
        setValidOperators();
        operatorSelect.value = operator;
        attrValueInput.value = value;
    }

    columnSelect.addEventListener('change', () => {
        clearOperators();
        setValidOperators();
    });

    window.addEventListener('load', () => {
        setFormValuesFromUrlParams(window.location.search);
    });
</script>
