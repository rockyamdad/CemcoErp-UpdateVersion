@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>
<link rel="stylesheet" type="text/css"
      href="{{ URL::asset('assets/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}"/>
<link rel="stylesheet" type="text/css"
      href="{{ URL::asset('assets/plugins/jquery-tags-input/jquery.tagsinput.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />


@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Import Cost Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>Add Import Cost Information</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
    <div style="float: left;width: 80%; margin-left: 20px">
        @if (Session::has('message'))
            <div class="alert alert-success">
                <button data-close="alert" class="close"></button>
                {{ Session::get('message') }}
            </div>
        @endif
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Add Import Cost Information</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('imports/index') }}">Import List</a>
            </div>
        </div>

        <div class="portlet-body form">

            <ul class="nav nav-tabs " id="importCostTab">
                @if($importProformaInvoice->isEmpty())
                <li class="active"><a href="#proformaInvoice" data-toggle="tab">Add Proforma Invoice</a></li>
                @endif
                @if($importBankCost->isEmpty())
                <li class=""><a href="#bankCost" data-toggle="tab">Add Bank Cost</a></li>
                @endif
                @if($importCnfCost->isEmpty())
                <li class=""><a href="#cnfCost" data-toggle="tab">Add CNF Cost</a></li>
                @endif
                @if($importOtherCost->isEmpty())
                <li class=""><a href="#otherCost" data-toggle="tab">Add Others Cost</a></li>
                @endif

            </ul>

            <!-- BEGIN FORM-->
            <div class="tab-content">

                @if($importProformaInvoice->isEmpty())
                @include('Imports.partial_addProformaInvoice')
                @endif

                @if($importBankCost->isEmpty())
                @include('Imports.partial_addBankCost')
                @endif

                @if($importCnfCost->isEmpty())
                @include('Imports.partial_addCnfCost')
                @endif

                @if($importOtherCost->isEmpty())
                @include('Imports.partial_addOtherCost')
                @endif

            </div>
        </div>
    </div>
</div>

@stop
@section('javascript')

{!! HTML::script('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('js/imports.js') !!}
@stop

