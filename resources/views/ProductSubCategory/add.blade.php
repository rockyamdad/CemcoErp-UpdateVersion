@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Product SubCategory Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('productsubcategories/create')}}">Add SubCategory</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Add SubCategory</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('productsubcategories/index') }}">Product SubCategory List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::open(array('url' => '/saveProductSubCategory', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'sub_category_form'))!!}
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
                    {!!HTML::decode(Form::label('branch_id','Product Branch<span class="required">*</span>',array('class'
                    => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('branch_id',[null=>'Please Select Branch'] +$branchAll,'null',
                        array('class'=>'form-control ','id'=>'add_branch_id') )!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Category<span class="required">*</span></label>

                    <div class="col-md-4">
                        <select id="add_category_id" name="category_id" class="form-control">
                            <option value="">Select Category</option>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('name','Sub Category Name<span class="required">*</span>',array('class'
                    => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('name',null,array('placeholder' => 'Name', 'class' => 'form-control','id' =>
                        'name'))!!}
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
    {!! HTML::script('js/productSubCategories.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
    @stop


