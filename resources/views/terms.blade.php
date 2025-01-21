@extends('layout')

@section('content')
<section class="terms-section">
    <div class="terms-container">
        <h1>{{ __('messages.terms_title') }}</h1>
        <p>{{ __('messages.terms_intro') }}</p>

        <h2>{{ __('messages.terms_usage_title') }}</h2>
        <p>{{ __('messages.terms_usage_description') }}</p>

        <h2>{{ __('messages.terms_liability_title') }}</h2>
        <p>{{ __('messages.terms_liability_description') }}</p>

        <h2>{{ __('messages.terms_modifications_title') }}</h2>
        <p>{{ __('messages.terms_modifications_description') }}</p>

        <h2>{{ __('messages.terms_law_title') }}</h2>
        <p>{{ __('messages.terms_law_description') }}</p>

        <h2>{{ __('messages.contact_title') }}</h2>
        <p>{!! __('messages.contact_terms', ['contact_url' => url('/#contact')]) !!}</p>
    </div>
</section>
@endsection
