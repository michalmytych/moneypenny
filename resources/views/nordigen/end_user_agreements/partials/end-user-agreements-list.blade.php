<h2 class="font-semibold text-4xl pb-6">
    {{ __('Active integrations') }}
</h2>
<div class="grid grid-cols-1 gap-4 mb-8">
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
