<?php namespace App\Http\Controllers;

	use App\Jobs\InsertKrs;
    use App\Jobs\InsertMatakuliah;
    use Illuminate\Support\Facades\Storage;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminKrsController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "pddikti_nilai_feeder";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"nim","name"=>"nim"];
			$this->col[] = ["label"=>"nama","name"=>"nama"];
			$this->col[] = ["label"=>"prodi","name"=>"prodi"];
			$this->col[] = ["label"=>"kode_mk","name"=>"kode_mk"];
			$this->col[] = ["label"=>"nama_mk","name"=>"nama_mk"];
			$this->col[] = ["label"=>"bobot_mk","name"=>"bobot_mk"];
			$this->col[] = ["label"=>"nilai_angka","name"=>"nilai_angka"];
			$this->col[] = ["label"=>"nilai_huruf","name"=>"nilai_huruf"];
			$this->col[] = ["label"=>"nilai_index","name"=>"nilai_index"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];

			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 

        public function getExcel()
        {
            $files = Storage::files("excel");
            $arr = array();
            foreach ($files as $file){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $file = Storage::path($file);
                $spreadsheet = $reader->load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                if (!empty($sheetData)) {
                    for ($i=9; $i<count($sheetData); $i++) {
                        $nim = $sheetData[$i][1];
                        $nama = $sheetData[$i][2];
                        $prodi = $sheetData[$i][3];
                        $kode_mk = $sheetData[$i][4];
                        $nama_mk = $sheetData[$i][5];
                        $bobot_mk = $sheetData[$i][6];
                        $nilai_angka = $sheetData[$i][7];
                        $nilai_huruf = $sheetData[$i][8];
                        $nilai_index = $sheetData[$i][9];
                        $arr[] = ["nim" => $nim,"nama" => $nama,"prodi" => $prodi,"kode_mk" => $kode_mk,"nama_mk"=>$nama_mk,"bobot_mk" => "1","nilai_angka" => "1","nilai_huruf" => $nilai_huruf,"nilai_index" => "1"];
                    }
                }
            }
            $table = DB::table("krs")->insert($arr);
        }

        public function getKrs()
        {
            $files = Storage::allFiles("krs/20191");
            foreach ($files as $file){
//                $file = "krs2/20141/laporan_exportkrs (46).xls";
                InsertKrs::dispatch($file);
            }
            echo "oke";
        }

        public function getSingle()
        {
            $file = "krs3/20201/laporan_exportkrs (93).xls";
            InsertKrs::dispatch($file);
        }

        public function getMatakuliah()
        {
            $files = Storage::allFiles("matakuliah");
            foreach ($files as $file){
                InsertMatakuliah::dispatch($file);
            }

        }

        public function getTable()
        {
            $file = "krs3/20201/laporan_exportkrs (28).xls";
            list($krs_dir,$sem_dir,$f_name) = explode("/",$file);
            list($tahun,$semester) = str_split($sem_dir,4);
            $excel = Storage::path($file);
            $table = $this->tables_to_array($excel);
            $arr[] = [];
            if(!empty($table)){
                foreach ($table[1] as $td){
                    if(!empty($td)){
                        $nim = preg_replace("/[^a-zA-Z0-9]/", "", $td[1]);
                        $nilai_huruf = preg_replace("/[^a-zA-Z0-9\+-]/", "", $td[8]);
                        $bobot_mk = floatval($td[6]);
                        $kode_mk = preg_replace("/[^a-zA-Z0-9]/", "", $td[4]);
                        $nilai_angka = floatval($td[7]);
                        $nilai_index = floatval($td[9]);
                        $idrelasi = $nim.$kode_mk.$tahun.$semester;
                        $cek = \Illuminate\Support\Facades\DB::table("pddikti_nilai_feeder")->where('nim',$nim)
                            ->where('kode_mk',$kode_mk)
                            ->where('tahun',$tahun)->where('semester',$semester)->first();
                        if(!$cek){
                            $arr[] = [
                                "nim" => $nim,
                                "nama" => trim($td[2]),
                                "prodi" => trim($td[3]),
                                "kode_mk" => preg_replace("/[^a-zA-Z0-9]/", "", $td[4]),
                                "nama_mk" => (isset($td[5])? $td[5] : ""),
                                "bobot_mk" => (isset($td[6]) ? ($bobot_mk == 0.0) ? "0.0": $bobot_mk : "0.0" ),
                                //"bobot_mk" => (floatval($td[6]) ? floatval($td[6]) : "0.0" ),
                                "nilai_angka" => (isset($td[7]) ? ($nilai_angka == 0.0) ? "0.0": $nilai_angka : "0.0" ),
                                "nilai_huruf" => (isset($td[8]) ? ($nilai_huruf !== "" ? $nilai_huruf : "-" ) : "-"),
                                "nilai_index" => (isset($td[9]) ? ($nilai_index == 0.0) ? "0.0": $nilai_index : "0.0" ),
                                "tahun" => $tahun,
                                "semester" => $semester,
                                "idrelasi" => $idrelasi
                            ];
                        }
                    }

                }

                $resultData = array_filter(array_map('array_filter', $arr));
                if(!empty($resultData)){
                    //print_r($arr);
                    $collect = collect($resultData);
                    $chunk = $collect->unique('idrelasi')->chunk(1000);
                    foreach ($chunk as $item){
                        //echo "<pre>";
                        dd($item->toArray());
                        //echo "</pre>";
                    }

                }
            }
        }

        function tables_to_array ($url) {
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