@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Cheque Register Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('chequeregister/index')}}">{{$type}} Cheque Register List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Cheque Register</div>
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


                <div class="table-responsive">

                <table class="table" id="user_table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Party Name</th>
                            <th>Bank Name</th>
                            <th>Cheque No</th>
                            <th>Cheque Date</th>
                            <th>Amount</th>
                            <th>Received By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($register as $reg )
                        <?php
                        if($reg->type=='Payment'){
                            $sale = \App\PurchaseInvoice::where('invoice_id','=',$reg->invoice_id)->first();
                            $partyname = \App\Party::find($sale->party_id);
                        } else {
                            $sale = \App\Expense::where('invoice_id','=',$reg->invoice_id)->first();
                        }

                        ?>
                    <tr class="odd gradeX">
                        <td><?php echo $sl; ?></td>
                        <td><?php if($reg->type=='Payment'){ ?>{{$partyname->name}} <?php } else echo "Expense"; ?></td>
                        <td>{{$reg->cheque_bank}}</td>
                        <td>{{$reg->cheque_no}}</td>
                        <td>@if($reg->cheque_date != ''){{$reg->cheque_date}}@else open cheque @endif</td>
                        <td>{{$reg->amount}}</td>
                        <td>{{$reg->user->username}}</td>
                        @if($reg->cheque_status == 1)
                        <td class="party-status"><span class="label label-sm label-success">Completed</span></td>
                        @else
                        <td class="party-status"><span class="label label-sm label-danger">Pending</span></td>
                        @endif
                        @if($reg->cheque_status == 1)
                        <td></td>
                        @else
                        <td>
                            <a data-id="" class="btn btn-sm purple changeStatus"
                            href="{{ URL::to('chequeregister/complete3/'. $reg->id ) }}"><i
                            class="fa fa-check"></i>Complete</a>
                        </td>
                        @endif
                    </tr>
                    <?php
                    $sl++;
                    ?>
                    @endforeach


                    </tbody>
                </table>
                    </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
{!! $register->render() !!}
@stop
@section('javascript')



@stop