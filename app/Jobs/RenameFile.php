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
use thiagoalessio\TesseractOCR\TesseractOCR;

class RenameFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url_filename;
    private $regex;
    private $jenis_document;

    /**
     * Create a new job instance.
     *
     * @param $url_filename
     * @param string $regex
     * @param string $jenis_document
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
     * @return string
     */
    public function handle(): string
    {
        $rename = new \App\Lib\RenameFile($this->url_filename,$this->regex,$this->jenis_document);
        return $rename->run();
    }
}
