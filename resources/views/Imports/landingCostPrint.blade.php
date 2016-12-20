<div class="modal-dialog shape">

<style>
th {
    font-size: 80%;
}
td {
    font-size: 80%;
}
table {
    border-collapse: collapse;
}
table.tabFont {
  font-size: 80%;
}
h3{
text-decoration: underline;
}
</style>
<?php
    $crfTotal=0;
    $bookingTotal=0;
?>
@foreach($imports as $importtr )
    <?php
        $crfTotal = $crfTotal + ($importtr->total_cfr_price * $importtr->quantity);
        $bookingTotal = $bookingTotal + ($importtr->total_booking_price * $importtr->quantity);
    ?>
@endforeach
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          {{--<center> <h2>Landing Cost CemcoGroup</h2></center>--}}
          <div>
          <table class="tabFont">
            <tr>
                <td><strong>Benificiary Name </strong></td>
                <td>:<strong>  {{ $benificiaryName[0]['beneficiary_name'] }} </strong></td>
            </tr>
            <tr>
                <td><strong>L/C No </strong></td>
                <td>:<strong>  {{ $totalBankCost[0]['lc_no'] }}</strong></td>
            </tr>
            <tr>
                <td><strong>Total L/C Value</strong> </td>
                <td>: <strong>  {{ $crfTotal }}</strong></td>
            </tr>
            <tr>
                <td><strong>Actual Goods Value</strong> </td>
                <td>: <strong>  {{ $bookingTotal }}</strong></td>
            </tr>
            <tr>
                <td><strong>Clearing Agent</strong></td>
                <td>: <strong>  {{ $totalCnfCost[0]['clearing_agent_name'] }}</strong></td>
            </tr>
            <tr>
                <td><strong>Clearing Date</strong></td>
                <td>: <strong>  {{ $totalCnfCost[0]['clearing_date'] }}</strong></td>
            </tr>
          </table>
          </div>
          <br>
        </div>
        <div class="modal-body">
            <div class="portlet-body no-more-tables">
                <?php $grandTotalCrf = 0; ?>
                @foreach($imports as $importtt )
                    <?php $grandTotalCrf = $grandTotalCrf + ($importtt->total_cfr_price * $importtt->quantity); ?>
                @endforeach

                <table border="1" class="table-bordered table-striped table-condensed cf" id="landingCost_table">
                    <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Product Name</th>
                        <th style="text-align: right;">Booking ($)</th>
                        <th style="text-align: right;">Booking (BDT)</th>
                        <th style="text-align: right;">CFR ($)</th>
                        <th style="text-align: right;">CFR (taka)</th>
                        <th style="text-align: right;">Qty</th>
                        <th style="text-align: right;">Duty</th>
                        <th style="text-align: right;">Lan. Cost</th>
                        <th style="text-align: right;">T. Booking ($)</th>
                        <th style="text-align: right;">T. CFR ($)</th>
                        <th style="text-align: right;">T. Duty</th>
                        <th style="text-align: right;">T. Lan. Cost</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $totalQuantity = 0;
                    $totalBookingPrice = 0;
                    $totalCrfPrice = 0;
                    $totalDuty = 0;
                    $totalLandingCost = 0;
                    ?>
                    @foreach($imports as $importt )
                        <tr class="odd gradeX">
                            <?php
                            $value = ($importt->po_cash * 100) / ($grandTotalCrf * $importt->dollar_to_bd_rate);
                            $duty = ($importt->total_cfr_price * $importt->dollar_to_bd_rate) * $value / 100;


                            $totalQuantity = $totalQuantity + $importt->quantity;
                            $totalBookingPrice = $totalBookingPrice + ($importt->total_booking_price * $importt->quantity);
                            $totalCrfPrice = $totalCrfPrice + ($importt->total_cfr_price * $importt->quantity);

                            $totalDuty = $totalDuty + ($duty * $importt->quantity);

                            $landingCost = (($ttCharge[0]['tt_charge'] + $totalBankCost[0]['total_bank_cost'] + $totalCnfCost[0]['total_cnf_cost'])/$totalQuantitySum ) + ($importt->total_booking_price * $importt->dollar_to_bd_rate) + $duty;

                            $totalLandingCost = $totalLandingCost + ($landingCost * $importt->quantity);
                            $categoryName = \App\Category::find($importt->category_id);
                            $products = \App\Product::find($importt->product_id);

                            if($products->sub_category_id){
                                $subCategory = \App\SubCategory::find($products->sub_category_id);
                                $subCategoryName = '('.$subCategory->name.')';
                            }
                            else{
                                $subCategoryName = '';
                            }
                            ?>
                            <td>{{ $i }}</td>
                            <td>{{ $importt->name.'('.$categoryName->name.')'.$subCategoryName }}</td>
                            <td style="text-align: right;">{{ $importt->total_booking_price }}</td>
                            <td style="text-align: right;">{{ $importt->total_booking_price * $importt->dollar_to_bd_rate }}</td>
                            <td style="text-align: right;">{{ $importt->total_cfr_price }}</td>
                            <td style="text-align: right;">{{ $importt->total_cfr_price * $importt->dollar_to_bd_rate }}</td>
                            <td style="text-align: right;">{{ $importt->quantity }}</td>
                            <td style="text-align: right;">{{ round($duty,2) }}</td>
                            <td style="text-align: right;">{{ round($landingCost,2) }}</td>
                            <td style="text-align: right;">{{ $importt->quantity * $importt->total_booking_price }}</td>
                            <td style="text-align: right;">{{ $importt->quantity * $importt->total_cfr_price }}</td>
                            <td style="text-align: right;">{{ round($duty * $importt->quantity,2) }}</td>
                            <td style="text-align: right;">{{ round($landingCost * $importt->quantity,2)}}</td>

                        </tr>
                        <?php $i++ ?>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">{{ $totalQuantity }}</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">{{ $totalBookingPrice }}</td>
                        <td style="text-align: right;">{{ $totalCrfPrice }}</td>
                        <td style="text-align: right;">{{ $totalDuty }}</td>
                        <td style="text-align: right;">{{ round($totalLandingCost,2) }}</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div style="font-size: 80%;">
                <?php $total = $ttCharge[0]['tt_charge'] + $totalBankCost[0]['total_bank_cost'] + $totalCnfCost[0]['total_cnf_cost'] ?>
                <h3>Additional Cost:</h3>
                <strong>Cnf Bill:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$totalCnfCost[0]['total_cnf_cost']}}<br>
                <strong>Bank & Others Cost:</strong>&nbsp;&nbsp;&nbsp;{{$totalBankCost[0]['total_bank_cost']}}<br>
                <strong>Tt Charge:</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{$ttCharge[0]['tt_charge']}}
                <hr>
                <strong>Total:</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{$total}}<br>
                <strong>Miss Cost Per Product:</strong>{{round($total/$totalQuantity,2)}}

            </div>
                      {{--  <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn">Close</button>
                            <button type="button" class="btn blue"  onClick="window.print()">Print</button>
                        </div>--}}

        </div>
    </div>
</div>
