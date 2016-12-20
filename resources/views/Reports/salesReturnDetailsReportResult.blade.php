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
             Sales Return Details  Report For {{$branches->name}}
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
                            <th>Invoice Id</th>
                            <th>Product Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Discount Percentage </th>
                            <th style="text-align: right;">Return Amount</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        ?>

                        @foreach($results as $result )
                            <?php
                            $products = \App\Product::find($result->product_id);
                            $categories = \App\Category::find($products->category_id);
                            $subCategories = \App\SubCategory::find($products->sub_category_id);
                            if($products->sub_category_id)
                            {
                                $subCategoryName = '('.$subCategories->name.')';
                            }else{
                                $subCategoryName = '';
                            }
                                    ?>

                            <tr class="odd gradeX">
                                <td>{{\App\Transaction::convertDate($result->date)}}</td>
                                <td>{{$result->invoice_id}}</td>
                                <td>{{$products->name.'('.$categories->name.')'.$subCategoryName}}</td>
                                <td>{{$result->unit_price}}</td>
                                <td>{{$result->quantity}}</td>
                                <td>{{$result->discount_percentage}}</td>
                                <td style="text-align: right;">{{$result->return_amount }}</td>
                            </tr>
                            <?php
                            $total = $total + ($result->return_amount );
                            ?>
                        @endforeach
                        <tr>
                            <td><b>Grand Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;">{{$total}}</td>


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
