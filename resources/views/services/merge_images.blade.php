@extends('layout')

@section('content')
    <div class="content-container">
        <!-- SEO and Informative Content -->
        <section class="seo-content">
            <h2>{{ __('messages.merge_pdf_about_title') }}</h2>
            <p>{{ __('messages.merge_pdf_about_description') }}</p>

            <h3>{{ __('messages.merge_pdf_why_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.merge_pdf_why_1_strong') }}</strong>
                    {{ __('messages.merge_pdf_why_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.merge_pdf_why_2_strong') }}</strong>
                    {{ __('messages.merge_pdf_why_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.merge_pdf_why_3_strong') }}</strong>
                    {{ __('messages.merge_pdf_why_3_text') }}
                </li>
            </ul>

            <h3>{{ __('messages.merge_pdf_features_title') }}</h3>
            <ul>
                <li>
                    <strong>{{ __('messages.merge_pdf_features_1_strong') }}</strong>
                    {{ __('messages.merge_pdf_features_1_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.merge_pdf_features_2_strong') }}</strong>
                    {{ __('messages.merge_pdf_features_2_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.merge_pdf_features_3_strong') }}</strong>
                    {{ __('messages.merge_pdf_features_3_text') }}
                </li>
                <li>
                    <strong>{{ __('messages.merge_pdf_features_4_strong') }}</strong>
                    {{ __('messages.merge_pdf_features_4_text') }}
                </li>
            </ul>
        </section>

        <!-- Merge Images Form Section -->
        <div class="merge-images-section">
            <h1 class="form-title">{{ __('messages.merge_pdf_form_title') }}</h1>
            <p class="form-description">{{ __('messages.merge_pdf_form_description') }}</p>

            <form id="mergeForm" enctype="multipart/form-data" class="merge-images-form">
                @csrf
                <div class="file-drop-zone" id="fileDropZone">
                    <input type="file" name="images[]" id="images" class="form-input" multiple required>
                    <p id="fileName">{{ __('messages.merge_pdf_form_drag_text') }}</p>
                </div>
                <button type="submit" class="form-button">{{ __('messages.merge_pdf_form_button') }}</button>
                <div id="loader" class="loader hidden"></div>
            </form>



            <div id="downloadLinkContainer" class="download-container" style="display: none;">
                <p>{{ __('messages.merge_pdf_result_success') }}</p>
                <a href="#" id="downloadLink" class="download-link"
                    download>{{ __('messages.merge_pdf_result_download') }}</a>
            </div>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('fileDropZone');
        const fileInput = document.getElementById('images');
        const fileNameDisplay = document.getElementById('fileName');

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
                fileInput.files = files; // Assign files to the input
                fileNameDisplay.textContent = `${files.length} file(s) selected`; // Update file count
            }
        });

        // Handle file input change
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = `${fileInput.files.length} file(s) selected`;
            }
        });

        // Form Submission
        document.getElementById('mergeForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch('/merge-images', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.downloadLink) {
                        document.getElementById('downloadLinkContainer').style.display = 'block';
                        document.getElementById('downloadLink').href = data.downloadLink;
                        document.getElementById('downloadLink').textContent =
                            "{{ __('messages.merge_pdf_result_download') }}";
                    } else {
                        alert('{{ __('messages.merge_pdf_error') }}');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

    </script>
@endsection
