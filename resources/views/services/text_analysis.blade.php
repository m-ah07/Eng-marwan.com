@extends('layout')

@section('content')
    <div class="content-container">
        <!-- SEO and Informative Content -->
        <section class="seo-content">
            <h2>{{ __('messages.text_analysis_about_title') }}</h2>
            <p>{{ __('messages.text_analysis_about_description') }}</p>

            <h3>{{ __('messages.text_analysis_why_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.text_analysis_why_1_strong') }}</strong>
                    {{ __('messages.text_analysis_why_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.text_analysis_why_2_strong') }}</strong>
                    {{ __('messages.text_analysis_why_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.text_analysis_why_3_strong') }}</strong>
                    {{ __('messages.text_analysis_why_3_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.text_analysis_features_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.text_analysis_features_1_strong') }}</strong>
                    {{ __('messages.text_analysis_features_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.text_analysis_features_2_strong') }}</strong>
                    {{ __('messages.text_analysis_features_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.text_analysis_features_3_strong') }}</strong>
                    {{ __('messages.text_analysis_features_3_text') }}
                </li>
            </ul>
        </section>

        <!-- Text Analysis Form Section -->
        <div class="text-analysis-section">
            <h1 class="form-title">{{ __('messages.text_analysis_form_title') }}</h1>
            <p class="form-description">{{ __('messages.text_analysis_form_description') }}</p>

            <form id="textAnalysisForm" class="text-analysis-form">
                @csrf
                <div class="form-group">
                    <label for="text">{{ __('messages.text_analysis_form_title') }}</label>
                    <textarea name="text" id="text" rows="6" class="form-input"
                        placeholder="{{ __('messages.text_analysis_form_placeholder') }}" required></textarea>
                </div>
                <button type="submit" class="form-button">{{ __('messages.text_analysis_form_button') }}</button>
            </form>

            <div id="analysisResult" class="result-container" style="display: none;">
                <p>{{ __('messages.text_analysis_result_word_count') }} <span id="wordCount"></span></p>
                <p>{{ __('messages.text_analysis_result_char_count_no_spaces') }} <span id="characterCountNoSpaces"></span>
                </p>
                <p>{{ __('messages.text_analysis_result_char_count_with_spaces') }} <span
                        id="characterCountWithSpaces"></span></p>
                <p>{{ __('messages.text_analysis_result_space_count') }} <span id="spaceCount"></span></p>
                <p>{{ __('messages.text_analysis_result_line_breaks') }} <span id="enterCount"></span></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('textAnalysisForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            fetch('/analyze-text', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.word_count !== undefined) {
                        document.getElementById('wordCount').textContent = data.word_count;
                        document.getElementById('characterCountNoSpaces').textContent = data
                            .character_count_no_spaces;
                        document.getElementById('characterCountWithSpaces').textContent = data
                            .character_count_with_spaces;
                        document.getElementById('spaceCount').textContent = data.space_count;
                        document.getElementById('enterCount').textContent = data.enter_count;
                        document.getElementById('analysisResult').style.display = 'block';
                    } else {
                        alert('{{ __('messages.text_analysis_error') }}');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
