<form action="{{ route('transaction.patch', ['id' => $transaction->id]) }}" method="POST" id="categoryForm">
    @csrf
    @method('PATCH')
    <select name="category_id" id="category_id" class="appearance-none border rounded py-2 px-3 w-2/3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <option selected>Assign category</option>
        {{--@todo --- wtf!!!!!--}}
        @foreach(\App\Models\Transaction\Category::orderBy('code')->get() as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</form>
