<?php


namespace App\Lib;


use App\Jobs\RenameFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class SplitDocument
{
    private $url_filename;
    private $jenis_document;
    private $regex;
    private $page;
    private $fileDest;

    public function __construct(string $url_filename, $page, string $fileDest, string $regex, string $jenis_document)
    {
        $this->url_filename = $url_filename;
        $this->jenis_document = $jenis_document;
        $this->fileDest = $fileDest;
        $this->regex = $regex;
        $this->page = $page;
    }

    public function run()
    {
        $pdf = new Fpdi();
        $count = $pdf->setSourceFile(Storage::path($this->url_filename));
        $pages = range(1, $count);
        $chunk = collect($pages)->chunk($this->page)->toArray();
        $arr_file = [];
        foreach ($chunk as $k => $v) {
            $new_pdf = new Fpdi();
            $new_pdf->setSourceFile(Storage::path($this->url_filename));
            foreach ($v as $i) {
                $new_pdf->AddPage();
                $new_pdf->useTemplate($new_pdf->importPage($i));
            }
            $new_pdf_name = $this->fileDest . "/" . $k . ".pdf";
            $new_pdf->Output(Storage::path($new_pdf_name), "F");
            $arr_file[] = $new_pdf_name;
        }
        foreach ($arr_file as $key => $value) {
            if (File::exists(Storage::path($value))) {
                RenameFile::dispatch($value, $this->regex, $this->jenis_document);
            }

        }
        Storage::delete($this->url_filename);
    }
}