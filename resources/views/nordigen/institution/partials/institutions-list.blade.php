@if(count($institutions) > 0)
    <h2 class="font-bold text-3xl pb-6">{{ __('Supported integrations') }}</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        @foreach ($institutions as $institution)
            <a href="{{ route('institution.select', ['id' =>$institution->id]) }}" class="hoverScaleBox">
                @include('nordigen.institution.partials.single', ['institution' => $institution])
            </a>
        @endforeach
    </div>
@else
    <h2 class="font-semibold text-xl">{{ __('No supported integrations') }}</h2>
@endif
