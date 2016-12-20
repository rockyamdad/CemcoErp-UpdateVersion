@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Import Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>Edit Import Information</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Edit Import Information</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('imports/index') }}">Import List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::model($import,array('action' => array('ImportController@postUpdate', $import->id), 'method' =>
            'POST', 'class'=>'form-horizontal', 'id'=>'imports_form'))!!}
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button data-close="alert" class="close"></button>
                    You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button data-close="alert" class="close"></button>
                    Your form validation is successful!
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('branch_id',' Branch<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('branch_id',[null=>'Please Select
                        Branch']+$branchAll,$import->branch_id,array('class'=>'form-control ','id'=>'branch_id') )!!}
                    </div>
                </div>
                {!! Form::hidden('import_num',$import->import_num) !!}
                <div class="form-group">
                    {!! HTML::decode(Form::label('consignment_name','Consignment Name<span class="required">*</span>',array('class' => 'control-label
                    col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('consignment_name',null,array('placeholder' => 'Consignment Name', 'class' =>
                        'form-control','id' => 'consignment_name'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('description','Description',array('class' => 'control-label
                    col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('description',null,array('class' => 'form-control','id' => 'description',
                        'rows'=>'3'))!!}
                    </div>
                </div>

                <div class="form-actions fluid">
                    <div class="col-md-offset-3 col-md-9">
                        {!!Form::button('Save',array('type' => 'submit','class' => 'btn green','id' => 'save'))!!}
                        {!!Form::button('Cancel',array('type'=>'reset', 'class' => 'btn default','id' => 'cancel'))!!}

                    </div>
                </div>
                {!!Form::close()!!}
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
    @stop
    @section('javascript')
    {!! HTML::script('js/imports.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    @stop


