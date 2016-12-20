@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <center>
            <h3 class="page-title">
             Balance Transfer  Report
            </h3>
            </center>
         </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="portlet box light-grey">
<?php
    $acc1=\App\NameOfAccount::find($account1);
    $acc2=\App\NameOfAccount::find($account2);
?>
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-reorder"></i>{{$acc1->name}} and {{$acc2->name}}</div>

                     <div class="actions">
                         <a class="btn btn-sm blue hidden-print" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
                       </div>

                </div>

                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover" id="expense_products_report_table">
                        <thead style="background-color:cadetblue">
                        <tr>
                            <th>Date</th>
                            <th>From Branch</th>
                            <th>From Account</th>
                            <th>To Branch</th>
                            <th>To  Account</th>
                            <th style="text-align: right;">Amount</th>
                            <th>Remarks</th>
                            <th>Created By</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        ?>

                        @foreach($results as $result )
                            <?php
                              $user = \App\User::find($result->user_id);
                              $fromBranch = \App\Branch::find($result->fromBranch);
                              $toBranch = \App\Branch::find($result->toBranch);
                              $fromAccount = \App\NameOfAccount::find($result->fromAccount);
                              $toAccount = \App\NameOfAccount::find($result->toAccount);
                            ?>

                            <tr class="odd gradeX">
                                <td>{{\App\Transaction::convertDate($result->date)}}</td>
                                <td>{{$fromBranch->name}}</td>
                                <td>{{$fromAccount->name}}</td>
                                <td>{{$toBranch->name}}</td>
                                <td>{{$toAccount->name}}</td>
                                <td style="text-align: right;">{{$result->amount}}</td>
                                <td>{{$result->remarks}}</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <?php
                            $total = $total + ($result->amount);
                            ?>
                        @endforeach
                        @foreach($results2 as $result )
                            <?php
                            $user = \App\User::find($result->user_id);
                            $fromBranch = \App\Branch::find($result->fromBranch);
                            $toBranch = \App\Branch::find($result->toBranch);
                            $fromAccount = \App\NameOfAccount::find($result->fromAccount);
                            $toAccount = \App\NameOfAccount::find($result->toAccount);
                            ?>

                            <tr class="odd gradeX">
                                <td>{{$result->date}}</td>
                                <td>{{$fromBranch->name}}</td>
                                <td>{{$fromAccount->name}}</td>
                                <td>{{$toBranch->name}}</td>
                                <td>{{$toAccount->name}}</td>
                                <td style="text-align: right;">{{$result->amount}}</td>
                                <td>{{$result->remarks}}</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <?php
                            $total = $total + ($result->amount);
                            ?>
                        @endforeach
                        <tr>
                            <td><b>Grand Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;">{{$total}}</td>
                            <td></td>
                            <td></td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@stop
@section('javascript')
    {!! HTML::script('js/report.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
@stop
