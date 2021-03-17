<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class InsertKrs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $timeout = 900;

    private $filename;

    /**
     * Create a new job instance.
     *
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        list($krs_dir,$sem_dir,$f_name) = explode("/",$this->filename);
        list($tahun,$semester) = str_split($sem_dir,4);
        $excel = Storage::path($this->filename);
        $table = $this->tables_to_array($excel);
        $arr[] = [];
        if(!empty($table)){

            foreach ($table[1] as $td){
                if(!empty($td)){
                    $arr[] = [
                        "nim" => trim($td[1]),
                        "nama" => trim($td[2]),
                        "prodi" => trim($td[3]),
                        "kode_mk" => trim($td[4]),
                        "nama_mk" => (isset($td[5])? $td[5] : ""),
                        "bobot_mk" => (isset($td[6])?(floatval($td[6]) == 0)? "0": floatval($td[6]):"0"),
                        "nilai_angka" => (isset($td[7])?(floatval($td[7]) == 0)? "0": floatval($td[7]):"0"),
                        "nilai_huruf" => trim($td[8]),
                        "nilai_index" => (isset($td[9])?(floatval($td[9]) == 0)? "0": floatval($td[9]):"0"),
                        "tahun" => $tahun,
                        "semester" => $semester];
                }

            }

            $resultData = array_filter(array_map('array_filter', $arr));
            if(!empty($resultData)){
                //print_r($arr);
                $collect = collect($resultData);
                $chunk = $collect->chunk(1000);
                foreach ($chunk as $item){
                    DB::beginTransaction();
                    try{
                        DB::table("krs")->insert($item->toArray());
                    }catch (\Exception $exception){
                        DB::rollback();
                    }
                    DB::commit();

                }

            }
        }
    }

    public function tables_to_array ($url): array
    {
        $htmlDocDom = new \DOMDocument();

        @$htmlDocDom->loadHTMLFile($url);
        $htmlDocDom->preserveWhiteSpace = false;
        $tableCounter = 0;
        $htmlDocTableArray = array();
        $htmlDocTables = $htmlDocDom->getElementsByTagName('table');
        foreach ($htmlDocTables as $htmlDocTable) {
            $htmlDocTableArray[$tableCounter] = array();
            $htmlDocRows= $htmlDocTable->getElementsByTagName('tr');
            $htmlDocRowCount = 0;
            $htmlDocTableArray[$tableCounter] = array();
            foreach ($htmlDocRows as $htmlDocRow) {
                if (strlen($htmlDocRow->nodeValue) > 1)
                {
                    $htmlDocColCount = 0;
                    $htmlDocTableArray[$tableCounter][$htmlDocRowCount] = array();
                    $htmlDocCols = $htmlDocRow->getElementsByTagName('td');
                    foreach ($htmlDocCols as $htmlDocCol) {
                        $htmlDocTableArray[$tableCounter][$htmlDocRowCount][] = $htmlDocCol->nodeValue;
                        $htmlDocColCount++;
                    }
                    $htmlDocRowCount++;
                }
            }
            if ($htmlDocRowCount > 1) $tableCounter++;
        }
        return($htmlDocTableArray);
    }
}
