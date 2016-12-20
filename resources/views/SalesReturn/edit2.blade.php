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
                {!!Form::open(array('url' => '../../saveSalesReturn', 'method' => 'post', 'class'=>'form-horizontal',
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
                                    Branch
                                </div>
                                <div class="col-md-3">
                                    {!!Form::select('branch_id',[null=>'Please Select Branch'] + $branchAll,$stockInvoices->branch_id, array('class'=>'form-control branch_id_val','id'=>'branch_id') )!!}
                                </div>
                                <div class="col-md-3">
                                    Party
                                </div>
                                <div class="col-md-3">
                                    {!! Form::select('party_id',[null=>'Please Select Party'] + $partyAll, $stockInvoices->party_id, array('class'=>'form-control','id'=>'party_id'))!!}
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-3">
                                    Product Status
                                </div>

                                <div class="col-md-3">
                                    {!! Form::select('product_status',[null=>'Please Select Product Status'] + array('Defective' => 'Defective', 'Intact' =>
                            'Intact'),$stockInvoices->product_status, array('class'=>'form-control','id'=>'product_status'))!!}
                                </div>

                                <div class="col-md-3">
                                    Ref No.
                                </div>
                                <div class="col-md-3">
                                    {!!Form::text('ref_no',$stockInvoices->ref_no,array('placeholder' => 'Ref No.', 'id' => 'ref_no','class' =>
                                 'form-control'))!!}
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group">

                                <div class="col-md-3">
                                    Discount percentage
                                </div>
                                <div class="col-md-3">
                                    {!!Form::text('discount_percentage',$stockInvoices->discount_percentage,array('placeholder' => 'discount percentage', 'id' => 'discount_percentage','class' =>
                                 'form-control'))!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-body">


                            <div class="row">
                                <table class="table table-striped table-bordered table-primary table-condensed" id="stockTable">
                                    <thead>
                                    <tr>
                                        <th width="">Product Type</th>
                                        <th width="">Product Name</th>
                                        <th width="">Quantity</th>
                                        <th width="">Unit Price</th>
                                        <th width="">Consignment Name</th>
                                        <th width="">Action</th>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <?php foreach ($stockDetails2 as $stckDetail) { ?>
                                    <tr class="clone_">
                                        <td>
                                            <?php echo $stckDetail->product_type; ?>
                                        </td>
                                        <td>
                                            <?php echo $stckDetail->product->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $stckDetail->quantity; ?>
                                        </td>

                                        <td>
                                            <?php echo $stckDetail->unit_price; ?>
                                        </td>

                                        <td  class="consignment_name_section">
                                            <?php echo $stckDetail->consignment_name; ?>
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
                                                    {!! Form::select('product_type',[null=>'Please Select Type'] + array('Local' => 'Local', 'Foreign' =>
                         'Foreign','Finish Goods'=>'Finish Goods'),'null', array('class'=>'form-control','id'=>'product_type'))!!}

                                                </div>
                                            </div>
                                        </td>

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
                                                    {!!Form::text('quantity',null,array('placeholder' => 'Product Quantity', 'id' => 'quantity','class' =>
                                 'form-control'))!!}
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    {!!Form::text('unit_price',null,array('placeholder' => 'Unit Price', 'id' => 'unit_price','class' =>
                                 'form-control'))!!}
                                                </div>
                                            </div>
                                        </td>

                                        <td  class="consignment_name_section">
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



                                        <td>
                                            {!!Form::button('Add',array('type' => 'button','class' => 'btn blue saveSalesReturn'))!!}
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
    {!! HTML::script('js/salesReturnEdit.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

@stop




