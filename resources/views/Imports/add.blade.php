@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/jquery-tags-input/jquery.tagsinput.css') }}" />

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

            <li><a href="{{URL::to('imports/create')}}">Add Import Information</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Add Import Information</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('imports/index') }}">Import List</a>
            </div>
        </div>
        <div class="portlet-body form">

            <ul  class="nav nav-tabs" id="importAddTab">
                <li class="active"><a href="#importAdd" data-toggle="tab">Import Info</a></li>
             {{--   <li class=""><a href="#ImportDetailsAdd" data-toggle="tab">Import Details</a></li>--}}
            </ul>
            <div  class="tab-content">
                @include('Imports.partial_addImport')
{{--
                @include('Imports.partial_addImportDetails')
--}}
            </div>
        </div>
  </div>
    @stop
    @section('javascript')
    {!! HTML::script('js/imports.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    @stop


