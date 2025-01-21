@extends('layout')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <h1>{{ __('messages.hero_title', ['name' => 'Eng MARWAN']) }}</h1>
            <p>{{ __('messages.hero_subtitle') }}</p>
            <div class="social-links">
                <a href="https://github.com/marwan-ahmed-23" target="_blank" rel="noopener noreferrer"><i
                        class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/marwan-ah" target="_blank" rel="noopener noreferrer"><i
                        class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-container">
            <img src="{{ asset('images/about-image.jpeg') }}" alt="about image">
            <div class="about-content">
                <h1>{{ __('messages.about_title') }}</h1>
                <p>{{ __('messages.about_description') }}</p>
            </div>
        </div>
    </section>

    <!-- Consulting Requests Section -->
    <section class="consulting-requests" id="consulting-requests">
        <div class="consulting-requests-text">
            <h1>{{ __('messages.consulting_title') }}</h1>
            <p>{!! __('messages.consulting_description', ['contact_url' => url('/#contact')]) !!}</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="services-title">
            <h1>{{ __('messages.services_title') }}</h1>
            <p>{{ __('messages.services_description') }}</p>
        </div>

        <a href="{{ url('/convert-image') }}" class="service">
            <h2>{{ __('messages.image_converter_title') }}</h2>
            <p>{{ __('messages.image_converter_description') }}</p>
            <p><strong>{{ __('messages.usage_count') }}:</strong> {{ $serviceCounters['image_converter'] ?? 0 }}</p>
        </a>

        <a href="{{ url('/number-to-text') }}" class="service">
            <h2>{{ __('messages.number_spelling_title') }}</h2>
            <p>{{ __('messages.number_spelling_description') }}</p>
            <p><strong>{{ __('messages.usage_count') }}:</strong> {{ $serviceCounters['number_to_text'] ?? 0 }}</p>
        </a>

        <a href="{{ url('/merge-images') }}" class="service">
            <h2>{{ __('messages.combine_images_title') }}</h2>
            <p>{{ __('messages.combine_images_description') }}</p>
            <p><strong>{{ __('messages.usage_count') }}:</strong> {{ $serviceCounters['merge_images'] ?? 0 }}</p>
        </a>

        <a href="{{ url('/text-analysis') }}" class="service">
            <h2>{{ __('messages.text_analysis_title') }}</h2>
            <p>{{ __('messages.text_analysis_description') }}</p>
            <p><strong>{{ __('messages.usage_count') }}:</strong> {{ $serviceCounters['text_analysis'] ?? 0 }}</p>
        </a>

        <a href="{{ url('/convert-pdf-to-images') }}" class="service">
            <h2>{{ __('messages.pdf_to_image_title') }}</h2>
            <p>{{ __('messages.pdf_to_image_description') }}</p>
            <p><strong>{{ __('messages.usage_count') }}:</strong> {{ $serviceCounters['pdf_to_image'] ?? 0 }}</p>
        </a>
    </section>




    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="contact-title">
            <h1>{{ __('messages.contact_title') }}</h1>
            <p>{{ __('messages.contact_description') }}</p>
        </div>
        <div class="contact-container">
            <div class="contact-box">
                <i class="fa-solid fa-envelope"></i>
                <h2>{{ __('messages.contact_email_title') }}</h2>
                <p>{{ __('messages.email_1') }}</p>
            </div>
        </div>
    </section>
@endsection
