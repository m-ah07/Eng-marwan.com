<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() == 'ar' || app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.site_name') }}</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body id="top" lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() == 'ar' || app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">

    <header>
        <div class="header-container">
            <nav class="navbar">
                <div class="logo">
                    <a href="{{ url('/') }}">{{ __('messages.site_name') }}</a>
                </div>
                <ul class="menu" id="menu">
                    <li><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ url('/#about') }}"
                            onclick="scrollToCenter(event, 'about')">{{ __('messages.about') }}</a></li>

                    <li class="dropdown-item">
                        <a class="nav-link" href="#services" onclick="scrollToCenter(event, 'services')">
                            {{ __('messages.services') }}<i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('/convert-image') }}">{{ __('messages.image_converter') }}</a></li>
                            <li><a href="{{ url('/number-to-text') }}">{{ __('messages.number_spelling') }}</a></li>
                            <li><a href="{{ url('/merge-images') }}">{{ __('messages.combine_images') }}</a></li>
                            <li><a href="{{ url('/text-analysis') }}">{{ __('messages.text_analysis') }}</a></li>
                            <li><a href="{{ url('/convert-pdf-to-images') }}">{{ __('messages.pdf_to_image') }}</a>
                            </li>
                        </ul>
                    </li>


                    <li><a href="{{ url('/#contact') }}"
                            onclick="scrollToCenter(event, 'contact')">{{ __('messages.contact') }}</a>
                    </li>
                </ul>

                <!-- Language Dropdown Menu -->
                <div class="language-dropdown">
                    <button class="dropdown-toggle">
                        <img src="/flags/{{ app()->getLocale() }}.png" alt="{{ strtoupper(app()->getLocale()) }}"
                            class="flag-icon">
                        {{ __('messages.lang_' . app()->getLocale()) }}
                        <span class="arrow">▼</span>
                    </button>
                    <ul class="dropdown-menu">
                        @php
                            $languages = [
                                'en' => 'English',
                                'ar' => 'العربية',
                                'es' => 'Español',
                                'fr' => 'Français',
                                'de' => 'Deutsch',
                                'zh' => '中文',
                                'ja' => '日本語',
                                'ru' => 'Русский',
                                'ur' => 'اردو',
                            ];
                        @endphp
                        @foreach ($languages as $langCode => $langName)
                            @if ($langCode !== app()->getLocale())
                                <li data-lang="{{ $langCode }}">
                                    <img src="/flags/{{ $langCode }}.png" alt="{{ $langName }}"
                                        class="flag-icon">
                                    {{ $langName }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="contact-button">
                    <a class="open-menu-btn"><i class="fa-solid fa-bars"></i></a>
                    <a class="close-menu-btn"><i class="fa-solid fa-xmark"></i></a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container" id="footer">
            <div class="footer-row">
                <div class="footer-col">
                    <h4>{{ __('messages.links') }}</h4>
                    <ul class="footer-ul">
                        <li><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                        <li><a href="{{ url('/#about') }}"
                                onclick="scrollToCenter(event, 'about')">{{ __('messages.about_us') }}</a></li>
                        <li><a href="{{ url('/#services') }}"
                                onclick="scrollToCenter(event, 'services')">{{ __('messages.services') }}</a></li>
                        <li><a href="{{ url('/privacy-policy') }}">{{ __('messages.privacy_policy_title') }}</a></li>
                        <li><a href="{{ url('/terms') }}">{{ __('messages.terms_title') }}</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>{{ __('messages.services') }}</h4>
                    <ul class="footer-ul">
                        <li><a href="{{ url('/convert-image') }}">{{ __('messages.image_converter') }}</a></li>
                        <li><a href="{{ url('/number-to-text') }}">{{ __('messages.number_spelling') }}</a></li>
                        <li><a href="{{ url('/merge-images') }}">{{ __('messages.combine_images') }}</a></li>
                        <li><a href="{{ url('/text-analysis') }}">{{ __('messages.text_analysis') }}</a></li>
                        <li><a href="{{ url('/convert-pdf-to-images') }}">{{ __('messages.pdf_to_image') }}</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>{{ __('messages.contacts') }}</h4>
                    <ul class="footer-ul">
                        <li class="con-txt">{{ __('messages.email_1') }}</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>{{ __('messages.follow_us') }}</h4>
                    <div class="social-links">
                        <a href="https://github.com/marwan-ahmed-23" target="_blank" rel="noopener noreferrer"><i
                                class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/in/marwan-ah" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-text">
            <p>{{ __('messages.all_codes') }} <a class="span-color" href="https://github.com/marwan-ahmed-23/eng-marwan.com"
                    target="_blank" rel="noopener noreferrer">{{ __('messages.my_github') }}</a>.</p>
        </div>
    </footer>

    <script>
        // Smooth scroll to center
        function scrollToCenter(event, id) {
            event.preventDefault();
            const element = document.getElementById(id);

            if (!element) {
                console.error(`Element with ID "${id}" not found.`);
                return;
            }

            const elementRect = element.getBoundingClientRect();
            const offset = (window.innerHeight / 2) - (elementRect.height / 2);
            const scrollPosition = window.scrollY + elementRect.top - offset;

            window.scrollTo({
                top: scrollPosition,
                behavior: 'smooth'
            });
        }
    </script>

    <script>
        document.getElementById('convertButton').addEventListener('click', function() {
            const button = this;

            button.classList.add('loading');
            button.disabled = true;

            setTimeout(() => {
                button.classList.remove('loading');
                button.disabled = false;
            }, 5000);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menu = document.getElementById("menu");
            const openMenuBtn = document.querySelector(".open-menu-btn");
            const closeMenuBtn = document.querySelector(".close-menu-btn");

            // Initial menu visibility based on screen width
            if (window.innerWidth <= 850) {
                menu.style.display = "none";
                closeMenuBtn.style.display = "none";
                openMenuBtn.style.display = "inline";
            } else {
                menu.style.display = "flex";
                closeMenuBtn.style.display = "none";
                openMenuBtn.style.display = "none";
            }

            // Show menu
            openMenuBtn.addEventListener("click", function() {
                menu.style.display = "block";
                openMenuBtn.style.display = "none";
                closeMenuBtn.style.display = "inline";
            });

            // Hide menu
            closeMenuBtn.addEventListener("click", function() {
                menu.style.display = "none";
                openMenuBtn.style.display = "inline";
                closeMenuBtn.style.display = "none";
            });

            // Adjust menu visibility on window resize
            window.addEventListener("resize", function() {
                if (window.innerWidth > 850) {
                    menu.style.display = "flex"; // Show menu for larger screens
                    openMenuBtn.style.display = "none";
                    closeMenuBtn.style.display = "none";
                } else {
                    menu.style.display = "none"; // Hide menu for smaller screens
                    openMenuBtn.style.display = "inline";
                    closeMenuBtn.style.display = "none";
                }
            });

            // Language dropdown functionality
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            // Toggle dropdown menu
            dropdownToggle.addEventListener('click', () => {
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', (event) => {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });

            // Update language dropdown dynamically
            dropdownMenu.addEventListener('click', (event) => {
                const listItem = event.target.closest('li');
                if (!listItem) return;

                const selectedLang = listItem.dataset.lang;
                const selectedFlag = listItem.querySelector('img').src;
                const selectedText = listItem.textContent.trim();

                // Update the dropdown toggle with the selected language
                dropdownToggle.innerHTML =
                    `<img src="${selectedFlag}" alt="${selectedText}" class="flag-icon"> ${selectedText} <span class="arrow">▼</span>`;

                // Reload the page with the selected language
                window.location.href = `/language/${selectedLang}`;
            });
        });


    </script>

</body>

</html>
