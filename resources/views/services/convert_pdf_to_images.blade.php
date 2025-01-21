@extends('layout')

@section('content')
    <div class="content-container">
        <!-- SEO and Informative Content -->
        <section class="seo-content">
            <h2>{{ __('messages.pdf_to_images_about_title') }}</h2>
            <p>{{ __('messages.pdf_to_images_about_description') }}</p>

            <h3>{{ __('messages.pdf_to_images_why_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.pdf_to_images_why_1_strong') }}</strong>
                    {{ __('messages.pdf_to_images_why_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.pdf_to_images_why_2_strong') }}</strong>
                    {{ __('messages.pdf_to_images_why_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.pdf_to_images_why_3_strong') }}</strong>
                    {{ __('messages.pdf_to_images_why_3_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.pdf_to_images_features_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.pdf_to_images_features_1_strong') }}</strong>
                    {{ __('messages.pdf_to_images_features_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.pdf_to_images_features_2_strong') }}</strong>
                    {{ __('messages.pdf_to_images_features_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.pdf_to_images_features_3_strong') }}</strong>
                    {{ __('messages.pdf_to_images_features_3_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.pdf_to_images_features_4_strong') }}</strong>
                    {{ __('messages.pdf_to_images_features_4_text') }}
                </li>
            </ul>
        </section>

        <!-- PDF to Images Form Section -->
        <div class="convert_pdf_to_images-section">
            <h1 class="form-title">{{ __('messages.pdf_to_images_form_title') }}</h1>
            <p class="form-description">{{ __('messages.pdf_to_images_form_description') }}</p>

            <form id="pdfForm" enctype="multipart/form-data" class="convert-pdf-form">
                @csrf
                <div class="file-drop-zone" id="fileDropZone">
                    <input type="file" name="pdf" id="pdf" class="form-input" accept=".pdf" required>
                    <p id="fileName">{{ __('messages.pdf_to_images_form_drag_text') }}</p>
                </div>
                <div class="button-container">
                    <button type="submit" id="convertButton"
                        class="form-button btn">{{ __('messages.pdf_to_images_form_button') }}</button>
                    <div id="loader" class="loader hidden"></div>
                </div>
            </form>

            <div id="downloadLinkContainer" class="download-container" style="display: none;">
                <p>{{ __('messages.pdf_to_images_result_success') }}</p>
                <a href="#" id="downloadLink" class="download-link"
                    download>{{ __('messages.pdf_to_images_result_download') }}</a>
            </div>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('fileDropZone');
        const fileInput = document.getElementById('pdf');
        const fileNameDisplay = document.getElementById('fileName');
        const loader = document.getElementById('loader');
        const convertButton = document.getElementById('convertButton');
        const downloadLinkContainer = document.getElementById('downloadLinkContainer');
        const downloadLink = document.getElementById('downloadLink');

        // Drag & Drop Events
        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropZone.classList.remove('dragover');

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type === 'application/pdf') {
                    fileInput.files = files; // Assign dropped file to the input
                    fileNameDisplay.textContent = "{{ __('messages.pdf_to_images_file_loaded') }}".replace(':name',
                        file.name);
                } else {
                    alert('{{ __('messages.pdf_to_images_file_error') }}');
                }
            }
        });

        // Form Submission
        document.getElementById('pdfForm').addEventListener('submit', function(event) {
            event.preventDefault();
            loader.classList.remove('hidden'); // Show loader
            convertButton.disabled = true; // Disable button to prevent multiple submissions

            let formData = new FormData(this);

            fetch('/convert-pdf-to-images', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loader.classList.add('hidden'); // Hide loader
                    convertButton.disabled = false; // Re-enable the button

                    if (data.downloadLink) {
                        downloadLinkContainer.style.display = 'block';
                        downloadLink.href = data.downloadLink;
                        downloadLink.textContent = "{{ __('messages.pdf_to_images_result_download') }}";
                    } else {
                        alert('{{ __('messages.pdf_to_images_error') }}');
                    }
                })
                .catch(error => {
                    loader.classList.add('hidden'); // Hide loader
                    convertButton.disabled = false; // Re-enable the button
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
