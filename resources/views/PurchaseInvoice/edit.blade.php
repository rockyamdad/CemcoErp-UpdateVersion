@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Purchase Invoice  Section
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{URL::to('dashboard')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>

                <li>Edit Purchase Invoice</li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <div class="col-md-16">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i>Edit Purchase Invoice</div>
                <div class="actions">
                    <a class="btn dark" href="{{ URL::to('purchases/index') }}">Purchase Invoice List</a>
                </div>
            </div>
            <div class="portlet-body form">

               {!!Form::model($purchase[0],array('action' => array('PurchaseInvoiceController@postUpdate',
           $purchase[0]->invoice_id), 'method' => 'POST', 'class'=>'form-horizontal', 'id'=>'purchase_form'))!!}
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
                            <div class="form-group">
                                <div class="col-md-5">
                                    {!!Form::select('party_id',[null=>'Please Select Party'] + $suppliersAll,$purchase[0]->party_id, array('class'=>'form-control ','id'=>'edit_party_id') )!!}
                                </div>
                                <div class="col-md-5">
                                    {!!Form::select('branch_id',[null=>'Select branch'] +$branchAll,$purchaseDetails[0]->branch_id, array('class'=>'form-control branch_id_val','id'=>'edit_branch_id') )!!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    {!!Form::hidden('invoice_id',null,array('class' => 'form-control','id'=>'detail_invoice_id'))!!}
                                </div>
                            </div>

                            <div class="row">
                                <table class="table table-striped table-bordered table-primary table-condensed" id="purchaseTable">
                                    <thead>
                                        <tr>
                                            <th width="">Stock Name</th>
                                            <th width="">Product Type</th>
                                            <th width="">Product Name</th>
                                            <th width="">Price</th>
                                            <th width="">Quantity</th>
                                            <th width="">Remarks</th>
                                            <th width="">Action</th>
                                        </tr>

                                    </thead>

                                    @foreach($purchaseDetails as $purchaseDetail)
                                        <?php

                                        $branch = new \App\Branch();
                                        $stocks = new \App\StockInfo();
                                        $stockName = \App\StockInfo::find($purchaseDetail->stock_info_id);
                                        $branchName = \App\Branch::find($purchaseDetail->branch_id);
                                        ?>
                                        <tr>
                                            <td> {{ $stockName->name }}</td>
                                            <td> {{ $purchaseDetail->product_type }}</td>
                                            <td> {{ $purchaseDetail->product->name }}</td>
                                            <td> {{ $purchaseDetail->price }}</td>
                                            <td> {{ $purchaseDetail->quantity }}</td>
                                            <td>
                                                @if($purchaseDetail->remarks)
                                                {{ $purchaseDetail->remarks }}
                                                @else
                                                    {{"Not Available"}}
                                                @endif
                                            </td>
                                            <td> <input type="button"  style="width:70px;" value="delete" class="btn red deletePurchase" rel={{$purchaseDetail->id}} /></td>

                                        </tr>

                                    @endforeach
                                    <tbody>
                                    </tbody>
                                    <tr class="clone_">
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11 " style="width: 220px;">
                                                    {!!Form::select('stock_info_id',[null=>'Select Stock'] +$allStockInfos,'null', array('class'=>'form-control ','id'=>'stock_info_id') )!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 170px;">
                                                    {!! Form::select('product_type',[null=>'Select Type'] + array('Local' => 'Local', 'Foreign' =>
                                                    'Foreign','Finish Goods'=>'Finish Goods'),'null', array('class'=>'form-control type_val','id'=>'edit_product_type'))!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 300px;">
                                                    {!!Form::select('product_id',[null=>'Please Select Product'] +$localProducts,'null', array('class'=>'form-control ','id'=>'edit_product_id') )!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 100px;">
                                                    {!!Form::text('price',null,array('placeholder' => 'Price', 'class' =>
                                                    'form-control','id'=>'price'))!!}
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 100px;">
                                                    {!!Form::text('quantity',null,array('placeholder' => 'Quantity', 'class' =>
                                                    'form-control','id'=>'quantity'))!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 130px;">
                                                    {!!Form::text('remarks',null,array('placeholder' => 'Remarks', 'class' =>
                                                    'form-control','id'=>'remarks'))!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {!!Form::button('Add',array('type' => 'button','class' => 'btn blue editPurchaseInvoice' ,'rel'=>$purchase[0]->invoice_id))!!}
                                        </td>
                                    </tr>

                                </table>
                                <div class="form-group ">
                                    <label class="control-label col-md-4"></label>
                                    <div class="col-md-7 balance_show">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- END FORM-->
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
    {!! HTML::script('js/purchaseInvoice.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
@stop


