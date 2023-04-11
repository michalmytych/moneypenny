<div class="bg-white rounded-lg shadow-md overflow-hidden p-4 m-4 border">
    <h2 class="font-semibold text-3xl pl-4">
        Rekwizycja złożona {{ Carbon\Carbon::parse($requisition->created_at)->format('h:i d-m-Y') }}
    </h2>
    <div class="p-4">
        <a href="{{ $requisition->link }}" class="text-xl font-semibold text-indigo-600 hover:text-indigo-500">
            Potwierdź rekwizycję na stronie instytucji
        </a>
    </div>
    <div class="border-t border-gray-300 px-4 py-2 mx-2">
        <p class="text-gray-600 text-sm">ID: {{ $requisition->nordigen_requisition_id }}</p>
    </div>
</div>

