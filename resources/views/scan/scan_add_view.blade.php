<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
    <!-- Your html goes here -->
    <div class='panel panel-default'>
        <div class='panel-heading'>Add Scan Ijazah</div>
        <form method='post' action='{{CRUDBooster::mainpath('add-save')}}' enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <div class='panel-body'>

                <div class='form-group'>
                    <label>Upload File Ijazah</label>
                    <input type='file' name='file_ijazah' required class='form-control'/>
                </div>
        </div>
        <div class='panel-footer'>
            <input type='submit' class='btn btn-primary' value='Save changes'/>
        </div>
        </form>
    </div>
@endsection