<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InsertMatakuliah implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$file  = "matakuliah/laporan_exportmatkul (1).xls";
        $excel = Storage::path($this->file);
        $table = $this->tables_to_array($excel);
        $arr[] = [];
        if(!empty($table)){
            if(isset($table[1])){
                foreach ($table[1] as $td){
                    if(!empty($td)){
                        $arr[] = [
                            "kode_mk" => (isset($td[1]) ? preg_replace("/[^a-zA-Z0-9]/", "", $td[1]): ""),
                            "nama_mk" => (isset($td[2])? preg_replace("/[^a-zA-Z0-9]+[\s]/", "",$td[2]) : ""),
                            "bobot_mk" => (isset($td[3])? (floatval($td[3]) == 0)? "0": floatval($td[3]):"0"),
                            "prodi_pengampu" => (isset($td[4])? preg_replace("/[^a-zA-Z0-9]+[\s]/", "",$td[4]) : ""),
                            "jenis_mk" => (isset($td[5])? preg_replace("/[^a-zA-Z0-9]+[\s]/", "",$td[5]) : "")
                        ];
                    }

                }

                $resultData = array_filter(array_map('array_filter', $arr));
                if(!empty($resultData)){
                    $collect = collect($resultData);
                    $chunk = $collect->chunk(1000);
                    foreach($chunk as $item){
                        DB::beginTransaction();
                        try{
                            DB::table("pddikti_matakuliah_feeder")->insert($item->toArray());
                        }catch (\Exception $exception){
                            DB::rollback();
                        }
                        DB::commit();
                    }
                }
            }
        }
    }

    private function tables_to_array($excel)
    {
        $htmlDocDom = new \DOMDocument();

        @$htmlDocDom->loadHTMLFile($excel);
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
