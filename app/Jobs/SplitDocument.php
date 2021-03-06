<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf as PdfImage;
use Spatie\PdfToText\Pdf;
use thiagoalessio\TesseractOCR\TesseractOCR;

class SplitDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url_filename;
    private $regex;
    private $jenis_document;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url_filename, string $regex, string $jenis_document)
    {
        $this->url_filename = $url_filename;
        $this->regex = $regex;
        $this->jenis_document = $jenis_document;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filePath = 'uploads/scan/tmp';
        $fileDest = 'uploads/scan/desc';
        $text = (new Pdf('/usr/local/bin/pdftotext'))
            ->setPdf(Storage::path($this->url_filename))
            ->text();

        if (!$text) {
            $png_filename = str_replace(".pdf", ".png", $this->url_filename);
            $pdf = new PdfImage(Storage::path($this->url_filename));
            $pdf->setOutputFormat('png');
            $pdf->saveImage(Storage::path($png_filename));
            $text_orc = (new TesseractOCR(Storage::path($png_filename)))
                ->run();
            preg_match('/[0-9]{11}/', $text_orc, $out);
            $v_regex = "/" . $this->regex . "/i";
            preg_match($v_regex, $text_orc, $no_document);
            $pdf_name = $fileDest . '/' . $out[0] . ".pdf";
            Storage::move($this->url_filename, $pdf_name);
            Storage::delete($png_filename);
            DB::table("scanijazah")->insert(["nim" => $out[0], "jenis_document" => $this->jenis_document, "no_document" => $no_document[0], "file" => $pdf_name]);

        } else {
            preg_match('/[0-9]{11}/', $text, $out);
            $pdf_name = $fileDest . '/' . $out[0] . ".pdf";
            Storage::move($this->url_filename, $pdf_name);
        }
    }
}
