<h2 class="font-semibold text-4xl pb-6">Złożone zgody</h2>
<div class="grid grid-cols-2 md:grid-cols-3 sm:grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
    @foreach ($agreements as $agreement)
        @php
            /**
             * @var array $institutions
             * @var \App\Models\Nordigen\EndUserAgreement $agreement
             */
            $institution = collect($institutions)->filter(
                fn($institution) => $institution->id === $agreement->nordigen_institution_id
            )->first();
        @endphp
        @include('nordigen.end_user_agreements.partials.single', ['agreement' => $agreement, 'institution' => $institution])
    @endforeach
</div>
