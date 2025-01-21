@extends('layout')

@section('content')
    <div class="privacy-policy-container">
        <h1>{{ __('messages.privacy_policy_title') }}</h1>
        <p>{{ __('messages.privacy_policy_intro') }}</p>

        <h2>{{ __('messages.privacy_policy_section1_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section1_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section2_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section2_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section3_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section3_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section4_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section4_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section5_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section5_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section6_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section6_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section7_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section7_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section8_title') }}</h2>
        <p>{{ __('messages.privacy_policy_section8_text') }}</p>

        <h2>{{ __('messages.privacy_policy_section9_title') }}</h2>
        <p>{!! __('messages.privacy_policy_section9_text', ['contact_url' => url('/#contact')]) !!}</p>

    </div>
@endsection
