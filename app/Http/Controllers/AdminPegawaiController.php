<?php namespace App\Http\Controllers;

	use GuzzleHttp\Client;
    use Illuminate\Validation\ValidationException;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminPegawaiController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->button_import = true;
			$this->button_export = true;
			$this->table = "pegawai";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"nama_lengkap","name"=>"nama_lengkap"];
			$this->col[] = ["label"=>"tempat_lahir","name"=>"tempat_lahir"];
			$this->col[] = ["label"=>"tanggal_lahir","name"=>"tanggal_lahir"];
			$this->col[] = ["label"=>"unit_detail","name"=>"unit_detail"];
			$this->col[] = ["label"=>"pangkat","name"=>"pangkat"];
			$this->col[] = ["label"=>"golongan","name"=>"golongan"];
			$this->col[] = ["label"=>"jenis_pegawai","name"=>"jenis_pegawai"];
			$this->col[] = ["label"=>"status_pegawai","name"=>"status_pegawai"];
			$this->col[] = ["label"=>"photo","name"=>"photo","image"=>true];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Nama Lengkap','name'=>'nama_lengkap','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tempat Lahir','name'=>'tempat_lahir','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tanggal Lahir','name'=>'tanggal_lahir','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Unit','name'=>'unit_detail','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'pangkat','name'=>'pangkat','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'golongan','name'=>'golongan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jabatan','name'=>'jabatan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jenis Pegawai','name'=>'jenis_pegawai','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Status Pegawai','name'=>'Status Pegawai','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Photo','name'=>'photo','type'=>'upload','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"","name"=>"","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
            $this->index_button[] = ["label" => "sync","url" => CRUDBooster::mainpath("sync"),"icon" => "fa fa-bars"];



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

        public function getSync()
        {
            ini_set('memory_limit', '256M');
//            echo "<pre>";
//            print_r($this->compare());
//            echo "</pre>";
            $compare = $this->compare();
            if($compare->dataIn){
                $insert = collect($compare->dataIn);
                $chunk = $insert->chunk(500);
                foreach ($chunk as $item) {
                    DB::beginTransaction();
                    try{
                        DB::table("pegawai")->insert($item->toArray());
                    }catch (ValidationException $exception){
                        DB::rollback();
                    }
                    DB::commit();
                }

            }
            return CRUDBooster::redirect(CRUDBooster::mainPath(), trans('crudbooster.alert_success'));
        }

        public function compare()
        {
            $pegawai = $this->dataSiap();
            $dataIn = array();
            $dataUp = array();
            $filter = array();
            $userIn = array();
            $ii = 0;
            for ($i=0; $i<count($pegawai); $i++)
            {
                //$sql = 'SELECT * FROM pegawai WHERE id_siap = ' .$pegawai[$i]['id_siap'];
                //$dataDb = $this->db->fetchOne($sql, Enum::FETCH_ASSOC);
                $dataDb = DB::table("pegawai")->where("id_siap","=",$pegawai[$i]['id_siap'])->first();
                foreach ($pegawai[$i] as $k => $v)
                {
                    $index = $k;
                    if ($dataDb){
                        if(strcmp($dataDb->check_sum,$pegawai[$i]['check_sum']) !== 0 ){
                            if($index !== 'created_at'){
                                $dataUp[$i][$index] = $v;
                            }
                            $filter[$i]['"id_siap"'] = $pegawai[$i]['id_siap'];
                            //$dataUp[$i]['updated'] = date('Y-m-d H:i:s');
                        }
                    }
                    else{
                        $dataIn[$ii][$index] = $v;
                    }
                }
                $ii++;
            }
            $result = new \stdClass();
            $result->dataIn = $dataIn;
            $result->dataUp = $dataUp;
            $result->filter = $filter;
            return $result;
        }

        public function gelar($dt,$str=null)
        {
            $dt = str_replace(' ', '', $dt);
            if   ($str == '.') {
                $glr = explode('.', $dt);
                $glue = '. ';
            }
            else {
                $glr = explode(',', $dt);
                $glue = ', ';
            }
            return implode($glue, $glr);


        }

        /**
         * @return mixed
         * @throws \GuzzleHttp\Exception\GuzzleException
         */
        public function curlSiap()
        {
            $curl = new Client();
            $req = $curl->get("http://api.siap.uny.ac.id/v0.2/pegawai", [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'content-type' => 'application/x-www-form-urlencoded',
                    'X-Authorization' => "go00kgockg0swso04084wc8080s4444g8ok0wgsw",
                    'X-Appname' => "presensi-android",
                    'X-Date' => gmdate("d M Y H:i:s") . "Z"
                ]
            ]);
            $siap = json_decode($req->getBody());
            return $siap;
        }

        /**
         * @return array
         * @throws \GuzzleHttp\Exception\GuzzleException
         */
        public function dataSiap(): array
        {
            $siap = $this->curlSiap();
            $replace = array(' ');
            $arr = [];
            $i = 0;
            foreach ($siap->result as $v) {
                $namalengkap = (isset($v->p_gdepan) ? $this->gelar($v->p_gdepan, ".") . " " : "") . $v->p_nama . (isset($v->p_gbelakang) ? ", " . $this->gelar($v->p_gbelakang) : "");
                $unitIdentity = str_replace($replace, '', $v->un_nama . $v->ba_nama . $v->sb_nama);
                $arr[$i] = [
                    'id_siap' => $v->p_id,
                    'nip' => $v->p_nipbaru,
                    'nama' => $v->p_nama,
                    'nama_lengkap' => $namalengkap,
                    'gelar_depan' => $v->p_gdepan,
                    'gelar_belakang' => $v->p_gbelakang,
                    'tempat_lahir' => $v->p_tmplahir,
                    'tanggal_lahir' => $v->p_tgllahir,
                    'email' => (isset($v->p_email)) ? $v->p_email : $v->p_emailuny,
                    'photo' => $v->p_file,
                    'sub_bagian' => $v->sb_nama,
                    'bagian' => $v->ba_nama,
                    'unit' => $v->un_nama,
                    'unit_detail' => $v->un_ket,
                    'unit_order' => $v->un_order,
                    'unit_identity' => strtolower($unitIdentity),
                    'pangkat' => $v->go_pangkat,
                    'golongan' => $v->go_nama,
                    'jenis_pegawai' => $v->gr_nama,
                    'jabatan' => $v->fu_nama,
                    'status_pegawai' => $v->st_nama,
                    'status_aktif_id' => (isset($v->sta_id)) ? $v->sta_id : "0",
                    'status_aktif' => $v->sta_nama,
                    'jenjang_pendidikan' => $v->pe_nama,
                    'prodi' => $v->ppe_sb_nama,
                    'tahun_lulus' => $v->ppe_tahun,
                    'tmt_pensiun' => (isset($v->p_tmtpensiun)) ? $v->p_tmtpensiun : null,
                ];
                $arr[$i]['check_sum'] = md5(json_encode($arr[$i]));
                $i++;
            }
            return $arr;
        }
    }