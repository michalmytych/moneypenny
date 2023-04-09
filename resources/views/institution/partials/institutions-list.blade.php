<style>
    .hoverScaleBox {
        transition: 0.4s;
    }

    .hoverScaleBox:hover{
        cursor: pointer;
        transform: scale(1.05);
    }
</style>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
    @foreach ($institutions as $institution)
        <a href="{{ route('institution.select', ['id' =>$institution->id]) }}" class="hoverScaleBox">
            @include('institution.partials.single', ['institution' => $institution])
        </a>
    @endforeach
</div>
