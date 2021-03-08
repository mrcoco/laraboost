<?php


namespace App\Lib;


use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf as PdfImage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class RenameFile
{
    private $url_filename;
    private $regex;
    private $jenis_document;

    public function __construct($url_filename, string $regex, string $jenis_document)
    {
        $this->url_filename = $url_filename;
        $this->regex = $regex;
        $this->jenis_document = $jenis_document;
    }

    public function run()
    {
        $filePath = 'uploads/scan/tmp';
        $fileDest = 'uploads/scan/desc/'.$this->jenis_document;
        $png_filename = str_replace(".pdf", ".png", $this->url_filename);
        $pdf = new PdfImage(Storage::path($this->url_filename));
        $pdf->setOutputFormat('png');
        $pdf->saveImage(Storage::path($png_filename));
        $text_orc = (new TesseractOCR(Storage::path($png_filename)))
            ->run();
        preg_match('/[0-9]{11}/', $text_orc, $out);
        $v_regex = "/" . $this->regex . "/i";
        //$v_regex = "/[0-9]+\/[0-9]+\/[a-zA-Z][0-9]+\/[a-zA-Z0-9]+\/[0-9]+/i";
        preg_match($v_regex, $text_orc, $no_document);
        $pdf_name = $fileDest . '/' . $out[0] . ".pdf";
        if($out){
            Storage::move($this->url_filename, $pdf_name);
            Storage::delete($png_filename);
            DB::table("scanijazah")->insert(["nim" => $out[0], "jenis_document" => $this->jenis_document, "no_document" => $no_document[0], "file" => $pdf_name]);

            $config['content'] = "Documen dengan N0: ".$no_document[0]." milik NIM: ".$out[0]." Sudah Berhasil diUpload";
            $config['to'] = CRUDBooster::adminPath('scanijazah');
            $config['id_cms_users'] = [1,2,3,4,5]; //This is an array of id users
            CRUDBooster::sendNotification($config);
        }

    }

}