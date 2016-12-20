@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}" />
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Branch Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('list')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>Edit Branch</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Edit Branch</div>
            <div class="actions">
                <a class="btn" href="{{ URL::to('branchList') }}">Branch List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::model($branch,array('action' => array('BranchController@postUpdate', $branch->id), 'method' => 'POST', 'class'=>'form-horizontal', 'id'=>'branch_form'))!!}

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
                    {!! HTML::decode(Form::label('name','Name',array('class' => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('name',null,array('placeholder' => 'Name', 'class' => 'form-control','id' => 'name'))!!}
                    </div>
                </div>


                <div class="form-group">
                    {!!HTML::decode(Form::label('location','Location',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('location',null,array('class' => 'form-control','id' => 'location', 'rows'=>'3'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('description','Description',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('description',null,array('class' => 'form-control','id' => 'description', 'rows'=>'3'))!!}
                    </div>
                </div>

                <div class="form-actions fluid">
                    <div class="col-md-offset-3 col-md-9">
                        {!!Form::button('Update',array('type' => 'submit','class' => 'btn green','id' => 'save'))!!}
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
    {!! HTML::script('js/branches.js') !!}
    @stop


