<?php


namespace App\Lib;


use setasign\Fpdi\Fpdi;

class PDFSplitter
{
    private $pdf;
    private $filename;
    private $file;
    private $source;
    private $destination;
    private $frompage;
    private $topage;
    private $temp = './temp/';
    private $is_upload = false;

    function __construct()
    {
        $this->pdf = new FPDI();
    }

    function set_source($source){
        $this->source = $source;
    }

    function set_temp($temp){
        $this->temp = $temp;
    }

    function set_filename($filename){
        $this->filename = $filename;
    }

    function set_file($filename){
        $this->file = $filename;
    }

    function set_destination($destination){
        $this->destination = $destination;
    }

    function set_is_upload($val){
        $this->is_upload = $val;
    }
    private function create_destination(){
        if(!file_exists($this->destination)){
            mkdir($this->destination);
        }
    }

    private function clean(){
        @unlink($this->temp.$this->filename);
    }

    public function get_page_count()
    {

    }

    function split_single($page=1,$topage=1){
        if($this->filename == null && $this->destination == null){
            throw new Exception("Please specify filename and destination", 1);
            exit();
        }
        if($page > $topage){
            throw new Exception("To Page must be greater than from page", 1);
            exit();
        }

        if($this->is_upload){
            move_uploaded_file($this->file,$this->temp.$this->filename);
        }else{
            copy($this->file, $this->temp.$this->filename);
        }

        for ($i = $page; $i <= $topage; $i++) {
            $this->pdf->AddPage();
            $this->pdf->setSourceFile($this->temp.$this->filename);
            $this->pdf->useTemplate($this->pdf->importPage($i));

            try {
                $this->create_destination();
                $new_filename = $this->destination.str_replace('.pdf', '', $this->filename).'_'.$i.".pdf";
                $this->pdf->Output($new_filename, "F");
                $this->clean();
                echo "Page ".$i." split into ".$new_filename."\n";
            } catch (Exception $e) {
                $this->clean();
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                exit();
            }

        }
    }
}