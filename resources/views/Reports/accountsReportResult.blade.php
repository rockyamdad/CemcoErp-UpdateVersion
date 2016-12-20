@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
         <?php
                        $account = \App\NameOfAccount::find($account_id);
                        $accountCat = \App\AccountCategory::find($account->account_category_id);
                        ?>
        <center>
            <h3 class="page-title">
             Accounts Report  for <span style="color: black"> {{$account->name}} ({{$accountCat->name}})</span>
            </h3>
            </center>
         </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box light-grey">

                <div class="portlet-title">
                    <?php
                    $date01 = explode('/', $date1);
                    $month1  = $date01[0];
                    $day1 = $date01[1];
                    $year1   = $date01[2];
                    $date001=$day1.'/'.$month1.'/'.$year1;

                    $date02 = explode('/', $date2);
                    $month2  = $date02[0];
                    $day2 = $date02[1];
                    $year2   = $date02[2];
                    $date002=$day2.'/'.$month2.'/'.$year2;
                    ?>
                    <div class="caption"><i class="fa fa-reorder"></i>Date : {{$date001}} to {{$date002}}</div>


                     <div class="actions">
                         <a class="btn btn-sm blue hidden-print" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
                       </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="accounts_report_table" cellspacing="0">
                        <thead style="background-color:cadetblue">
                            <tr>
                                <th>Txn Date</th>
                                <th>Txn Type</th>
                                <th>Cheque</th>
                                <th>Description</th>
                                <th style="text-align: right;">Withdrawal</th>
                                <th style="text-align: right;">Deposit</th>
                                <th style="text-align: right;">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $flag = '';
                            $openingBalance = ($balanceIn[0]->balanceIn - $balanceOut[0]->balanceOut) +($currentBalance->opening_balance - ($totalBalanceIn[0]->totalBalanceIn - $totalBalanceOut[0]->totalBalanceOut));
                        ?>
                        <tr class="odd gradeX" >
                            <td>Opening Balance</td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td></td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td style="text-align: right;">
                                {{$openingBalance}}
                            </td>

                        </tr>
                        @foreach($results as $result )

                            <tr class="odd gradeX">
                                <td>{{\App\Transaction::convertDate($result->date)}}</td>
                                <td>
                                    @if($result->type != 'Receive')
                                        Withdrawal from account
                                    @else
                                        Deposit to account
                                    @endif
                                </td>
                                <td>
                                    @if($result->cheque_no)
                                        Yes-{{$result->cheque_no}}
                                    @endif
                                </td>
                                <td>{{$result->remarks}}</td>

                                <td style="text-align: right;">
                                    @if($result->type != 'Receive')
                                        {{$result->amount}}
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($result->type == 'Receive')
                                        {{$result->amount}}
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($result->type != 'Receive')
                                        @if($flag == '')
                                            {{$openingBalance - $result->amount}}
                                        @else
                                            {{$balance - $result->amount}}
                                        @endif
                                    @else
                                        @if($flag == '')
                                            {{$openingBalance + $result->amount}}
                                        @else
                                            {{$balance + $result->amount}}
                                        @endif

                                    @endif

                                </td>

                            </tr>
                            <?php
                                if($result->type != 'Receive'){
                                    if($flag == ''){
                                        $balance  = $openingBalance - $result->amount;
                                    }else{
                                        $balance  = $balance - $result->amount;
                                    }
                                } else{
                                    if($flag == ''){
                                        $balance  = $openingBalance + $result->amount;
                                    }else{
                                        $balance  = $balance + $result->amount;
                                    }
                                }

                            $flag = 'value';
                            //$total = $total + ($result->amount);
                            ?>
                        @endforeach
                        {{--<tr>
                            <td><b>Grand Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>--}}

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
