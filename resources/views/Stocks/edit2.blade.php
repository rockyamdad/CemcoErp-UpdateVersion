@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
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
                    <a href="{{URL::to('dashboard')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>

                <li><a href="{{URL::to('stocks/create')}}">Make Stock</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>

    <div class="col-md-16">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i>Make Stock</div>
                <div class="actions">
                    <a class="btn dark" href="{{ URL::to('stocks/index') }}">Stock List</a>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {!!Form::open(array('url' => '/saveStock2', 'method' => 'post', 'class'=>'form-horizontal',
                'id'=>'stock_form'))!!}

                <div class="form-body">
                    <div style="float: left;width: 80%; margin-left: 20px">
                        @if (Session::has('message'))
                            <div class="alert alert-success">
                                <button data-close="alert" class="close"></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="alert alert-danger display-hide">
                        <button data-close="alert" class="close"></button>
                        You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button data-close="alert" class="close"></button>
                        Your form validation is successful!
                    </div>
                    <div class="portlet-body form" id="testt">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-3">
                                    {!!Form::select('branch_id',[null=>'Please Select Branch'] + $branchAll, $stockInvoices->branch_id, array('class'=>'form-control branch_id_val','id'=>'branch_id') )!!}
                                </div>
                                <div class="col-md-3">
                                    {!!Form::select('stock_info_id',[null=>'Select Stock'] +$allStockInfos, $stockDetails->stock_info_id, array('class'=>'form-control stock_id_val','id'=>'stock_info_id') )!!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::select('product_type',[null=>'Please Select Product Type'] + array('Local' => 'Local', 'Foreign' =>
                            'Foreign','Finish Goods'=>'Finish Goods'), $stockDetails->product_type, array('class'=>'form-control','id'=>'product_type'))!!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::select('entry_type',[null=>'Please Select Entry Type'] + array('StockIn' => 'StockIn', 'StockOut' =>
                            'StockOut','Wastage'=>'Wastage','Transfer'=>'Transfer'),$stockDetails->entry_type, array('class'=>'form-control','id'=>'entry_type', 'readonly' => 'true'))!!}
                                </div>
                            </div>

                        </div>
                        <div class="form-body">


                            <div class="row">
                                <table class="table table-striped table-bordered table-primary table-condensed" id="stockTable">
                                    <thead>
                                    <tr>
                                        <th width="">Product Name</th>
                                        <th width="">Quantity</th>
                                        <th width=""  class="consignment_name_section" @if($stockDetails->entry_type != 'StockIn') style="display:none;" @endif >Consignment Name</th>
                                        <th width="" class="to_stock_section" @if($stockDetails->entry_type != 'Transfer') style="display:none;" @endif  >To Stock</th>
                                        <th width="">Remarks</th>
                                        <th width="">Action</th>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <?php foreach ($stockDetails2 as $stckDetail) {
                                    $productsName2 = App\Product::find($stockDetails->product_id);
                                    $category = $productsName2->category->name;
                                    $subCategoryName = '';
                                    if($productsName2->sub_category_id){
                                        $subCategory = App\SubCategory::find($productsName2->sub_category_id);
                                        $subCategoryName = '('.$subCategory->name.')';
                                    }
                                    ?>
                                    <tr class="clone_">
                                        <td>
                                            <?php echo $stckDetail->product->name.' ('.$category.') '.$subCategoryName;; ?>
                                        </td>
                                        <td>
                                            <?php echo $stckDetail->quantity; ?>
                                        </td>

                                        <td  class="consignment_name_section"  @if($stockDetails->entry_type != 'StockIn') style="display:none;" @endif>
                                            <?php echo $stckDetail->consignment_name; ?>
                                        </td>

                                        <td  class="to_stock_section"  @if($stockDetails->entry_type != 'Transfer') style="display:none;" @endif>
                                            <?php echo $stckDetail->to_stock_unfo_id; ?>
                                        </td>

                                        <td>
                                            <?php echo $stckDetail->remarks ?>
                                        </td>
                                        <td>
                                            <input type="button"   style="width:70px;" value="delete" class="btn red deleteStockDetail2" rel='{{$stockDetails->id}}' >
                                        </td>
                                    </tr>
                                    <?php } ?>


                                    <tr class="clone_">
                                        <td>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <select id="product_id" name="product_id" class="form-control productIdInEditStockInvoice">
                                                        <option value="">Select Product</option>
                                                        <?php
                                                        foreach ($productsName as $productName) {
                                                            $category = $productName->category->name;
                                                            if($productName->sub_category_id){
                                                                $subCategory = \App\SubCategory::find($productName->sub_category_id);
                                                                $subCategoryName = '('.$subCategory->name.')';
                                                            }else{
                                                                $subCategoryName = '';
                                                            }
                                                            echo "<option value = $productName->id > $productName->name ($category) $subCategoryName</option> ";


                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    {!!Form::text('product_quantity',null,array('placeholder' => 'Product Quantity', 'id' => 'product_quantity','class' =>
                                 'form-control'))!!}
                                                </div>
                                            </div>
                                        </td>

                                        <td  class="consignment_name_section"  @if($stockDetails->entry_type != 'StockIn') style="display:none;" @endif>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div>
                                                        <select class='form-control' id="consignment_name" name='consignment_name'>
                                                            <option value ='N/A' >N/A </option>
                                                            @if($stockDetails->entry_type != 'StockIn')
                                                                @foreach($imports as $import)
                                                                    <option value = {{$import->consignment_name}} > {{$import->consignment_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td  class="to_stock_section"  @if($stockDetails->entry_type != 'Transfer') style="display:none;" @endif>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div >
                                                        <select class='form-control' id="to_stock_info_id" name='to_stock_info_id'>
                                                            <option value ='' >Select Stock </option>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    {!!Form::text('remarks',null,array('placeholder' => 'Remarks', 'class' =>
                                                    'form-control','id'=>'remarks'))!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {!!Form::button('Add',array('type' => 'button','class' => 'btn blue saveStocks'))!!}
                                        </td>
                                    </tr>
                                </table>
                                <div class="form-group ">
                                    <label class="control-label col-md-4"></label>
                                    <div class="col-md-7 balance_show">
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <div class="col-md-4 available"></label>
                                        <div class="col-md-7 balance_show">
                                        </div>

                                    </div>


                                </div>
                            </div>

                        </div>




                    </div>
                </div>


                {!!Form::hidden('invoice_id',$invoiceId,array('class' => 'form-control','id'=>'invoice_id'))!!}

                {!!Form::close()!!}
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
@stop
@section('javascript')
    {!! HTML::script('js/stockEdit.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

@stop




