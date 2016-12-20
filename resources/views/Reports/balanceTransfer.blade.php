@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Balance Transfer Report Search
            </h3>

            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>

    <div class="col-md-16">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i>Balance Transfer Report Search</div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {!!Form::open(array('url' => 'balance-transfer-report', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'expense_report_form'))!!}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button data-close="alert" class="close"></button>
                        You have some form errors. Please check below.
                    </div>

                    <div class="form-group">
                        {!!HTML::decode(Form::label('from_account_id','Choose Account 1<span class="required">*</span>',array('class'
                        => 'control-label col-md-3')))!!}
                        <div class="col-md-4">
                            {!!Form::select('from_account_id',[null=>'Please Select Account'] +$accountAll,'null',
                            array('class'=>'form-control ','id'=>'from_account_id') )!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!HTML::decode(Form::label('to_account_id','Choose Account 2<span class="required">*</span>',array('class'
                        => 'control-label col-md-3')))!!}
                        <div class="col-md-4">
                            {!!Form::select('to_account_id',[null=>'Please Select Account'] +$accountAll,'null',
                            array('class'=>'form-control ','id'=>'to_account_id') )!!}
                        </div>
                    </div>

                    <div class="form-actions fluid">
                        <div class="col-md-offset-3 col-md-3">
                            <button type="submit" class="btn blue btn-block margin-top-10" style="margin-left: 35px;">SEARCH <i class="m-icon-swapright m-icon-white"></i></button>
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
    {!! HTML::script('js/report.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
@stop


