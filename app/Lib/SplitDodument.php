<?php


namespace App\Lib;


use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class SplitDodument
{
    private $url_filename;
    private $jenis_document;
    private $regex;
    private $page;

    public function __construct($url_filename, $regex, $jenis_document, $page)
    {
        $this->url_filename = $url_filename;
        $this->jenis_document = $jenis_document;
        $this->regex = $regex;
        $this->page = $page;
    }

    public function run()
    {
        $pdf = new Fpdi();
        $count = $pdf->setSourceFile(Storage::path($this->url_filename));
        $pages = range($count);
        $chunk = collect($pages)->chunk($this->page)->toArray();
        foreach ($chunk as $item) {
            $pdf->AddPage();
            $pdf->useTemplate($pdf->importPage(1));
        }
        $pdf->Output(Storage::path("uploads/scan/ii.pdf") ,"F");
    }
}