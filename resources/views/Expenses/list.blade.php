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
            Expense Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('expenses/index')}}"> Expenses List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i> Expenses</div>
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
                        <a class="btn green" href="{{ URL::to('expenses/create') }}">Make  Expense&nbsp;&nbsp;<i
                                class="fa fa-plus"></i></a>

                    </div>

                </div>
                {!!Form::open(array('action'=>'ExpenseController@getIndex','method' => 'get', 'class'=>'form-horizontal'
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
                <table class="table table-striped table-bordered table-hover" id="Expensetable">
                    <thead style="background-color: #557386">
                    <tr>
                        <th>SL</th>
                        <th>Branch Id</th>
                        <th>Invoice Id</th>
                        <th>Category</th>
                        <th>Particular</th>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="300px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @if(count($expenseInvoice)>0)
                        @foreach($expenseInvoice as $expense )
                            <?php
                                    $branch = \App\Branch::find($expense->branch_id);
                                    $transaction = \App\Transaction::where('invoice_id','=',$expense->invoice_id)->first();
                                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo $sl; ?></td>
                            <td>{{$branch->name}}</td>
                            <td>{{$expense->invoice_id}}</td>
                            <td>{{$expense->category}}</td>
                            @if($expense->particular)
                                <td>{{$expense->particular}}</td>
                            @else
                                <td>{{"Not Available"}}</td>
                            @endif
                            @if($expense->purpose)
                                <td>{{$expense->purpose}}</td>
                            @else
                                <td>{{"Not Available"}}</td>
                            @endif

                            <td>{{$expense->amount}}</td>
                            @if($expense->remarks)
                                <td>{{$expense->remarks}}</td>
                            @else
                                <td>{{"Not Available"}}</td>
                            @endif

                            @if($expense->status == 'Activate')
                                <td><span class="label label-sm label-danger">Due</span></td>
                            @elseif($expense->status == 'Partial')
                                <td><span class="label label-sm label-warning">Partial</span></td>
                            @elseif($expense->status == 'Completed')
                                <td><span class="label label-sm label-success">Completed</span></td>
                            @endif


                            <td>{{$expense->user->username}}</td>

                           <td>
                                @if( Session::get('user_role') == "admin")
                                <a class="btn blue btn-sm"  href="{{ URL::to('expenses/edit/'. $expense->id ) }}"><i
                                        class="fa fa-edit"></i>Edit</a>
                                <a class="btn dark btn-sm" rel="{{ $expense->invoice_id }}" data-toggle="modal"  data-target="#Expense" href="{{ URL::to('expenses/details/'. $expense->invoice_id ) }}" >
                                    <i class="fa fa-eye"></i> Detail</a>
                                   @if($expense->status != 'Completed')
                                       <a class="btn purple btn-sm makePayment"  rel="{{ $expense->invoice_id }}" data-toggle="modal"  data-target="#expensePayment" href="{{ URL::to('expenses/make/'.$expense->invoice_id) }}" >
                                           <i class="fa fa-usd"></i> Payment</a>
                                    @endif
                                   @if($transaction == NULL)
                                    <a class="btn red btn-sm" href="{{ URL::to('expenses/delete/'.$expense->id)}}"
                                       onclick="return confirm('Are you sure you want to delete this item?');"><i
                                            class="fa fa-trash-o"></i> Delete</a>
                                   @endif

                                @endif


                            </td>

                        </tr>
                        <?php
                        $sl++;
                        ?>
                        @endforeach
                    @else
                        @foreach($expenseAll as $expense )
                            <?php
                            $branch = \App\Branch::find($expense->branch_id);
                            $transaction = \App\Transaction::where('invoice_id','=',$expense->invoice_id)->first();
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $sl; ?></td>
                                <td>{{$branch->name}}</td>
                                <td>{{$expense->invoice_id}}</td>
                                <td>{{$expense->category}}</td>
                                @if($expense->particular)
                                    <td>{{$expense->particular}}</td>
                                @else
                                    <td>{{"Not Available"}}</td>
                                @endif
                                @if($expense->purpose)
                                    <td>{{$expense->purpose}}</td>
                                @else
                                    <td>{{"Not Available"}}</td>
                                @endif

                                <td>{{$expense->amount}}</td>
                                @if($expense->remarks)
                                    <td>{{$expense->remarks}}</td>
                                @else
                                    <td>{{"Not Available"}}</td>
                                @endif

                                @if($expense->status == 'Activate')
                                    <td><span class="label label-sm label-danger">Due</span></td>
                                @elseif($expense->status == 'Partial')
                                    <td><span class="label label-sm label-warning">Partial</span></td>
                                @elseif($expense->status == 'Completed')
                                    <td><span class="label label-sm label-success">Completed</span></td>
                                @endif


                                <td>{{$expense->user->username}}</td>

                                <td>
                                    @if( Session::get('user_role') == "admin")
                                        @if($transaction == NULL)
                                            <a class="btn blue btn-sm"  href="{{ URL::to('expenses/edit/'. $expense->id ) }}"><i
                                                    class="fa fa-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</a>
                                        @endif
                                        @if($transaction != NULL)
                                             <a class="btn dark btn-sm" rel="{{ $expense->invoice_id }}" data-toggle="modal"  data-target="#Expense" href="{{ URL::to('expenses/details/'. $expense->invoice_id ) }}" >
                                            <i class="fa fa-eye"></i> Detail</a>
                                            @endif
                                        @if($expense->status != 'Completed')
                                            <a class="btn purple btn-sm makePayment"  rel="{{ $expense->invoice_id }}" data-toggle="modal"  data-target="#expensePayment" href="{{ URL::to('expenses/make/'.$expense->invoice_id) }}" >
                                                <i class="fa fa-usd"></i> Payment</a>
                                        @endif
                                        @if($transaction == NULL)
                                            <a class="btn red btn-sm" href="{{ URL::to('expenses/delete/'.$expense->id)}}"
                                               onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                        class="fa fa-trash-o"></i> Delete</a>
                                        @endif

                                    @endif


                                </td>

                            </tr>
                            <?php
                            $sl++;
                            ?>
                        @endforeach

                    @endif

                    </tbody>
                </table>
            </div>
        </div>

        @if(count($expenseInvoice)>0)
            <center>
                <div class="actions">
                    <a class="btn blue" href="/expenses">Back</a>
                    {{--   <a class="btn dark" href="">Print</a>--}}
                </div>
            </center>
            @endif
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
{!! $expenseAll->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/expenses.js') !!}
{!! HTML::script('js/partilizer.js') !!}
{!! HTML::script('assets/plugins/select2/select2.min.js') !!}

@stop
