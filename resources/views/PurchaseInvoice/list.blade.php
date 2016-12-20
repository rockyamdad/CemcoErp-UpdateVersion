@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Purchase Invoice Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('purchases/index')}}"> Purchase Invoice List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i> Purchase Invoice</div>
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
                        <a class="btn green" href="{{ URL::to('purchases/create') }}">Make  Purchase Invoice&nbsp;&nbsp;<i
                                class="fa fa-plus"></i></a>

                    </div>

                    <div class="btn-group">
                        <a class="btn purple makePayment"   data-toggle="modal"  data-target="#salePayment2" href="{{ URL::to('purchases/makeall/') }}" >
                            <i class="fa fa-plus"></i>Make Payment</a>
                    </div>

                </div>
                {!!Form::open(array('action'=>'PurchaseInvoiceController@getIndex','method' => 'get', 'class'=>'form-horizontal'
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
                <table class="table table-striped table-bordered table-hover" id="Purchasetable">
                    <thead  style="background-color: #557386">
                    <tr>
                        <th>SL</th>
                        <th>Invoice Id</th>
                        <th>Party</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @if(count($purchaseInvoice)>0)
                        @foreach($purchaseInvoice as $purchase )
                            <?php
                            $hasDetails = \App\PurchaseInvoiceDetail::where('detail_invoice_id','=',$purchase->invoice_id)->get();
                            ?>
                            @if(count($hasDetails) > 0)
                        <tr class="odd gradeX">
                            <td><?php echo $sl; ?></td>
                            <td>{{$purchase->invoice_id}}</td>
                            <td>{{$purchase->party->name}}</td>
                            @if($purchase->status == 'Activate')
                                <td><span class="label label-sm label-danger">Due</span></td>
                            @elseif($purchase->status == 'Partial')
                                <td><span class="label label-sm label-warning">Partial</span></td>
                            @elseif($purchase->status == 'Completed')
                                <td><span class="label label-sm label-success">Completed</span></td>
                            @endif
                            <td>{{$purchase->user->username}}</td>

                           <td>
                                @if( Session::get('user_role') == "admin")
                                <a class="btn blue btn-sm"  href="{{ URL::to('purchases/edit/'. $purchase->invoice_id ) }}"><i
                                        class="fa fa-edit"></i>Edit Product</a>
                                <a class="btn dark btn-sm " rel="{{ $purchase->invoice_id }}" data-toggle="modal"  data-target="#purchaseInvoice" href="{{ URL::to('purchases/details/'. $purchase->invoice_id ) }}" >
                                    <i class="fa fa-eye"></i> Detail</a>
                                   @if($purchase->status != 'Completed')
                                       <a class="btn purple btn-sm makePayment"  rel="{{ $purchase->invoice_id }}" data-toggle="modal"  data-target="#purchasePayment" href="{{ URL::to('purchases/make/'.$purchase->invoice_id) }}" >
                                           <i class="fa fa-usd"></i> Payment</a>
                                   @endif

                                <a class="btn red btn-sm" href="{{ URL::to('purchases/del/'.$purchase->invoice_id)}}"
                                   onclick="return confirm('Are you sure you want to delete this item?');"><i
                                        class="fa fa-trash-o"></i> Delete</a>

                                @endif


                            </td>

                        </tr>
                        <?php
                        $sl++;
                        ?>
                            @endif
                        @endforeach
                    @else
                        @foreach($purchases as $purchase )
                            <?php
                            $hasDetails = \App\PurchaseInvoiceDetail::where('detail_invoice_id','=',$purchase->invoice_id)->get();
                            ?>
                            @if(count($hasDetails) > 0)
                                <tr class="odd gradeX">
                                    <td><?php echo $sl; ?></td>
                                    <td>{{$purchase->invoice_id}}</td>
                                    <td>{{$purchase->party->name}}</td>
                                    @if($purchase->status == 'Activate')
                                        <td><span class="label label-sm label-danger">Due</span></td>
                                    @elseif($purchase->status == 'Partial')
                                        <td><span class="label label-sm label-warning">Partial</span></td>
                                    @elseif($purchase->status == 'Completed')
                                        <td><span class="label label-sm label-success">Completed</span></td>
                                    @endif
                                    <td>{{$purchase->user->username}}</td>

                                    <td>
                                        @if( Session::get('user_role') == "admin")
                                            <a class="btn blue btn-sm"  href="{{ URL::to('purchases/edit/'. $purchase->invoice_id ) }}"><i
                                                        class="fa fa-edit"></i>Edit Product</a>
                                            <a class="btn dark btn-sm " rel="{{ $purchase->invoice_id }}" data-toggle="modal"  data-target="#purchaseInvoice" href="{{ URL::to('purchases/details/'. $purchase->invoice_id ) }}" >
                                                <i class="fa fa-eye"></i> Detail</a>
                                            @if($purchase->status != 'Completed')
                                                <a class="btn purple btn-sm makePayment"  rel="{{ $purchase->invoice_id }}" data-toggle="modal"  data-target="#purchasePayment" href="{{ URL::to('purchases/make/'.$purchase->invoice_id) }}" >
                                                    <i class="fa fa-usd"></i> Payment</a>
                                            @endif

                                            <a class="btn red btn-sm" href="{{ URL::to('purchases/del/'.$purchase->invoice_id)}}"
                                               onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                        class="fa fa-trash-o"></i> Delete</a>

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

        @if(count($purchaseInvoice)>0)
            <center>
                <div class="actions">
                    <a class="btn blue" href="/purchases">Back</a>
                    {{--   <a class="btn dark" href="">Print</a>--}}
                </div>
            </center>
            @endif
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
{!! $purchases->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/purchaseInvoice.js') !!}
{!! HTML::script('js/partilizer.js') !!}
{!! HTML::script('assets/plugins/select2/select2.min.js') !!}

@stop
