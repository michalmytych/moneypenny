@if(count($institutions) > 0)
    <style>
        .hoverScaleBox {
            transition: 0.4s;
        }

        .hoverScaleBox:hover {
            cursor: pointer;
            transform: scale(1.05);
        }
    </style>

    <h2 class="font-semibold text-4xl pb-6">Obsługiwane instytucje</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        @foreach ($institutions as $institution)
            <a href="{{ route('institution.select', ['id' =>$institution->id]) }}" class="hoverScaleBox">
                @include('nordigen.institution.partials.single', ['institution' => $institution])
            </a>
        @endforeach
    </div>
@else
    <h2 class="font-semibold text-xl">Brak instytucji</h2>
@endif
