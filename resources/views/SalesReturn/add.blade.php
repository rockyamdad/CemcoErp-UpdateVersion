@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Sales Return Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('salesreturn/create')}}">Return Sales</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Sales Return</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('salesreturn/index') }}">Sales Return List</a>
            </div>
        </div>
        <div class="portlet-body form">
            @if ($errors->has())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            {!!Form::open(array('url' => '/saveSalesReturn', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'sales_return_form'))!!}
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
                    {!!HTML::decode(Form::label('party_id','Choose Party<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!! Form::select('party_id',[null=>'Please Select Party'] + $partyAll,'null', array('class'=>'form-control','id'=>'party_id'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('cus_ref_no','Party Ref No<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::text('cus_ref_no',null,array('placeholder' => 'Reference No', 'class' =>'form-control'))!!}
                    </div>
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
                                    <label class="control-label col-md-3">Choose Product<span class="required">*</span></label>

                                    <div class="col-md-4">
                                        <select id="product_id" name="product_id" class="form-control">
                                            <option value="">Select Product</option>
                                        </select>

                                    </div>
                                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('quantity','Quantity<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::text('quantity',null,array('placeholder' => 'Quantity', 'class' =>'form-control'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('return_amount','Total Return Amount<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::text('return_amount',null,array('placeholder' => 'Return Amount', 'class' =>'form-control'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('consignment_name','Consignment No<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('consignment_name',[null=>'Please Select Consignment'] +$consignmentAll,'null',array('class'=>'form-control ','id'=>'products_branch_id') )!!}
                    </div>
                </div>

                <div class="form-group ">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-4 available">
                        </div>
                </div>


                <div class="form-group">
                    {!!HTML::decode(Form::label('remarks','Remarks',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('remarks',null,array('class' => 'form-control','id' => 'remarks',
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
</div>
    @stop
    @section('javascript')
    {!! HTML::script('js/salesReturn.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

    @stop


