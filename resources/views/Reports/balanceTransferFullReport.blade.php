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
             Creditor Debtor Report
            </h3>
            </center>
         </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="portlet box light-grey">

                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-reorder"></i> Creditor Debtor Report </div>

                     <div class="actions">
                         <a class="btn btn-sm blue hidden-print" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
                       </div>

                </div>

                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover" id="expense_products_report_table">
                        <thead style="background-color:cadetblue">
                        <tr>
                            <th>Creditor Account</th>
                            <th>Debtor Account</th>
                            <th>Amount</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        ?>
                <?php
                $values = array();
                $count=0;
                $count2=0;
                ?>
                        @foreach($results as $result )
                            <?php
                                $reports = new \App\Report();
                                $results2 = $reports->getBalanceTransferForFromAccount($result->fromAccount);
                                $fromAccount = \App\NameOfAccount::find($result->fromAccount);
                            ?>

                            @foreach($results2 as $result2 )
                                <?php
                                $reports = new \App\Report();
                                $results3 = $reports->getBalanceTransferForToAccount($result->fromAccount, $result2->toAccount);
                                $remainingAmount = $result2->fromAmount - $results3[0]->toAmount;
                                $toAccount = \App\NameOfAccount::find($result2->toAccount);
                                ?>
                                @if($remainingAmount > 0)
                                <?php
                                for($i=0;$i<$count;$i++)
                                {

                                    $from = $values[$i]["from"];
                                    $to = $values[$i]["to"];
                                    //var_dump($from." ".$to);
                                    if($from==$fromAccount->name && $to==$toAccount->name)
                                    {
                                        $count2=1;
                                    }
                                }
                                ?>
                                @if($count2==0)
                                    <tr>
                                        <td>{{$fromAccount->name}}</td>
                                        <td>{{$toAccount->name}}</td>
                                        <td>{{$remainingAmount}}</td>
                                    </tr>
                                <?php
                                array_push($values, array("from" => $fromAccount->name, "to" => $toAccount->name));
                                $count++;
                                ?>
                                @endif
                                <?php $count2=0; ?>
                                @elseif($remainingAmount < 0)
                                <?php
                                for($i=0;$i<$count;$i++)
                                {
                                    $from = $values[$i]["to"];
                                    $to = $values[$i]["from"];
                                    //var_dump($from." ".$to);
                                    if($from==$fromAccount->name && $to==$toAccount->name)
                                    {
                                        $count2=1;
                                    }
                                }
                                ?>
                                @if($count2==0)
                                    <tr>
                                        <td>{{$toAccount->name}}</td>
                                        <td>{{$fromAccount->name}}</td>
                                        <td>{{-$remainingAmount}}</td>
                                    </tr>
                                <?php
                                array_push($values, array("from" => $fromAccount->name, "to" => $toAccount->name));
                                $count++;
                                ?>
                                @endif
                                <?php $count2=0; ?>
                                @endif

                            @endforeach

                        @endforeach

{{--
                        <tr>
                            <td><b>Grand Total</b></td>
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
