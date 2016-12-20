@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Product Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('products/create')}}">Add Product</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Add Product</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('products/index') }}">Products List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::open(array('url' => '/saveProducts', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'product_form'))!!}
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
                        array('class'=>'form-control ','id'=>'products_branch_id') )!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Choose Category<span class="required">*</span></label>

                    <div class="col-md-4">
                        <select id="products_category_id" name="category_id" class="form-control">
                            <option value="">Select Category</option>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Choose Sub Category</label>

                    <div class="col-md-4">
                        <select id="products_sub_category_id" name="sub_category_id" class="form-control">
                            <option value="">Select Sub Category</option>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('name','Product Name<span class="required">*</span>',array('class' =>
                    'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('name',null,array('placeholder' => 'Name', 'class' => 'form-control','id' =>
                        'name'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('product_type','Product Type<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!! Form::select('product_type',[null=>'Please Select Type'] + array('Local' => 'Local', 'Foreign' =>
                        'Foreign','Finish Goods'=>'Finish Goods'),'null', array('class'=>'form-control'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!! HTML::decode(Form::label('price','Product Price',array('class' =>
                    'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('price',null,array('placeholder' => '0', 'class' => 'form-control','id' =>
                        'price'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!! HTML::decode(Form::label('hs_code','HS Code',array('class' =>
                    'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('hs_code',null,array('placeholder' => 'HS Code', 'class' => 'form-control'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('origin','Origin Name',array('class' => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('origin',null,array('placeholder' => 'Origin Name', 'class' => 'form-control'))!!}
                    </div>
                </div>
               <!-- <div class="form-group">
                    {!! HTML::decode(Form::label('total_quantity','Total Quantity<span class="required">*</span>',array('class'
                    => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('total_quantity',null,array('placeholder' => 'Total Quantity', 'class' =>
                        'form-control'))!!}
                    </div>
                </div>-->


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
    {!! HTML::script('js/products.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

    @stop


