<!-- First, extends to the CRUDBooster Layout -->
{{--@extends('crudbooster::admin_template')--}}
{{--@section('content')--}}
    <!-- Your html goes here -->
<div class='modal' id='modal-add'>
    <div class="modal-dialog modal-sm">
        <div class='panel panel-default'>
            <div class='panel-heading'>Add Scan Ijazah</div>
            <form method='post' action='{{CRUDBooster::mainpath('add-save')}}' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class='panel-body'>
                    <div class='form-group'>
                        <label>Jenis Document</label>
                        <select class="form-control" name="jenis_document">
                            @foreach($document as $field_name)
                                <option value = "{{ $field_name->id }}#{{ $field_name->regex }}" selected >{{ $field_name->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
    </div>
</div>

<div class='modal' id='modal-add-multi'>
    <div class="modal-dialog modal-sm">
        <div class='panel panel-default'>
            <div class='panel-heading'>Add Scan Ijazah</div>
            <form method='post' action='{{CRUDBooster::mainpath('add-multi')}}' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class='panel-body'>
                    <div class='form-group'>
                        <label>Jenis Document</label>
                        <select class="form-control" name="jenis_document">
                            @foreach($document as $field_name)
                                <option value = "{{ $field_name->id }}#{{ $field_name->regex }}" selected >{{ $field_name->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label>Page</label>
                        <select class="form-control" name="page">
                            @for ($i = 1; $i < 4; $i++)
                                <option value = "{{ $i }}" >{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
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
    </div>
</div>
{{--@endsection--}}