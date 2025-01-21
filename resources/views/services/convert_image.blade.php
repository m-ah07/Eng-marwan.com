@extends('layout')

@section('content')
    <div class="content-container">
        <!-- SEO and Informative Content -->
        <section class="seo-content">
            <h2>{{ __('messages.image_conversion_about_title') }}</h2>
            <p>{{ __('messages.image_conversion_about_description') }}</p>

            <h3>{{ __('messages.image_conversion_why_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.image_conversion_why_1_strong') }}</strong>
                    {{ __('messages.image_conversion_why_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.image_conversion_why_2_strong') }}</strong>
                    {{ __('messages.image_conversion_why_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.image_conversion_why_3_strong') }}</strong>
                    {{ __('messages.image_conversion_why_3_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.image_conversion_features_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.image_conversion_features_1_strong') }}</strong>
                    {{ __('messages.image_conversion_features_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.image_conversion_features_2_strong') }}</strong>
                    {{ __('messages.image_conversion_features_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.image_conversion_features_3_strong') }}</strong>
                    {{ __('messages.image_conversion_features_3_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.image_conversion_features_4_strong') }}</strong>
                    {{ __('messages.image_conversion_features_4_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.image_conversion_how_title') }}</h3>
            <ol>
                <li>{{ __('messages.image_conversion_how_1') }}</li>
                <li>{{ __('messages.image_conversion_how_2') }}</li>
                <li>{{ __('messages.image_conversion_how_3') }}</li>
            </ol>

            <h3>{{ __('messages.image_conversion_use_cases_title') }}</h3>
            <ul>
                <li>{{ __('messages.image_conversion_use_cases_1') }}</li>
                <li>{{ __('messages.image_conversion_use_cases_2') }}</li>
                <li>{{ __('messages.image_conversion_use_cases_3') }}</li>
                <li>{{ __('messages.image_conversion_use_cases_4') }}</li>
            </ul>
        </section>

        <div class="image-converter-section">
            <!-- Title and Description -->
            <h1 class="form-title">{{ __('messages.image_conversion_form_title') }}</h1>
            <p class="form-description">{{ __('messages.image_conversion_form_description') }}</p>

            <!-- Form -->
            <form action="/convert-image" method="POST" enctype="multipart/form-data" class="image-converter-form">
                @csrf
                <div class="form-group">
                    <label for="image">{{ __('messages.image_conversion_form_label_image') }}</label>
                    <div class="file-drop-zone" id="fileDropZone">
                        <input type="file" name="image" id="image" class="form-input" required>
                        <p id="fileName">{{ __('messages.image_conversion_form_drag_text') }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="format">{{ __('messages.image_conversion_form_label_format') }}</label>
                    <select name="format" id="format" class="form-select" required>
                        <option value="png">{{ __('messages.image_conversion_form_option_png') }}</option>
                        <option value="jpeg">{{ __('messages.image_conversion_form_option_jpeg') }}</option>
                        <option value="gif">{{ __('messages.image_conversion_form_option_gif') }}</option>
                        <option value="bmp">{{ __('messages.image_conversion_form_option_bmp') }}</option>
                    </select>
                </div>

                <div class="button-container">
                    <button type="submit" id="convertButton"
                        class="form-button btn">{{ __('messages.image_conversion_form_button') }}</button>
                    <div id="loader" class="loader hidden"></div>
                </div>
            </form>
        </div>
    </div>

    <!-- Drag & Drop Script -->
    <script>
        const dropZone = document.getElementById('fileDropZone');
        const fileInput = document.getElementById('image');
        const fileNameDisplay = document.getElementById('fileName');

        // Handle dragover event
        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault(); // Prevent default behavior
            dropZone.classList.add('dragover');
        });

        // Handle dragleave event
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        // Handle drop event
        dropZone.addEventListener('drop', (event) => {
            event.preventDefault(); // Prevent default behavior
            dropZone.classList.remove('dragover');

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files; // Assign dropped files to input
                fileNameDisplay.textContent = files[0].name; // Display file name
            }
        });

        // Handle change event for file input (in case the user clicks to select a file)
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name; // Display file name
            }
        });
    </script>
@endsection
