@extends('baseLayout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
             Stock Search Result
            </h3>

        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <?php
                    $branch = \App\Branch::find($branch);
                    ?>
                    <div class="caption"><i class="fa fa-reorder"></i>   Stock Search Result for {{$branch->name}}</div>
                    <div class="actions">
                        <a class="btn blue" href="/entry">Back</a>

                    </div>
                </div>

                <div class="portlet-body">
                    @if($results)
                    <table class="table table-striped table-bordered table-hover" id="stock_search_result_table">
                        <thead style="background-color:royalblue">
                        <tr>

                            <th>Product</th>
                            <th>Stock</th>
                            <th>Entry Type</th>
                            <th>Quantity</th>
                            <th>Remarks</th>
                            <th>Consignment</th>

                        </tr>
                        </thead>
                        <tbody>

                            @foreach($results as $result )
                                <?php
                                $categoryName = \App\Category::find($result->cid);
                                $subCategoryName = \App\SubCategory::find($result->sid);
                                ?>
                                <tr class="odd gradeX">

                                    <td>{{$result->pName.'('.$categoryName->name.')'.'('.(($subCategoryName!=null)?$subCategoryName->name: '').')'}}</td>
                                    <td>{{$result->sName}}</td>
                                    <td>{{$result->entry_type}}</td>
                                    <td style="text-align: right;">{{$result->product_quantity}}</td>
                                    <td>{{$result->remarks}}</td>
                                    <td>{{$result->consignment_name}}</td>

                                </tr>
                            @endforeach
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