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

            <li>Edit Import Details Information</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Edit Import Details Information</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('imports/index') }}">Import List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::model($import,array('action' => array('ImportController@postUpdateDetails', $import->id), 'method' =>
            'POST', 'class'=>'form-horizontal', 'id'=>'imports_details_form'))!!}
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button data-close="alert" class="close"></button>
                    You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button data-close="alert" class="close"></button>
                    Your form validation is successful!
                </div>
                {!! Form::hidden('import_num',$import->import_num) !!}
                <div class="form-group">
                    {!!HTML::decode(Form::label('product_id','Choose Product <span class="required">*</span>',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('product_id',[null=>'Please Select Product'] +$productAll,$import->product_id, array('class'=>'form-control ','id'=>'product_id') )!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('quantity','Quantity<span class="required">*</span>',array('class' => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('quantity',null,array('placeholder' => 'Quantity', 'class' => 'form-control','id' => 'quantity'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('total_booking_price','Total Booking Price',array('class' => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('total_booking_price',null,array('placeholder' => 'Total Booking Price', 'class' => 'form-control','id' => 'total_booking_price'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('total_cfr_price','Total CFR Price',array('class' => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('total_cfr_price',null,array('placeholder' => 'Total CFR Price', 'class' => 'form-control','id' => 'total_cfr_price'))!!}
                    </div>
                </div>

                <div class="form-actions fluid">
                    <div class="col-md-offset-3 col-md-9">
                        {!!Form::button('Save',array('type' => 'submit','class' => 'btn green','id' => 'save'))!!}
                        {!!Form::button('Cancel',array('type'=>'reset', 'class' => 'btn default','id' => 'cancel'))!!}

                    </div>
                </div>
                {!!Form::close()!!}
            </div>
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


