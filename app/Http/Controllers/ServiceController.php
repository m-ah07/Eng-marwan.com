<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use NumberFormatter;
use ZipArchive;
use FPDF;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // Display the Convert Image Service page
    public function showConvertImage()
    {
        return view('services.convert_image');
    }

    // Handle image conversion
    public function convertImage(Request $request)
    {
        $this->incrementServiceCounter('image_converter');
        $request->validate([
            'image' => 'required|image',
            'format' => 'required|in:png,jpeg,gif,bmp'
        ]);

        $image = $request->file('image');
        $format = $request->input('format');
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $imagePath = $image->getPathname();
        $outputPath = public_path("{$originalName}.{$format}");

        // Process and save the image
        $imageResource = imagecreatefromstring(file_get_contents($imagePath));
        switch ($format) {
            case 'png': imagepng($imageResource, $outputPath); break;
            case 'jpeg': imagejpeg($imageResource, $outputPath); break;
            case 'gif': imagegif($imageResource, $outputPath); break;
            case 'bmp': imagebmp($imageResource, $outputPath); break;
        }
        imagedestroy($imageResource);

        return file_exists($outputPath)
            ? response()->download($outputPath)->deleteFileAfterSend(true)
            : response()->json(['error' => 'Failed to create file.'], 500);
    }

    // Display the Number-to-Text Service page
    public function showNumberToText()
    {
        return view('services.number_to_text');
    }

    // Handle number-to-text conversion
    public function convertNumberToText(Request $request)
    {
        $this->incrementServiceCounter('number_to_text');
        $number = $request->input('number');
        $tafqitType = $request->input('tafqitType');
        $locale = app()->getLocale(); // Current locale of the application

        // Default currency configurations based on locale
        $defaultCurrencies = [
            'ar' => ['subunit' => 'هللة', 'main' => 'ريال'],
            'en' => ['subunit' => 'Cent', 'main' => 'Dollar'],
            'ru' => ['subunit' => 'Копейка', 'main' => 'Рубль'],
            'zh' => ['subunit' => '分', 'main' => '元'],
            'ja' => ['subunit' => '銭', 'main' => '円'],
            'es' => ['subunit' => 'Céntimo', 'main' => 'Euro'],
            'fr' => ['subunit' => 'Centime', 'main' => 'Euro'],
            'de' => ['subunit' => 'Cent', 'main' => 'Euro'],
            'ur' => ['subunit' => 'پیسہ', 'main' => 'روپیہ'],
        ];

        $currencyConfig = $defaultCurrencies[$locale] ?? $defaultCurrencies['en']; // Default to English if locale is not found

        // Formatter setup
        $formatter = new \NumberFormatter($locale, \NumberFormatter::SPELLOUT);
        $text = '';

        if ($tafqitType === 'currency') {
            $subunit = $request->input('subunit', 0);

            $wholeText = $formatter->format($number);
            $subunitText = $formatter->format($subunit);

            $currencyMain = $currencyConfig['main'];
            $currencySub = $currencyConfig['subunit'];

            // Conjunctions for different languages
            $conjunctions = [
                'ar' => 'و',
                'en' => 'and',
                'zh' => '和',
                'ja' => 'そして',
                'ru' => 'и',
                'es' => 'y',
                'fr' => 'et',
                'de' => 'und',
                'ur' => 'اور',
            ];

            $conjunction = $conjunctions[$locale] ?? 'and'; // Default to "and"

            // Construct the final text
            if ($locale === 'ur') {
                $wholeText = $this->urduNumberToText($number);
                $subunitText = $this->urduNumberToText($subunit);
                $text = "{$wholeText} {$currencyMain} {$conjunction} {$subunitText} {$currencySub}";
            } else {
                $text = "{$wholeText} {$currencyMain} {$conjunction} {$subunitText} {$currencySub}";
            }
        } else {
            // Standard tafqit
            if ($locale === 'ur') {
                $text = $this->urduNumberToText($number);
            } else {
                $text = $formatter->format($number);
            }
        }

        if ($locale === 'ar') {
            $text = str_replace('مائة', 'مئة', $text); // Replace "مائة" with "مئة"
        }

        return response()->json(['text' => $text]);
    }

    // Convert numbers to Urdu text
    private function urduNumberToText($number)
    {
        $urduNumbers = [
            0 => 'صفر',
            1 => 'ایک',
            2 => 'دو',
            3 => 'تین',
            4 => 'چار',
            5 => 'پانچ',
            6 => 'چھ',
            7 => 'سات',
            8 => 'آٹھ',
            9 => 'نو',
            10 => 'دس',
            11 => 'گیارہ',
            12 => 'بارہ',
            13 => 'تیرہ',
            14 => 'چودہ',
            15 => 'پندرہ',
            16 => 'سولہ',
            17 => 'سترہ',
            18 => 'اٹھارہ',
            19 => 'انیس',
            20 => 'بیس',
            30 => 'تیس',
            40 => 'چالیس',
            50 => 'پچاس',
            60 => 'ساٹھ',
            70 => 'ستر',
            80 => 'اسی',
            90 => 'نوے',
            100 => 'سو',
            1000 => 'ہزار',
            100000 => 'لاکھ',
            10000000 => 'کروڑ',
        ]; // Simplified for brevity

        if ($number <= 20) {
            return $urduNumbers[$number] ?? $number;
        }

        if ($number < 100) {
            $tens = floor($number / 10) * 10;
            $units = $number % 10;
            return $urduNumbers[$tens] . ($units > 0 ? ' ' . $urduNumbers[$units] : '');
        }

        if ($number < 1000) {
            $hundreds = floor($number / 100);
            $remainder = $number % 100;
            return $urduNumbers[$hundreds] . ' ' . $urduNumbers[100] . ($remainder > 0 ? ' ' . $this->urduNumberToText($remainder) : '');
        }

        if ($number < 100000) {
            $thousands = floor($number / 1000);
            $remainder = $number % 1000;
            return $this->urduNumberToText($thousands) . ' ' . $urduNumbers[1000] . ($remainder > 0 ? ' ' . $this->urduNumberToText($remainder) : '');
        }

        if ($number < 10000000) {
            $lakhs = floor($number / 100000);
            $remainder = $number % 100000;
            return $this->urduNumberToText($lakhs) . ' ' . $urduNumbers[100000] . ($remainder > 0 ? ' ' . $this->urduNumberToText($remainder) : '');
        }

        if ($number < 1000000000) {
            $crores = floor($number / 10000000);
            $remainder = $number % 10000000;
            return $this->urduNumberToText($crores) . ' ' . $urduNumbers[10000000] . ($remainder > 0 ? ' ' . $this->urduNumberToText($remainder) : '');
        }

        return $number;
    }

    // Display the Merge Images Service page
    public function showMergeImages()
    {
        return view('services.merge_images');
    }

    // Merge images into a single PDF
    public function mergeImagesToPdf(Request $request)
    {
        $this->incrementServiceCounter('merge_images');
        $request->validate([
            'images.*' => 'required|image'
        ]);

        $images = $request->file('images');
        $pdf = new Fpdf();
        $tempImages = [];

        foreach ($images as $image) {
            $imagePath = $image->getPathname();
            $tempImagePath = public_path('temp_images/' . uniqid() . '.jpg');

            if (!file_exists(dirname($tempImagePath))) {
                mkdir(dirname($tempImagePath), 0777, true);
            }

            $imageResource = imagecreatefromstring(file_get_contents($imagePath));
            imagejpeg($imageResource, $tempImagePath);
            imagedestroy($imageResource);

            list($width, $height) = getimagesize($tempImagePath);
            $pdf->AddPage();
            $pdf->Image($tempImagePath, 10, 10, $pdf->GetPageWidth() - 20, ($pdf->GetPageWidth() - 20) * $height / $width);

            $tempImages[] = $tempImagePath;
        }

        $outputDirectory = public_path('merge_pdf');
        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory, 0777, true);
        }

        $outputFileName = 'merged_images_' . uniqid() . '.pdf';
        $outputPath = $outputDirectory . '/' . $outputFileName;
        $pdf->Output('F', $outputPath);

        foreach ($tempImages as $tempImagePath) {
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }
        }

        if (file_exists($outputPath)) {
            $downloadLink = asset('merge_pdf/' . $outputFileName);

            return response()->json(['downloadLink' => $downloadLink]);
        } else {
            return response()->json(['error' => 'Failed to create merged PDF file.'], 500);
        }
    }

    // Display the Text Analysis Service page
    public function showTextAnalysis()
    {
        return view('services.text_analysis');
    }

    // Analyze text content
    public function analyzeText(Request $request)
    {
        $this->incrementServiceCounter('text_analysis');
        $request->validate(['text' => 'required|string']);
        $text = $request->input('text');

        $textWithoutTashkeel = preg_replace('/[ًٌٍَُِّْـ]/u', '', $text);

        preg_match_all('/\p{L}+/u', $textWithoutTashkeel, $matches);
        $wordCount = count($matches[0]);

        $characterCountNoSpaces = mb_strlen(str_replace(' ', '', $textWithoutTashkeel));
        $characterCountWithSpaces = mb_strlen($textWithoutTashkeel);

        $spaceCount = substr_count($text, ' ');
        $enterCount = substr_count($text, "\n");

        return response()->json([
            'word_count' => $wordCount,
            'character_count_no_spaces' => $characterCountNoSpaces,
            'character_count_with_spaces' => $characterCountWithSpaces,
            'space_count' => $spaceCount,
            'enter_count' => $enterCount,
        ]);
    }

    // Display the Convert PDF to Images Service page
    public function showConvertPdfToImages()
    {
        return view('services.convert_pdf_to_images');
    }

    // Convert PDF to images
    public function convertPdfToImages(Request $request)
    {
        $this->incrementServiceCounter('pdf_to_image');
        $request->validate(['pdf' => 'required|mimes:pdf']);

        $pdf = $request->file('pdf');
        $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
        $sanitizedOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

        $outputDirectory = public_path('images_converted/' . $sanitizedOriginalName . '_' . uniqid());
        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory, 0777, true);
        }

        $pdfPath = $pdf->getPathname();
        $command = "pdftoppm -png " . escapeshellarg($pdfPath) . " " . escapeshellarg($outputDirectory . '/' . $sanitizedOriginalName);
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return response()->json(['error' => 'Failed to convert PDF to images.'], 500);
        }

        $zipFileName = $sanitizedOriginalName . '_images_' . uniqid() . '.zip';
        $zipPath = public_path('images_converted/' . $zipFileName);
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach (glob($outputDirectory . '/*.png') as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create ZIP file.'], 500);
        }

        foreach (glob($outputDirectory . '/*.png') as $file) {
            unlink($file);
        }
        rmdir($outputDirectory);

        $downloadLink = asset('images_converted/' . $zipFileName);

        return response()->json(['downloadLink' => $downloadLink]);
    }

    public function downloadZip($filename)
    {
        $path = public_path($filename);

        if (file_exists($path)) {
            return response()->download($path)->deleteFileAfterSend(true);
        } else {
            abort(404, 'File not found.');
        }
    }

    private function incrementServiceCounter($serviceName)
    {
        $path = storage_path('app/service_counters.json');

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([
                'image_converter' => 0,
                'number_to_text' => 0,
                'merge_images' => 0,
                'text_analysis' => 0,
                'pdf_to_image' => 0,
            ]));
        }

        $counters = json_decode(file_get_contents($path), true);

        if (isset($counters[$serviceName])) {
            $counters[$serviceName]++;
        } else {
            $counters[$serviceName] = 1;
        }

        file_put_contents($path, json_encode($counters));

    }


    private function getServiceCounters()
    {
        $path = storage_path('app/service_counters.json');

        if (!file_exists($path)) {
            return [
                'image_converter' => 0,
                'number_to_text' => 0,
                'merge_images' => 0,
                'text_analysis' => 0,
                'pdf_to_image' => 0,
            ];
        }

        $counters = json_decode(file_get_contents($path), true);

        return $counters;
    }

    // Display the homepage and pass service counters
    public function showHomePage()
    {
        $serviceCounters = $this->getServiceCounters();
        return view('home', compact('serviceCounters'));
    }

}
