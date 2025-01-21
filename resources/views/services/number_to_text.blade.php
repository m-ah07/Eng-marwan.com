@extends('layout')

@section('content')
    <div class="content-container">
        <!-- SEO and Informative Content -->
        <section class="seo-content">
            <h2>{{ __('messages.tafqit_about_title') }}</h2>
            <p>{{ __('messages.tafqit_about_description') }}</p>

            <h3>{{ __('messages.tafqit_why_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.tafqit_why_1_strong') }}</strong>
                    {{ __('messages.tafqit_why_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.tafqit_why_2_strong') }}</strong>
                    {{ __('messages.tafqit_why_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.tafqit_why_3_strong') }}</strong>
                    {{ __('messages.tafqit_why_3_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.tafqit_features_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.tafqit_features_1_strong') }}</strong>
                    {{ __('messages.tafqit_features_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.tafqit_features_3_strong') }}</strong>
                    {{ __('messages.tafqit_features_3_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.tafqit_features_4_strong') }}</strong>
                    {{ __('messages.tafqit_features_4_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.tafqit_features_5_strong') }}</strong>
                    {{ __('messages.tafqit_features_5_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.tafqit_how_title') }}</h3>
            <p>{{ __('messages.tafqit_how_description') }}</p>

            <h3>{{ __('messages.tafqit_use_cases_title') }}</h3>
            <ul>
                <li>{{ __('messages.tafqit_use_case_1') }}</li>
                <li>{{ __('messages.tafqit_use_case_2') }}</li>
                <li>{{ __('messages.tafqit_use_case_3') }}</li>
            </ul>

            <div class="cta-section">
                <p>{{ __('messages.tafqit_cta_text') }}</p>
                <a href="#tafqitForm" class="cta-button">{{ __('messages.tafqit_cta_button') }}</a>
            </div>
        </section>



        <div class="tafqit-form-section">
            <h1 class="form-title">{{ __('messages.tafqit_form_title') }}</h1>
            <p class="form-description">{{ __('messages.tafqit_form_description') }}</p>

            <form id="tafqitForm" class="tafqit-form">
                @csrf
                <div class="form-group">
                    <label>{{ __('messages.tafqit_form_select_type') }}</label>
                    <div class="button-group">
                        <button type="button" id="normalTafqit" class="form-button tafqit-type active">
                            {{ __('messages.tafqit_form_normal') }}
                        </button>
                        <button type="button" id="currencyTafqit" class="form-button tafqit-type">
                            {{ __('messages.tafqit_form_currency') }}
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="number">{{ __('messages.tafqit_form_number_label') }}</label>
                    <input type="number" name="number" id="number" class="form-input" required>
                </div>

                <div id="currencyOptions" class="currency-options" style="display: none;">
                    <label for="subunit">{{ __('messages.tafqit_form_subunit_label') }}</label>
                    <input type="number" name="subunit" id="subunit" class="form-input" placeholder="0">
                </div>

                <button type="submit" class="form-button submit-button">{{ __('messages.tafqit_form_submit') }}</button>
            </form>

            <div id="tafqitResult" class="result-container" style="display: none;">
                <label>{{ __('messages.tafqit_form_result_label') }}</label>
                <div class="result-box">
                    <span id="resultText"></span>
                    <button id="copyResultButton" class="copy-button">
                        <i class="fa-solid fa-copy"></i> {{ __('messages.tafqit_form_copy_button') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('tafqitForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('tafqitType', document.querySelector('.tafqit-type.active').id === 'currencyTafqit' ?
                'currency' : 'normal');

            fetch('/convert-number', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                if (data.text) {
                    document.getElementById('resultText').textContent = data.text;
                    document.getElementById('tafqitResult').style.display = 'block';
                } else {
                    alert('Error during tafqit process.');
                }
            }).catch(err => console.error(err));
        });

        document.getElementById('normalTafqit').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('currencyTafqit').classList.remove('active');
            document.getElementById('currencyOptions').style.display = 'none';
        });

        document.getElementById('currencyTafqit').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('normalTafqit').classList.remove('active');
            document.getElementById('currencyOptions').style.display = 'block';
        });

        // Function to copy the result to clipboard
        document.getElementById('copyResultButton').addEventListener('click', function() {
            const resultText = document.getElementById('resultText').textContent;

            // Create a temporary textarea to hold the text
            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = resultText;
            document.body.appendChild(tempTextArea);

            // Select the text and copy to clipboard
            tempTextArea.select();
            document.execCommand('copy');

            // Remove the temporary textarea
            document.body.removeChild(tempTextArea);

            // Notify the user
            alert('Result copied to clipboard!');
        });
    </script>
@endsection
