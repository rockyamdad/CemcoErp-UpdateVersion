@extends('baseLayout')
@section('content')
<div class="table-toolbar">
    <div class="btn-group">
        @if((!$pi->isEmpty()) and (!$bankCost->isEmpty()) or (!$cnfCost->isEmpty()) or (!$otherCost->isEmpty()))
        <a class="btn blue" href="{{ URL::to('imports/editcost',$pi[0]['import_id']) }}">Edit Import Cost&nbsp;&nbsp;<i
                class="fa fa-pencil"></i></a>
        @endif
        <a class="btn green" href="{{ URL::to('imports/index') }}"> Import List&nbsp;&nbsp;<i
               ></i></a>

    </div>
    <div style="float: right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            Add to Stock
        </button></div>
</div>

<div class="row">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">

                <div class="portlet-body">
                    <h4>Import Details List</h4>
                    <table class="table table-striped table-bordered table-hover" id="imports_detail_table">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Booking Price</th>
                            <th>CFR Price</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl=1;
                        ?>
                        @foreach($imports as $importt )
                            <?php

                            $categoryName = \App\Category::find($importt->product->category_id);

                            $products = \App\Product::find($importt->product_id);

                            if($products->sub_category_id){
                                $subCategory = \App\SubCategory::find($products->sub_category_id);
                                if($subCategory != NULL)
                                    $subCategoryName = '('.$subCategory->name.')';
                                else
                                    $subCategoryName = '(N/A)';
                            }
                            else{
                                $subCategoryName = '(N/A)';
                            }

                            ?>

                        <tr class="odd gradeX">
                            <td><?php echo $sl; ?></td>
                            <td>{{$importt->product->name.'('.$categoryName->name.')'.$subCategoryName}}</td>
                            <td>{{$importt->quantity}}</td>
                            <td>{{$importt->total_booking_price}}</td>
                            <td>{{$importt->total_cfr_price}}</td>
                            <td>{{$importt->user->name}}</td>
                            <td><a href="{{ URL::to('imports/editdetails/'. $importt->id ) }}"><i
                                        class="fa fa-edit"></i>Edit </a>
                            </td>
                        </tr>
                        <?php
                        $sl++;
                        ?>
                        @endforeach

                        </tbody>
                    </table>

                    <br>

                    <h4>Proforma Invoice</h4>
                    <table class="table table-striped table-bordered table-hover" id="imports_pi_table">
                        <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Beneficiary Name</th>
                            <th>terms</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$pi->isEmpty())
                        <tr class="odd gradeX">
                            <td>{{$pi[0]['invoice_no']}}</td>
                            <td>{{$pi[0]['beneficiary_name']}}</td>
                            <td>{{$pi[0]['terms']}}</td>

                        </tr>
                        @endif

                        </tbody>
                    </table>
                    <br>

                    <h4>Bank Cost</h4>

                    <table class="table table-striped table-bordered table-hover" id="imports_bank_cost_table">
                        <thead>
                        <tr>
                            <th>LC Number</th>
                            <th>Bank Name</th>
                            <th>L/C Date</th>
                            <th>LC Commission</th>
                            <th>Vat Commission</th>
                            <th>Stamp Charge</th>
                            <th>Swift Charge</th>
                            <th>LCA Charge</th>
                            <th>Insurance Charge</th>
                            <th>Bank Service Charge</th>
                            <th>Others Charge</th>

                        </tr>
                        </thead>
                        <tbody>
                    @if(!$bankCost->isEmpty())
                        <tr class="odd gradeX">
                            <td>{{$bankCost[0]['lc_no']}}</td>
                            <td>{{$bankCost[0]['bank_name']}}</td>
                            <td>{{$bankCost[0]['lc_date']}}</td>
                            <td>{{$bankCost[0]['lc_commission_charge']}}</td>
                            <td>{{$bankCost[0]['vat_commission']}}</td>
                            <td>{{$bankCost[0]['stamp_charge']}}</td>
                            <td>{{$bankCost[0]['swift_charge']}}</td>
                            <td>{{$bankCost[0]['lca_charge']}}</td>
                            <td>{{$bankCost[0]['insurance_charge']}}</td>
                            <td>{{$bankCost[0]['bank_service_charge']}}</td>
                            <td>{{$bankCost[0]['others_charge']}}</td>


                        </tr>
                        @endif


                        </tbody>
                    </table>
                    <br>

                    <h4>CNF Cost</h4>
                    <table class="table table-striped table-bordered table-hover" id="imports_cnf_cost_table">
                        <thead>
                        <tr>
                            <th>Agent Name</th>
                            <th>Bill No</th>
                            <th>Clearing Date</th>
                            <th>Association Fee</th>
                            <th>PO Cash</th>
                            <th>Port Charge</th>
                            <th>Shipping Charge</th>
                            <th>NOC Charge</th>
                            <th>Labour Charge</th>
                            <th>Jetty Charge</th>
                            <th>Agency Commission</th>
                            <th>Others Charge</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$cnfCost->isEmpty())
                        <tr class="odd gradeX">
                            <td>{{$cnfCost[0]['clearing_agent_name']}}</td>
                            <td>{{$cnfCost[0]['bill_no']}}</td>
                            <td>{{$cnfCost[0]['clearing_date']}}</td>
                            <td>{{$cnfCost[0]['association_fee']}}</td>
                            <td>{{$cnfCost[0]['po_cash']}}</td>
                            <td>{{$cnfCost[0]['port_charge']}}</td>
                            <td>{{$cnfCost[0]['shipping_charge']}}</td>
                            <td>{{$cnfCost[0]['noc_charge']}}</td>
                            <td>{{$cnfCost[0]['labour_charge']}}</td>
                            <td>{{$cnfCost[0]['jetty_charge']}}</td>
                            <td>{{$cnfCost[0]['agency_commission']}}</td>
                            <td>{{$cnfCost[0]['others_charge']}}</td>

                        </tr>
                        @endif

                        </tbody>
                    </table>

                    <br>

                    <h4>OtherCost</h4>
                    <table class="table table-striped table-bordered table-hover" id="imports_otherCost_table">
                        <thead>
                        <tr>
                            <th>Dollar to Bdt Rate</th>
                            <th>Tt Charge</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$otherCost->isEmpty())
                        <tr class="odd gradeX">
                            <td>{{$otherCost[0]['dollar_to_bd_rate']}}</td>
                            <td>{{$otherCost[0]['tt_charge']}}</td>

                        </tr>
                        @endif

                        </tbody>
                    </table>

                </div>

            </div>

            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add to Stock</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-11 " style="width: 220px;">
                        {!!Form::select('stock_info_id',[null=>'Select Stock'] +$allStockInfos,'null', array('class'=>'form-control ','id'=>'stock_info_id', 'onchange'=> 'abc();') )!!}
                        <br>
                        <a href="" id="addnow" class="btn blue addtostocks">Add</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function abc(){
        var stock_info_id = $('#stock_info_id').val();
        $('#addnow').attr('href', '{{URL::to('addtostock/'.$id.'/')}}/'+stock_info_id);
    }

</script>
@stop







