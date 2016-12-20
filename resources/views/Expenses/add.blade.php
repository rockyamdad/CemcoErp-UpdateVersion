@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Expense Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('expenses/create')}}">Make Expense</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Make Expense</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('expenses/index') }}">Expense List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::open(array('url' => '/saveExpense', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'expense_form'))!!}
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
                        array('class'=>'form-control ','id'=>'branch_id') )!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('category','Expense Category<span class="required">*</span>',array('class' =>
                    'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!! Form::select('category',[null=>'Please Select category'] + array('Office' => 'Office Expense', 'Rent' =>
                        'Rent Expense','Others '=>'Other Expense'),'null', array('class'=>'form-control','id'=>'category'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('particular','Particular',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('particular',null,array('class' => 'form-control','id' => 'particular', 'rows'=>'3'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!HTML::decode(Form::label('purpose','Purpose',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('purpose',null,array('class' => 'form-control','id' => 'purpose', 'rows'=>'3'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! HTML::decode(Form::label('amount','Amount<span class="required">*</span>',array('class'
                    => 'control-label col-md-3'))) !!}
                    <div class="col-md-4">
                        {!!Form::text('amount',null,array('placeholder' => 'Amount', 'class' =>
                        'form-control','id'=>'amount'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!HTML::decode(Form::label('remarks','Remarks',array('class' => 'control-label col-md-3')))!!}
                    <div class="col-md-4">
                        {!!Form::textarea('remarks',null,array('class' => 'form-control','id' => 'remarks', 'rows'=>'3'))!!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-5">
                        {!!Form::hidden('invoice_id',$invoiceid,array('class' => 'form-control','id'=>'invoice_id'))!!}
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
    {!! HTML::script('js/expenses.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

    @stop


