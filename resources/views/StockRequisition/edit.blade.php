@extends('baseLayout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Order Requisition Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('requisitions/create')}}">Make Order Requisition</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="col-md-16">
    <!-- BEGIN VALIDATION STATES-->
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="fa fa-reorder"></i>Make Order Requisition</div>
            <div class="actions">
                <a class="btn dark" href="{{ URL::to('requisitions/index') }}">Order Requisition List</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!!Form::open(array('url' => '/saveStockRequisitions', 'method' => 'post', 'class'=>'form-horizontal',
            'id'=>'stock_requisition_form'))!!}
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
                <div class="portlet-body form" id="testt">
                    <!-- BEGIN FORM-->
                    <div class="form-body">
                        {!!Form::hidden('requisition_id',null,array('class' => 'form-control','id'=>'requisition_id'))!!}

                        <div class="row">
                            <table class="table table-striped table-bordered table-primary table-condensed" id="requisitionTable">
                                <thead>
                                <tr>
                                    <th width="">Branch Name</th>
                                    <th width="">Party Name</th>
                                    <th width="">Product Name</th>
                                    <th width="">Quantity</th>
                                    <th width="">Remarks</th>
                                    <th width="">Action</th>
                                </tr>

                                </thead>
                                <tbody>

                                </tbody>
                                @if($stockRequisition)
                                    <?php
                                        $branchName = \App\Branch::find($stockRequisition->branch_id);
                                            ?>
                                        <tr>
                                            <td>{{$branchName->name}}</td>
                                            <td>{{$stockRequisition->party->name}}</td>
                                            <td>{{$stockRequisition->product->name}}</td>
                                            <td>{{$stockRequisition->requisition_quantity}}</td>
                                            <td>{{$stockRequisition->remarks}}</td>
                                            <td><input type="button"  id="deleteRequisition" style="width:70px;" value="delete" class="btn red deleteRequisitionEdit" rel="{{ $stockRequisition->id }}" ></td>

                                        </tr>
                                @endif
                                <tr class="clone_">

                                    <td>
                                        <div class="form-group">
                                            <div class="col-md-11">
                                                {!!Form::select('branch_id',[null=>'Please Select Branch'] + $branchAll,'null', array('class'=>'form-control branch_id','id'=>'edit_branch_id') )!!}
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                    <div class="form-group">
                                            <div class="col-md-11">
                                                {!!Form::select('party_id',[null=>'Please Select Party'] + $partyAll,'null', array('class'=>'form-control ','id'=>'party_id') )!!}
                                            </div>
                                        </div>

                                    </td>
                                    <td> <div class="form-group">
                                            <div class="col-md-11">
                                                {!!Form::select('product_id',[null=>'Please Select Product'] +$productAll,'null', array('class'=>'form-control ','id'=>'product_id') )!!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-md-11">
                                                {!!Form::text('requisition_quantity',null,array('placeholder' => 'Quantity', 'class' =>
                                                'form-control','id'=>'requisition_quantity'))!!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-md-11">
                                                {!!Form::text('remarks',null,array('placeholder' => 'Remarks', 'class' =>
                                                'form-control'))!!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {!!Form::button('Add',array('type' => 'button','class' => 'btn blue','id' => 'saveRequisitionEdit'))!!}
                                    </td>
                                </tr>
                            </table>
                        </div>
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
    {!! HTML::script('js/stockRequisition.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

    @stop


