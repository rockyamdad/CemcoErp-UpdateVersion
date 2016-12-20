@extends('baseLayout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h4 class="page-title">
                <span>{{$results ? $results[0]->pName.'('.$results[0]->category.')' : 'Stock Product ' }}</span> Search Result
            </h4>

        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-reorder"></i>  <span>{{$results ? $results[0]->sName : 'Stock Product ' }} </span>   Search Result </div>
                    <div class="actions">
                        <a class="btn blue" href="searches/stock-products">Back</a>
                     {{--   <a class="btn dark" href="">Print</a>--}}
                    </div>
                </div>

                <div class="portlet-body">
                    @if($results)
                    <table class="table table-striped table-bordered table-hover" id="stock_Product_search_result_table">
                        <thead style="background-color:royalblue">
                        <tr>

                            <th>Date</th>
                            <th>Entry Type</th>
                            <th>Remarks</th>
                            <th>Consignment Name</th>
                            <th>Created By</th>
                            <th>Quantity</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0;
                        ?>

                            @foreach($results as $result )
                                <tr class="odd gradeX">

                                    <td>{{$result->created_at}}</td>
                                    <td>{{$result->entry_type}}</td>
                                    <td>{{$result->remarks}}</td>
                                    <td>{{$result->consignment_name}}</td>
                                    <td>{{$result->uName}}</td>
                                    <td>{{$result->quantity}}</td>

                                </tr>
                                <?php
                                $total = $total + $result->quantity;
                                ?>
                            @endforeach
                            <tr class="odd gradeX">

                                <td>Total Quantity</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$total}}</td>


                            </tr>
                        </tbody>
                    </table>
                        @else
                           <h4  style="color:red">No Search Result</h4>
                        @endif

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@stop
@section('javascript')
    {!! HTML::script('js/search.js') !!}
@stop