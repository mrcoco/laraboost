<?php namespace App\Http\Controllers;

	use App\Jobs\RenameFile;
    use App\Jobs\SplitDocument;
    use App\Lib\PDFSplitter;
    use crocodicstudio\crudbooster\helpers\CB;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Redirect;
    use Imagick;
    use setasign\Fpdi\Fpdi;
    use Spatie\PdfToImage\Pdf as PdfImage;
    use thiagoalessio\TesseractOCR\TesseractOCR;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Validator;
    use Session;
	use DB;
	use CRUDBooster;
    use Spatie\PdfToText\Pdf;

    class AdminScanijazahController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "scanijazah";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"nim","name"=>"nim"];
			$this->col[] = ["label"=>"jenis_document","name"=>"jenis_document","join"=>"regex,name"];
			$this->col[] = ["label"=>"no_document","name"=>"no_document"];
			$this->col[] = ["label"=>"file","name"=>"file"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'nim','name'=>'nim','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'jenis document','name'=>'jenis_document','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			$this->form[] = ['label'=>'no_document','name'=>'no_document','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			$this->form[] = ['label'=>'file','name'=>'file','type'=>'upload','validation'=>'required','width'=>'col-sm-9'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'nim','name'=>'nim','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'jenis document','name'=>'jenis_document','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'no_document','name'=>'no_document','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'file','name'=>'file','type'=>'upload','validation'=>'required','width'=>'col-sm-9'];
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
            $this->index_button[]= ["label"=>"add","url"=> "javascript:addScan()","icon" => "fa fa-bars"];
            $this->index_button[]= ["label"=>"Multi Page","url"=> "javascript:addMultiPageScan()","icon" => "fa fa-bars"];


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
	        $this->script_js = '
	        function addScan(){
	            $("#modal-add").modal("show");
	        }
	        
	        function addMultiPageScan(){
	            $("#modal-add-multi").modal("show");
	        }
	        
	        ';




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
	        $this->post_index_html = view('scan/scan_add_view',["document" => DB::table("regex")->get(['id','name','regex'])])->render();


	        
	        
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
	        echo "oke";

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
        public function getAdd() {
            //Create an Auth
            if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }

            $data = [];
            $data['document'] = DB::table("regex")->get(['id','name','regex']);
            $data['page_title'] = 'Add Data';

            //Please use cbView method instead view method from laravel
            $this->cbView('scan/scan_add_view',$data);
        }

        /**
         *
         * Regex no transkrip
         * [0-9]+/[a-zA-Z]-[a-zA-Z]+/[a-zA-Z]\d-[a-zA-Z]+/[0-9]+
         *
         * Regex no Ijazah
         *
         * Regex nim
         * [0-9]{11}
         *
         */
        public function postAddSave()
        {
            $post_jenis = Request::input("jenis_document");
            list($jenis_document,$regex) = explode("#",$post_jenis);
            if (Request::hasFile('file_ijazah')) {
                $file = Request::file('file_ijazah');
                $ext = $file->getClientOriginalExtension();

                $validator = Validator::make([
                    'extension' => $ext,
                ], [
                    'extension' => 'in:pdf,PDF',
                ]);

                if ($validator->fails()) {
                    $message = $validator->errors()->all();

                    return redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning']);
                }

                $filePath = 'uploads/scan/tmp';
                $fileDest = 'uploads/scan/desc/'.$jenis_document;
                Storage::makeDirectory($filePath);
                Storage::makeDirectory($fileDest);

                //Move file to storage
                $filename = md5(str_random(5)) . '.' . $ext;
                $url_filename = '';
                if (Storage::putFileAs($filePath, $file, $filename)) {
                    $url_filename = $filePath . '/' . $filename;
                }

                RenameFile::dispatch($url_filename,$regex,$jenis_document);

                return CRUDBooster::redirect(CRUDBooster::mainPath(), trans('crudbooster.alert_success'));

                //$url = CRUDBooster::mainpath('import-data').'?file='.base64_encode($url_filename);

                //return redirect($url);
            } else {
                return redirect()->back();
            }
        }

        public function getMulti()
        {
            $data = [];
            $data['page_title'] = 'Add Multiple Pages';
            $data['document'] = DB::table("regex")->get(['id','name','regex']);

            //Please use cbView method instead view method from laravel
            $this->cbView('scan/scan_multi_view',$data);
        }

        public function postAddMulti()
        {
            $page = Request::input("page");
            $post_jenis = Request::input("jenis_document");
            list($jenis_document,$regex) = explode("#",$post_jenis);
            if (Request::hasFile('file_ijazah')) {
                $file = Request::file('file_ijazah');
                $ext = $file->getClientOriginalExtension();

                $validator = Validator::make([
                    'extension' => $ext,
                ], [
                    'extension' => 'in:pdf,PDF',
                ]);

                if ($validator->fails()) {
                    $message = $validator->errors()->all();

                    return redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning']);
                }

                $filePath = 'uploads/scan/tmp';
                $fileDest = 'uploads/scan/split/'.$jenis_document;
                Storage::makeDirectory($filePath);
                Storage::makeDirectory($fileDest);

                //Move file to storage
                $filename = md5(str_random(5)).'.'.$ext;
                $url_filename = '';
                if (Storage::putFileAs($filePath, $file, $filename)) {
                    $url_filename = $filePath.'/'.$filename;
                }

                $split = new \App\Lib\SplitDocument($url_filename, $page, $fileDest, $regex, $jenis_document);
                $split->run();

                return CRUDBooster::redirect(CRUDBooster::mainPath(), trans('crudbooster.alert_success'));

            } else {
                return redirect()->back();
            }
        }

        public function postAddToken()
        {

        }

    }