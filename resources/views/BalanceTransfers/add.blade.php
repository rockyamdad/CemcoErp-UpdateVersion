@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Balance Transfer Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('balancetransfers/create')}}">Make Balance Transfer</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Make Balance Transfer</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('balancetransfers/index') }}">Balance Transfer List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::open(array('url' => '/saveTransfers', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'balance_transfer_form'))!!}
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
                    {!!HTML::decode(Form::label('from_branch_id','From Branch<span class="required">*</span>',array('class'
                    => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('from_branch_id',[null=>'Please Select Branch'] +$branchAll,'null',
                        array('class'=>'form-control ','id'=>'from_branch_id') )!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('from_account_category_id','From Account Category<span class="required">*</span>',array('class'
                    => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('from_account_category_id',[null=>'Please Select Account Category'] +$accountCategoriesAll,'null', array('class'=>'form-control','id'=>'from_account_category_id') )!!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">From Account Name<span class="required">*</span></label>

                    <div class="col-md-4">
                        <select id="from_account_name_id" name="from_account_name_id" class="form-control">
                            <option value="">Select Account Name</option>
                        </select>
                    </div>
                </div>

                <div class="form-group ">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-4 balance_show">
                        </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('to_branch_id','To Branch<span class="required">*</span>',array('class'
                    => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('to_branch_id',[null=>'Please Select Branch'] +$branchAll,'null',
                        array('class'=>'form-control ','id'=>'to_branch_id') )!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('to_account_category_id','To Account Category<span class="required">*</span>',array('class'
                    => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::select('to_account_category_id',[null=>'Please Select Account Category'] +$accountCategoriesAll,'null', array('class'=>'form-control','id'=>'to_account_category_id') )!!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">To Account Name<span class="required">*</span></label>

                    <div class="col-md-4">
                        <select id="to_account_name_id" name="to_account_name_id" class="form-control">
                            <option value="">Select Account Name</option>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-4 balance_show2">
                    </div>
                </div>

                <div class="form-group">
                     {!! HTML::decode(Form::label('amount','Amount<span class="required">*</span>',array('class'
                     => 'control-label col-md-3'))) !!}
                     <div class="col-md-4">
                         {!!Form::text('amount',null,array('placeholder' => 'Amount', 'class' =>
                         'form-control'))!!}
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
    {!! HTML::script('js/balancetransfer.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

    @stop


