<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class InsertNilai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Nilai:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Nilai KHS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::files("khs");
        $arr = array();
        foreach ($files as $file){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $file = Storage::path($file);
            $spreadsheet = $reader->load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheetData)) {
                for ($i=2; $i<count($sheetData); $i++) {
                    $nim = $sheetData[$i][0];
                    $prodi = $sheetData[$i][1];
                    $kode_mk = $sheetData[$i][2];
                    $nama_mk = $sheetData[$i][3];
                    $sks = $sheetData[$i][5];
                    $semester = $sheetData[$i][6];
                    $tahun = $sheetData[$i][7];
                    $nilai_huruf = $sheetData[$i][9];
                    $nilai_bobot = $sheetData[$i][10];
                    $arr[] = ["nim" => $nim,
                        "prodi" => $prodi,
                        "kode" => $kode_mk,
                        "matakuliah"=>$nama_mk,
                        "semester" => $semester,
                        "sks"   => $sks,
                        "tahun" => $tahun,
                        "nilai_huruf" => $nilai_huruf,
                        "nilai_bobot" => $nilai_bobot];
                }
            }
        }
        $table = DB::table("krs")->insert($arr);
    }
}
