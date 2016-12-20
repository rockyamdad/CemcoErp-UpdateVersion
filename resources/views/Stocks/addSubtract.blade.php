@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Stock Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('stocks/create')}}">Make Stock</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Make Stock</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('stocks/index') }}">Stock List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::open(array('url' => '/saveStocks', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'stock_form'))!!}
            <div class="form-body">
                <div style="float: left;width: 80%; margin-left: 20px">
                    @if (Session::has('message'))
                    <div class="alert alert-success">
                        <button data-close="alert" class="close"></button>
                        {{ Session::get('message') }}
                    </div>
                    @endif
                </div>
                <div class="alert alert-danger display-hide">
                    <button data-close="alert" class="close"></button>
                    You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button data-close="alert" class="close"></button>
                    Your form validation is successful!
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('branch_id','Choose Branch<span class="required">*</span>',array('class'
                    => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('branch_id',[null=>'Please Select Branch'] +$branchAll,'null',
                        array('class'=>'form-control ','id'=>'products_branch_id') )!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('product_type','Product Type<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!! Form::select('product_type',[null=>'Please Select Type'] + array('Local' => 'Local', 'Foreign' =>
                        'Foreign','Finish Goods'=>'Finish Goods'),'null', array('class'=>'form-control','id'=>'product_type'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('stock_info_id','Choose Stocks<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!! Form::select('stock_info_id',[null=>'Please Select Stocks'] +$allStockInfos,'null', array('class'=>'form-control','id'=>'stock_info_id'))!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Choose Product<span class="required">*</span></label>

                    <div class="col-md-4">
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="">Select Product</option>
                        </select>

                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-4 available">
                        </div>
                </div>


                <div class="form-group">
                    {!!HTML::decode(Form::label('entry_type','Entry Type<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!! Form::select('entry_type',[null=>'Please Select Type'] + array('StockIn' => 'StockIn', 'StockOut' =>
                        'StockOut','Wastage'=>'Wastage','Transfer'=>'Transfer'),'null', array('class'=>'form-control','id'=>'entry_type'))!!}
                    </div>
                </div>

                <div class="form-group to_stock_section">
                    <label class='control-label col-md-3'>To Stock </label>
                    <div class="col-md-4">
                        <select class='form-control' id="to_stock_info_id" name='to_stock_info_id'>
                            <option value ='' >Select Stock </option>

                        </select>

                    </div>
                </div>



                <div class="form-group">
                     {!! HTML::decode(Form::label('product_quantity','Product Quantity<span class="required">*</span>',array('class'
                     => 'control-label col-md-3'))) !!}
                     <div class="col-md-4">
                         {!!Form::text('product_quantity',null,array('placeholder' => 'Product Quantity', 'class' =>
                         'form-control'))!!}
                     </div>
                 </div>

                <div class="form-group consignment_name_section">
                    <label class='control-label col-md-3'>Choose Consignment Name</label>

                    <div class="col-md-4">
                        <select class='form-control' id="consignment_name" name='consignment_name'>
                            <option value ='N/A' >N/A </option>
                        </select>

                    </div>
                </div>

                <div class="form-group">
                                    {!!HTML::decode(Form::label('remarks','Remarks',array('class' => 'control-label col-md-3')))!!}
                                    <div class="col-md-4">
                                        {!!Form::textarea('remarks',null,array('class' => 'form-control','id' => 'remarks', 'rows'=>'3'))!!}
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
</div>
    @stop
    @section('javascript')
    {!! HTML::script('js/stock.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

    @stop


