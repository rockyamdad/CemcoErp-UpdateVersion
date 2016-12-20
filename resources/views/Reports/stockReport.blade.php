@extends('baseLayout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                <span style="color: #4cae4c">{{$results ? $results[0]->category : ' ' }}</span> Category Stock Report
            </h3>

        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <?php
            use Illuminate\Support\Facades\URL;
            $sDate = date('Ymd', strtotime($date1));
            $eDate = date('Ymd', strtotime($date2));
            $type  = $product_type;
            $url = URL::to('reports/print/'.$sDate.'/'.$eDate.'/'.$type.'/'.$branch_id.'/'.$category_id);
            ?>

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
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

                    <div class="caption"><i class="fa fa-reorder"></i>   Stock Report of {{$date001}} to {{$date002}} for {{$product_type}} Products</div>
                    <div class="actions">
                        <a class="btn blue" href="reports/stocks">Back</a>

                        <a class="btn dark" onclick="javascript: window.open('{{$url}}','MsgWindow', 'width=1100,height=500').print();">Print</a>
                    </div>

                </div>
                @if($results)
                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="stock_requisition_search_result_table">
                        <thead style="background-color:cadetblue">
                        <tr>

                            <th>Product Name</th>
                            <th style="text-align: right;">Stock In</th>
                            <th style="text-align: right;">Opening</th>
                            <th style="text-align: right;">Total Stock In</th>
                            <th style="text-align: right;">Stock Out</th>
                            <th style="text-align: right;">Wastage</th>
                            <th  style="background-color:green;text-align: right;">Balance</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                                $grandTotalStockIn = 0;
                                $grandTotalStockOut = 0;
                                $grandTotalStockWastage = 0;
                                $grandTotalStockBf = 0;
                                $grandTotalStockInBf = 0;
                                $grandTotalStockOutNg = 0;
                                $grandTotalBalance = 0;
                        ?>

                        @foreach($results as $result )
                            <?php
                                    $stocks = new \App\Report();
                                    $sub_category = new \App\SubCategory();
                                    $sub_categoryName = \App\SubCategory::find($result->subCategory);
                                    $bfIn = $stocks->getStockBf($product_type,$date1,$result->product_id);
                                    $bfOut = $stocks->getStockBfOut($product_type,$date1,$result->product_id);
                                    $stockIn = $stocks->getStockIn($product_type,$date1,$date2,$result->product_id);
                                    $stockOut = $stocks->getStockOut($product_type,$date1,$date2,$result->product_id);
                                    $wastage = $stocks->getStockWastage($product_type,$date1,$date2,$result->product_id);
                                    $bf = $bfIn[0]->stockBf - $bfOut[0]->stockBfOut;
                                    $totalIn = $bf + $stockIn[0]->stockIn;
                                    $balance =  $totalIn - $stockOut[0]->stockOut;

                            ?>

                            <tr class="odd gradeX">

                                <td>{{$result->pName.'('.$result->category.')'.'('.(($sub_categoryName!=null)?$sub_categoryName->name: '').')'}}</td>
                                <td style="text-align: right;">@if($stockIn[0]->stockIn){{ $stockIn[0]->stockIn }}@else {{ 0 }}@endif</td>
                                <td style="text-align: right;">@if($bf){{ $bf }}@else {{ 0 }}@endif</td>
                                <td style="text-align: right;">{{ $totalIn }}</td>
                                <td style="text-align: right;">@if($stockOut[0]->stockOut){{ $stockOut[0]->stockOut }}@else {{ 0 }}@endif</td>
                                <td style="text-align: right;">@if($wastage[0]->stockWastage){{ $wastage[0]->stockWastage }}@else {{ 0 }}@endif</td>
                                <td style="text-align: right;">{{ $balance }}</td>

                            </tr>
                            <?php
                                $grandTotalStockIn  = $grandTotalStockIn + $stockIn[0]->stockIn;
                                $grandTotalStockBf  = $grandTotalStockBf + $bf;
                                $grandTotalStockOut = $grandTotalStockOut + $stockOut[0]->stockOut;
                                $grandTotalStockWastage = $grandTotalStockWastage + $wastage[0]->stockWastage;
                                $grandTotalStockInBf  = $grandTotalStockInBf + $totalIn;
                                $grandTotalBalance    = $grandTotalBalance + $balance;
                            ?>
                        @endforeach
                        <tr style="background-color:#b4cef8;">

                            <td><b>Grand Total</b></td>
                            <td style="text-align: right;">{{$grandTotalStockIn}}</td>
                            <td style="text-align: right;">{{$grandTotalStockBf}}</td>
                            <td style="text-align: right;">{{$grandTotalStockInBf}}</td>
                            <td style="text-align: right;">{{$grandTotalStockOut}}</td>
                            <td style="text-align: right;">{{$grandTotalStockWastage}}</td>
                            <td style="text-align: right;">{{ $grandTotalBalance }}</td>

                        </tr>
                        </tbody>
                    </table>

                </div>
                @else
                    <h4  style="color:red">No Search Result</h4>
                @endif
            </div>

        </div>

    </div>

@stop
