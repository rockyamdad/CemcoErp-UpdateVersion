@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@stop
@section('content')


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Sales Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('sales/index')}}"> Sales List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Sales</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div style="float: left;width: 80%; margin-left: 20px">
                @if (Session::has('message'))
                <div class="alert alert-success">
                    <button data-close="alert" class="close"></button>
                    {{ Session::get('message') }}
                </div>
                @endif
            </div>

            <div class="portlet-body">

                <div class="table-toolbar">
                    <div class="btn-group">
                        <a class="btn green" href="{{ URL::to('sales/create') }}">Create Sales Invoice&nbsp;&nbsp;<i
                                class="fa fa-plus"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn purple makePayment"   data-toggle="modal"  data-target="#salePayment2" href="{{ URL::to('sales/makeall/') }}" >
                            <i class="fa fa-plus"></i>Make Payment</a>
                    </div>

                </div>
                {!!Form::open(array('action'=>'SaleController@getIndex','method' => 'get', 'class'=>'form-horizontal'
                ))!!}
                <div class="form-group">

                    <div class="col-md-4">
                        {!!Form::select('invoice_id',[null=>'Please Select Invoice'] +$allInvoices,'null', array('class'=>'form-control ','id'=>'invoice_id') )!!}
                    </div>
                    <div class=" fluid">
                        <div class=" col-md-3">
                            <button type="submit" class="btn blue btn-block " >SEARCH <i class="m-icon-swapright m-icon-white"></i></button>
                        </div>
                    </div>

                </div>

                {!!Form::close()!!}

                <table class="table table-striped table-bordered table-hover" id="salestable">
                    <thead  style="background-color: #557386">
                    <tr>
                        <th>SL</th>
                        <th>Sales Invoice Id</th>
                        <th>Party Name</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $sl=1;
                    ?>
                    @if(count($saleInvoice)>0)
                        @foreach($saleInvoice as $sale )
                            <?php
                            $hasDetails = \App\SAleDetail::where('invoice_id','=',$sale->invoice_id)->get();
                            ?>
                            @if(count($hasDetails) > 0)
                                <tr class="odd gradeX">
                                    <td><?php echo $sl; ?></td>
                                    <td>{{$sale->invoice_id}}</td>
                                    <td>{{$sale->party->name}}</td>
                                    @if($sale->status == 'Activate')
                                        <td><span class="label label-sm label-danger">Due</span></td>
                                    @elseif($sale->status == 'Partial')
                                        <td><span class="label label-sm label-warning">Partial</span></td>
                                    @elseif($sale->status == 'Completed')
                                        <td><span class="label label-sm label-success">Completed</span></td>
                                    @endif
                                    <td>{{$sale->user->username}}</td>

                                    <td>
                                        @if( Session::get('user_role') == "admin")
                                            @if($sale->is_sale != 1)
                                                <a class="btn blue btn-sm"  href="{{ URL::to('sales/edit/'. $sale->invoice_id ) }}"><i
                                                            class="fa fa-edit"></i>Edit </a>
                                                <a class="btn green btn-sm sale" style="background-color:#009999" rel="{{ $sale->invoice_id }}"  href="{{ URL::to('sales/sale/'. $sale->invoice_id ) }}" onclick="return confirm('Are you sure you want to Sale this item? ');">
                                                    Sale</a>
                                            @endif
                                            <a class="btn dark btn-sm" rel="{{ $sale->invoice_id }}" data-toggle="modal"  data-target="#sale" href="{{ URL::to('sales/details/'. $sale->invoice_id ) }}" >
                                                <i class="fa fa-eye"></i> Detail</a>

                                            @if($sale->status != 'Completed' && $sale->is_sale == 1)
                                                <a class="btn blue btn-sm" style="background-color:chartreuse" href="{{ URL::to('sales/showinvoice/'. $sale->invoice_id ) }}">Show Invoice</a>
                                                <a class="btn purple btn-sm makePayment"  rel="{{ $sale->invoice_id }}" data-toggle="modal"  data-target="#salePayment" href="{{ URL::to('sales/make/'.$sale->invoice_id) }}" >
                                                    <i class="fa fa-usd"></i> Payment</a>
                                                <span class="label label-sm label-success">SoldOut</span>
                                            @endif
                                            @if($sale->is_sale != 1)
                                                <a class="btn red btn-sm" href="{{ URL::to('sales/delete/'.$sale->invoice_id)}}"
                                                   onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                            class="fa fa-trash-o"></i> Delete</a>
                                            @endif
                                        @endif


                                    </td>

                                </tr>
                                <?php
                                $sl++;
                                ?>
                            @endif
                        @endforeach

                    @else
                        @foreach($sales as $sale )
                            <?php
                            $hasDetails = \App\SAleDetail::where('invoice_id','=',$sale->invoice_id)->get();
                            ?>
                            @if(count($hasDetails) > 0)
                                <tr class="odd gradeX">
                                    <td><?php echo $sl; ?></td>
                                    <td>{{$sale->invoice_id}}</td>
                                    <td>{{$sale->party->name}}</td>
                                    @if($sale->status == 'Activate')
                                        <td><span class="label label-sm label-danger">Due</span></td>
                                    @elseif($sale->status == 'Partial')
                                        <td><span class="label label-sm label-warning">Partial</span></td>
                                    @elseif($sale->status == 'Completed')
                                        <td><span class="label label-sm label-success">Completed</span></td>
                                    @endif
                                    <td>{{$sale->user->username}}</td>

                                    <td>
                                        @if( Session::get('user_role') == "admin")
                                            @if($sale->is_sale != 1)
                                                <a class="btn blue btn-sm"  href="{{ URL::to('sales/edit/'. $sale->invoice_id ) }}"><i
                                                            class="fa fa-edit"></i>&nbsp;&nbsp; Edit &nbsp</a>
                                                <a class="btn green btn-sm sale" style="background-color:#009999" rel="{{ $sale->invoice_id }}"  href="{{ URL::to('sales/sale/'. $sale->invoice_id ) }}" onclick="return confirm('Please confirm terms & conditions & discount. By confirming this you will not be able to edit this invoice later.');">
                                                    Confirm</a>
                                            @endif
                                                <a class="btn dark btn-sm" rel="{{ $sale->invoice_id }}" data-toggle="modal"  data-target="#sale" href="{{ URL::to('sales/details/'. $sale->invoice_id ) }}" >
                                                    <i class="fa fa-eye"></i> Detail</a>



                                            @if($sale->status != 'Completed' && $sale->is_sale == 1)
                                                    <a class="btn blue btn-sm" href="{{ URL::to('sales/showinvoice/'. $sale->invoice_id ) }}">Invoice&nbsp;</a>
                                                    <a class="btn blue btn-sm" href="{{ URL::to('sales/showinvoice2/'. $sale->invoice_id ) }}">&nbsp;&nbsp;Chalan&nbsp;</a>
                                                <a class="btn purple btn-sm makePayment"  rel="{{ $sale->invoice_id }}" data-toggle="modal"  data-target="#salePayment" href="{{ URL::to('sales/make/'.$sale->invoice_id) }}" >
                                                    <i class="fa fa-usd"></i>&nbsp&nbsp&nbsp Pay &nbsp&nbsp</a>
                                                <span class="label label-sm label-success">SoldOut</span>
                                            @endif
                                            @if($sale->is_sale != 1)
                                                <a class="btn red btn-sm" href="{{ URL::to('sales/delete/'.$sale->invoice_id)}}"
                                                   onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                            class="fa fa-trash-o"></i> Delete</a>
                                            @endif
                                        @endif


                                    </td>

                                </tr>
                                <?php
                                $sl++;
                                ?>
                            @endif
                        @endforeach
                    @endif


                    </tbody>
                </table>

            </div>
        </div>
        @if(count($saleInvoice)>0)
            <center>
            <div class="actions">
                <a class="btn blue" href="/sales">Back</a>
                {{--   <a class="btn dark" href="">Print</a>--}}
            </div>
            </center>
        @endif


        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
{!! $sales->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/sales.js') !!}
{!! HTML::script('js/partilizer.js') !!}
{!! HTML::script('assets/plugins/select2/select2.min.js') !!}
{!! HTML::script('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
@stop
