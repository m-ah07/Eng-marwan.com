# Eng-Marwan.com

Welcome to **Eng-Marwan.com** – a personal website that evolved beyond a simple portfolio into a platform offering a range of **practical tech services**. Inspired by a passion for problem-solving, this repository showcases how even a personal project can deliver real value and help simplify daily technical needs for a wide audience.

---

## Table of Contents

1. [Overview](#overview)  
2. [Motivation](#motivation)  
3. [Features](#features)  
4. [Localization & Multiple Languages](#localization--multiple-languages)  
5. [Tech Stack](#tech-stack)  
6. [Directory Structure](#directory-structure)  
7. [Installation & Setup](#installation--setup)  
8. [Security & Best Practices](#security--best-practices)  
9. [License](#license)  
10. [Contributing](#contributing)  
11. [Contact](#contact)


## Overview

**Eng-Marwan.com** brings together a suite of tools enabling users to:
- Convert images and PDFs quickly.
- Merge multiple images into a single PDF.
- Perform text analysis and word/character counts.
- Convert numbers to text (Tafqit) in multiple languages.
  
All these services run on top of a **Laravel** backend and are accessible via a user-friendly UI. The application also demonstrates multilingual support and usage counters to track service popularity.


## Motivation

> *"When I started my journey in programming and web development, I always had one goal in mind: to create real value that helps others and simplifies their technical lives."*

This project reflects that vision. It is a **learning journey** transformed into a practical solution, open for the community to use, adapt, and build upon.


## Features

1. **Image & File Conversion**  
   - Convert images to various formats (JPEG, PNG, GIF, BMP).  
   - Turn PDFs into images with automated page handling.

2. **Tafqit (Number Spelling)**  
   - Convert numerical values into words, supporting multiple locales.  
   - Special currency logic for Arabic, English, and others.

3. **Merging Images into PDF**  
   - Combine multiple images into a single PDF file.  
   - Automated resizing and page setup via FPDF.

4. **Text Analysis**  
   - Get word count, character count (with/without spaces), and more.  
   - Remove diacritics (Tashkeel) for Arabic processing.

5. **Services Usage Counters**  
   - Track how many times each service is used; displayed on the homepage.


## Localization & Multiple Languages

Eng-Marwan.com supports **multi-lingual** content, allowing users from various locales to navigate and use the website in their preferred language. The languages currently provided include:

- **Arabic (ar)**
- **Spanish (es)**
- **French (fr)**
- **German (de)**
- **Japanese (ja)**
- **Russian (ru)**
- **Urdu (ur)**

Each language has its own folder inside `resources/lang/<locale>`, containing the necessary translation files. For example:

```plaintext
resources/
└── lang/
    ├── ar/
    │   ├── messages.php
    │   └── ...
    ├── es/
    │   └── messages.php
    ├── fr/
    │   └── messages.php
    ├── de/
    │   └── messages.php
    ├── ja/
    │   └── messages.php
    ├── ru/
    │   └── messages.php
    └── ur/
        └── messages.php
```

#### How Localization Works
- **Language Switching**: A language switcher dropdown (or a route-based approach) allows users to pick a preferred language.  
- **Blade Integration**: In templates, strings are displayed with `{{ __('messages.key') }}` or `@lang('messages.key')`, so Laravel automatically fetches the correct translation from the user’s chosen language folder.  
- **Fallback**: If a key isn’t found in the selected language, Laravel falls back to the default locale set in `config/app.php`.  

#### Adding a New Language
1. **Create a Folder** inside `resources/lang/` named after the [ISO locale code](https://www.science.co.il/language/Locale-codes.php) (e.g., `it` for Italian).  
2. **Copy** an existing language file (like `messages.php`) into the new folder.  
3. **Translate** each key-value pair into the new language.  
4. **Update** your language dropdown or logic so users can select the new locale.

By maintaining a folder and file structure like the above, you ensure seamless translation across your Blade views, making Eng-Marwan.com accessible to a broader global audience.


## Tech Stack

- **Backend**: [Laravel](https://laravel.com/) (PHP)
  - Controllers, Routes, Middleware, and Models.
  - Leverages packages like FPDF for PDF creation.
- **Frontend**:  
  - Blade templates (`.blade.php`), HTML, CSS, JS (with optional Tailwind/Bootstrap).
  - Uses localized strings for multilingual support.
- **Database**: MySQL or MariaDB (though the usage counters can also run off JSON storage).  
- **Additional Tools**:  
  - `pdftoppm` (via shell commands) for PDF-to-image conversion.  
  - [NumberFormatter](https://www.php.net/manual/en/class.numberformatter.php) for converting numbers into words.


## Directory Structure

```plaintext
Eng-Marwan.com/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── ServiceController.php    # Core logic for file/image conversions
│   │   ├── Middleware/
│   │   │   └── LocalizationMiddleware.php
│   │   └── Kernel.php
│   ├── Models/
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
├── config/
├── database/
├── dist/
├── node_modules/
├── public/
│   ├── build/
│   ├── css/
│   ├── flags/
│   ├── images/
│   ├── images_converted/
│   ├── js/
│   ├── merge_pdf/
│   ├── pdf_images/
│   ├── temp_images/
│   ├── .htaccess
│   ├── desktop.ini
│   ├── favicon.ico
│   ├── index.php
│   ├── info.php
│   └── robots.txt
├── python_services/
├── resources/
│   ├── css/
│   ├── js/
│   ├── lang/
│   │   ├── ar/
│   │   │   └── messages.php
│   │   ├── de/
│   │   │   └── messages.php
│   │   ├── en/
│   │   │   └── messages.php
│   │   ├── es/
│   │   │   └── messages.php
│   │   ├── fr/
│   │   │   └── messages.php
│   │   ├── ja/
│   │   │   └── messages.php
│   │   ├── ru/
│   │   │   └── messages.php
│   │   ├── ur/
│   │   │   └── messages.php
│   │   └── zh/
│   │       └── messages.php
│   └── views/
│       ├── services/
│       │   ├── convert_image.blade.php
│       │   ├── convert_pdf_to_images.blade.php
│       │   ├── merge_images.blade.php
│       │   ├── number_to_text.blade.php
│       │   └── text_analysis.blade.php
│       ├── home.blade.php
│       ├── layout.blade.php
│       ├── privacy_policy.blade.php
│       ├── terms.blade.php
│       └── welcome.blade.php
├── routes/
│   ├── console.php
│   └── web.php
├── storage/
├── tests/
├── vendor/
├── venv/
├── artisan
├── CODE_OF_CONDUCT.md
├── composer.json
├── composer.lock
├── package-lock.json
├── package.json
├── phpunit.xml
├── postcss.config.js
├── tailwind.config.js
├── vite.config.js
├── .editorconfig
├── .env
├── .gitattributes
├── .gitignore
├── LICENSE
└── README.md
```


## Installation & Setup

1. **Clone the Repository**  
   ```bash
   git clone https://github.com/marwan-ahmed-23/eng-marwan.com.git
   cd eng-marwan.com
   ```

2. **Install PHP Dependencies**  
   ```bash
   composer install
   ```

3. **Install Node Dependencies**  
   ```bash
   npm install
   # For asset building
   npm run dev  # or npm run build
   ```

4. **Environment Setup**  
   - Copy `.env.example` to `.env`.  
   - Update database credentials, `APP_KEY`, and other sensitive data.  
   - Generate a new application key:  
     ```bash
     php artisan key:generate
     ```

5. **Run Migrations** (if using a DB)  
   ```bash
   php artisan migrate
   ```

6. **Serve the Application**  
   ```bash
   php artisan serve
   ```
   The site should now be live at `http://127.0.0.1:8000`.


## Security & Best Practices

- **Exclude Sensitive Files**:  
  Ensure `.env`, `vendor/`, `node_modules/`, logs, and any other sensitive folders are listed in `.gitignore`.
- **Review and Clean**:  
  Remove any debug or test files (e.g., `info.php`) before pushing to public repositories.
- **Check for Hardcoded Secrets**:  
  Use environment variables instead of hardcoding API keys or credentials.
- **Directory Permissions**:  
  Ensure `storage/` is writable, but do not expose it publicly.


## License

This project is licensed under the **MIT License** – see the [LICENSE](LICENSE) file for details.  
Feel free to adapt and build upon it for your own needs.


## Contributing

1. **Fork** the repository.  
2. **Create a new branch** (`git checkout -b feature/some-feature`).  
3. **Commit** your changes (`git commit -m "Add some feature"`).  
4. **Push** to your branch (`git push origin feature/some-feature`).  
5. **Open a Pull Request** explaining your additions or improvements.

We welcome community contributions—new services, UI improvements, or localization support!


## Contact

- **Website**: [Eng-Marwan.com](https://eng-marwan.com)  
- **GitHub**: [Marwan Ben Ahmed](https://github.com/marwan-ahmed-23)  
- **LinkedIn**: [Marwan Taresh](https://www.linkedin.com/in/marwan-ah)  
- **Email**: info@eng-marwan.com  

---

**Thank you for exploring Eng-Marwan.com!** If you have suggestions or feature requests, feel free to open an issue or reach out directly. Enjoy the services, and keep coding!  
