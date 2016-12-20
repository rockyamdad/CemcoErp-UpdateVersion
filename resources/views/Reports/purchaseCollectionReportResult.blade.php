@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <?php
                $branches = \App\Branch::find($branch_id);
                ?>
                <center>
            <h3 class="page-title">
                Purchase Payment Report For {{$branches->name}}
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

                    <table class="table table-striped table-bordered table-hover" id="stock_products_report_table">
                        <thead style="background-color:cadetblue">
                        <tr>

                            <th>Date</th>
                            <th>Party Name</th>
                            <th>Invoice No</th>
                            <th>Account Name</th>
                            <th>Payment Method</th>
                            <th>Remarks</th>
                            <th style="text-align: right;">Amount</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalSale = 0;
                        ?>

                        @foreach($results as $result )
                            <?php
                                    $accounts = \App\NameOfAccount::find($result->account_name_id);
                                    $accountCategory = \App\AccountCategory::find($result->account_category_id);
                                    $party = \App\Party::find($result->party);
                                    ?>

                            <tr class="odd gradeX">
                                <td>{{\App\Transaction::convertDate($result->date)}}</td>
                                <td>{{$party->name}}</td>
                                <td><a target="_blank" href="{{URL::to('purchases?invoice_id='.$result->invoice)}}">{{$result->invoice}}</a></td>
                                <td>{{$accounts->name }}{{' ( '.$accountCategory->name.' )'}}</td>
                                <td>{{$result->payment_method}}
                                    @if($result->cheque_no)
                                        {{' ( '.$result->cheque_no.' )'}}
                                    @endif
                                </td>
                                <td>{{$result->remarks}}</td>
                                <td style="text-align: right;">{{$result->amount}}</td>



                            </tr>
                            <?php
                            $totalSale = $totalSale + $result->amount;
                            ?>
                        @endforeach
                        <tr>
                            <td><b>Grand Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;">{{$totalSale}}</td>


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
