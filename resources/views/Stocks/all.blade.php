@extends('baseLayout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Stock Section
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{URL::to('dashboard/')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>

                <li><a href="{{URL::to('stocks/index')}}">Stock List</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-globe"></i>Stock</div>
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
                    @if (Session::has('wrong'))
                        <div class="alert alert-danger">
                            <button data-close="alert" class="close"></button>
                            {{ Session::get('wrong') }}
                        </div>
                    @endif
                </div>

                <div class="portlet-body">

                    <div class="table-toolbar">
                        <div class="btn-group">
                            <a class="btn green" href="{{ URL::to('stocks/create2') }}">Make Stock &nbsp;&nbsp;<i
                                        class="fa fa-plus"></i></a>

                        </div>

                    </div>
                    <table class="table table-striped table-bordered table-hover" id="stock_table">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Branch</th>
                            <th>Stock Invoice Id</th>
                            <th>Entry Type</th>
                            <th>Created By</th>
                            <!-- <th>Status</th>-->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl=1;
                        ?>
                        @foreach($stocks as $stock )
                            <?php
                            $stockDetails = \App\StockDetail::where('invoice_id','=',$stock->invoice_id)
                                    ->get();

/*
                            $categoryName = \App\Category::find($stock->product->category_id);
                            $subCategoryName = \App\SubCategory::find($stock->product->sub_category_id);
                            $stockTo = \App\StockInfo::find($stock->to_stock_info_id); */
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $sl; ?></td>
                                <td>{{$stock->branch->name}}</td>
                                {{--<td>{{$stock->product->name.'('.$categoryName->name.')'.'('.$subCategoryName->name.')'}}</td>--}}
                                {{--<td>{{$stock->stockInfo->name}}</td>--}}
                                {{--<td>{{$stock->to_stock_info_id ? $stockTo->name : '' }}</td>--}}
                                <td>{{$stock->invoice_id ? $stock->invoice_id : '' }}</td>
                                @if(!empty($stockDetails[0]))
                                <td>@if($stockDetails[0]->entry_type == 'StockIn')
                                        <span class="label label-sm label-success">StockIn</span>
                                    @elseif($stockDetails[0]->entry_type == 'StockOut')
                                        <span class="label label-sm label-danger">StockOut</span>
                                    @elseif($stockDetails[0]->entry_type == 'Transfer')
                                        <span class="label label-default">Transfer</span>
                                    @else
                                        <span class="label label-warning ">Wastage</span>
                                    @endif
                                </td>
                                @else
                                    <td></td>
                                @endif
                                {{--<td>{{$stock->product_quantity}}</td>--}}
                                {{--<td>{{$stock->remarks}}</td>--}}
                                {{--<td>{{$stock->consignment_name}}</td>--}}
                                <td>{{$stock->user->username}}</td>
                                <!--  <td>{{$stock->status}}</td>-->
                                <td>
                                    <a class="btn dark btn-sm" rel="{{ $stock->invoice_id }}" data-toggle="modal"  data-target="#sale" href="{{ URL::to('stocks/details/'. $stock->invoice_id ) }}" >
                                        <i class="fa fa-eye"></i> Detail</a>
                                    @if($stock->confirmation == 0)<a class="btn blue btn-sm" href="{{ URL::to('stocks/edit/'. $stock->id ) }}"><i
                                                class="fa fa-edit"></i>Edit Product</a>@endif
                                    @if($stock->confirmation == 0)
                                        <a class="btn btn-sm btn-success" href="{{ URL::to('stocks/confirm/'. $stock->invoice_id ) }}"><i
                                                    class="fa fa-edit"></i>Confirm</a>
                                    @endif
                                    <a class="btn blue btn-sm" href="{{ URL::to('stocks/showinvoice/'. $stock->invoice_id ) }}"><i
                                                class="fa fa-edit"></i>Show Invoice</a>
                                    @if($stock->confirmation == 0)<a class="btn red btn-sm" href="{{ URL::to('delstock/'.$stock->id)}}"
                                       onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                class="fa fa-trash-o"></i> Delete</a>@endif
                                </td>

                            </tr>
                            <?php
                            $sl++;
                            ?>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    {!! $stocks->render() !!}
@stop
@section('javascript')
    {!! HTML::script('js/stock2.js') !!}

    {!! HTML::script('js/partilizer.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
@stop