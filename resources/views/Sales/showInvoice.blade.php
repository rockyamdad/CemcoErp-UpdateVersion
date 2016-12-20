@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
        <div class="row">

            <div class="col-xs-2 invoice-block" style="margin-left: 880px;">
                <a class="btn btn-sm blue hidden-print" onclick="getConfirmation();">Print <i class="fa fa-print"></i></a>
                <a class="btn btn-sm blue hidden-print" href="{{\Illuminate\Support\Facades\URL::to('sales/showinvoice2/'.$invoiceId)}}">Print Details <i class="fa fa-print"></i></a>
            </div>
        </div>
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-12 invoice-logo-space">
                @if($saleDetails[0]->branch_id == 1)
                    <img src="../../assets/img/pad/cemon-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 2)
                    <img src="../../assets/img/pad/fst-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 3)
                    <img src="../../assets/img/pad/cemon-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 4)
                    <img src="../../assets/img/pad/cemon-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 5)
                    <img src="../../assets/img/pad/sun-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 6)
                    <img src="../../assets/img/pad/olympic-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 7)
                    <img src="../../assets/img/pad/keyon1.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 8)
                <img src="../../assets/img/pad/cemon-invoice.jpg" style="width: 100%;"  alt="" />
                @elseif($saleDetails[0]->branch_id == 9)
                    <img src="../../assets/img/pad/me-invoice.jpg" style="width: 100%;"  alt="" />
                @endif

           </div>
            <hr />
            {{--<div class="col-xs-6">
               <p># {{$sale->invoice_id}} <span class="muted">--{{$sale->created_at}}</span></p>
            </div>--}}
        </div>

        <div class="row" style="margin-top: -10px;">

            <div class="col-xs-4">
               {{-- <h4>Client:</h4>--}}
                <?php
                    $party = \App\Party::find($sale->party_id);
                    ?>

                <table>
                <tr>
                    <td><b>Customer</b></td>
                    <td>: {{$party->name}}</td>
                </tr>
                <tr>
                    <td><b>Address</b></td>
                    <td>: {{$party->address}}</td>
                </tr>
                <tr>
                    <td><b>Contact</b></td>
                    <td>: {{$party->phone}}</td>
                </tr>
                </table>
            </div>
            <div class="col-xs-4">

            </div>
            <div class="col-xs-4 invoice-payment">
                <table>
                <tr>
                    <td><b>Invoice #</b></td>
                    <td>: {{$sale->invoice_id}}</td>
                </tr>
                <tr>
                    <td><b>Date</b></td>
                    <td>: {{\App\Transaction::convertDate($sale->created_at)}}</td>
                </tr>
                <tr>
                    <td><b>Print Date</b></td>
                    <td>: {{date("d/m/Y")}}</td>
                </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th class="hidden-480">Description</th>
                        <th style="text-align: right;" class="hidden-480">Quantity</th>
                        <th style="text-align: right;" class="hidden-480">Unit Price</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $total = 0;
                    ?>
                    @foreach($saleDetails as $saleDetail )
                        <?php

                        $categoryName = \App\Category::find($saleDetail->product->category_id);
                        $subCategoryName = \App\SubCategory::find($saleDetail->product->sub_category_id);

                                $products = \App\Product::find($saleDetail->product_id);
                                ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$saleDetail->product->name.'('.$categoryName->name.')'.'('.$subCategoryName->name.')'}}</td>
                            <td>{{$products->origin}}</td>
                            <td style="text-align: right;">{{$saleDetail->quantity}}</td>
                            <td style="text-align: right;">{{$saleDetail->price}}</td>
                            <td style="text-align: right;">{{$saleDetail->price * $saleDetail->quantity}}</td>
                        </tr>
                        <?php
                        $total = $total + ($saleDetail->price * $saleDetail->quantity);
                        $i++;
                        ?>
                    @endforeach
                    <tr>
                        <td>Total:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">{{$total}}</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">{{round(($sale->discount_percentage_per))}}%</td>
                        <td style="text-align: right;">{{($sale->discount_percentage_per*$total)/100}}</td>
                    </tr>

                    <tr>
                        <td>Special Discount:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">{{$sale->discount_special}}</td>
                    </tr>

                    <tr style="font-weight: bold;">
                        <td>Grand Total:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">{{$total-$sale->discount_percentage}}</td>
                    </tr>

                    </tbody>
                </table>


                <div class="row">

                    <div class="col-xs-12">
                        <b>Remarks:</b><br>
                        <div id="remrks">
                            <?php if ($sale->is_sale == 1) { ?>
                                <?php echo nl2br($sale->remarks); ?>
                            <?php }?>
                        </div>
                        <div id="remrksForm">
                            <?php if ($sale->is_sale != 1) { ?>
                            {!!Form::open(array('url' => 'http://cemcoerp.dev/sales/confirm/'.$sale->id, 'method' => 'post', 'class'=>'form-horizontal',
                            'id'=>'confirm_form'))!!}

                            <textarea class="col-xs-6" id="remIn" name="remIn">{{$sale->remarks}}

                        </textarea>
                            </form>
                            <button class="btn btn-danger" id="click" onclick="conirm({{$sale->id}});">Confirm</button>
                            <?php }?>
                        </div>

                    </div>



                </div>
                <br><br>
                <div class="row">

                    <div style="text-decoration: underline" class="col-xs-4">
                        <center>
                            <b>Received By</b>
                        </center>
                    </div>
                    <div class="col-xs-4">

                    </div>
                    <div style="text-decoration: underline" class="col-xs-4 invoice-payment">
                        <center>
                            <b>Delivered By</b>
                        </center>
                    </div>

                </div>


            </div>
        </div>
        <br>
        <br>

    </div>

        <style>
            table {font-size: 12px;}
            table tr th {font-size: 12px;}
        </style>


        <script>
            function getConfirmation(){
                var retVal = $('#remrks').html();
                //alert(retVal);
                if( retVal != '' ){
                    window.print();
                    return true;
                }
                else{
                    alert('Please confirm terms & conditions');
                    //document.write ("User does not want to continue!");
                    return false;
                }
            }

            function conirm(product_id) {
                var remarks = $('#remIn').val();
                $('#remrks').html($('#remIn').val().replace(/\n/g, "<br>"));
                $('#remrksForm').hide();
                $.ajax({
                    type: "post",
                    url: "../confirm/"+product_id,
                    data: $('#confirm_form').serialize(),
                    dataType:'json',
                    headers:
                    {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    success: function (html) {
                        alert(html)
                    }
                });
            }

        </script>

@stop
@section('javascript')
    {!! HTML::script('js/sales.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
@stop


