<script>
    function closeModal() {
        /*$('#sale').modal('hide');
         $('body').removeClass('modal-open');
         $('.modal-backdrop').hide();*/
        $("#purchaseInvoice").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
</script>
<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <?php
            $party = new \App\Party();
            $partyName = \App\Party::find($purchase->party_id);
            ?>
            <h3>Purchase Invoice Detail for {{$partyName->name}}</h3>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-bordered table-hover"  id="PurchaseDetailtable">
                <thead style="background-color: #68bbec">
                <tr>
                    <th>Branch Name</th>
                    <th>Stock Name</th>
                    <th>Product Type</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $total = 0; ?>
                @foreach($purchaseInvoiceDetails as $purchaseInvoiceDetail )
                    <?php
                    $stocks = new \App\StockInfo();
                    $branch = new \App\Branch();
                    $stockName = \App\StockInfo::find($purchaseInvoiceDetail->stock_info_id);
                    $branchName = \App\Branch::find($purchaseInvoiceDetail->branch_id);

                    $categoryName = \App\Category::find($purchaseInvoiceDetail->product->category_id);
                    $subCategoryName = \App\SubCategory::find($purchaseInvoiceDetail->product->sub_category_id);
                    ?>
                    <tr class="odd gradeX">
                        <td>{{$branchName->name}}</td>
                        <td>{{$stockName->name}}</td>
                        <td>{{$purchaseInvoiceDetail->product_type}}</td>
                        <td>{{$purchaseInvoiceDetail->product->name.'('.$categoryName->name.')'.'('.$subCategoryName->name.')'}}</td>
                        <td>{{$purchaseInvoiceDetail->price}}</td>
                        <td>{{$purchaseInvoiceDetail->quantity}}</td>
                        <td>{{$purchaseInvoiceDetail->quantity * $purchaseInvoiceDetail->price}}</td>
                        <td>
                            @if($purchaseInvoiceDetail->remarks)
                                {{ $purchaseInvoiceDetail->remarks }}
                            @else
                                {{"Not Available"}}
                            @endif

                        </td>
                        <td>
                            @if( Session::get('user_role') == "admin")
                                <a class="btn red btn-sm" href="{{ URL::to('purchases/deletepurchasedetail/'.$purchaseInvoiceDetail->id)}}"
                                   onclick="return confirm('Are you sure you want to delete this item?');"><i
                                            class="fa fa-trash-o"></i> Delete</a>
                            @endif

                        </td>
                    <?php $total = $total + ($purchaseInvoiceDetail->price * $purchaseInvoiceDetail->quantity); ?>
                    </tr>
                @endforeach
                <tr style="background-color:#b2b2b2">
                    <td>Total Amount</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> {{ $total }}</td>
                </tr>
                </tbody>
            </table>
            <br>
            <h3>Purchase Invoice Transaction</h3>
            <table class="table table-striped table-bordered table-hover"  id="PurchaseTransactiontable">
                <thead style="background-color:lightskyblue">
                <tr>
                    <th>Date</th>
                    <th>Account Category</th>
                    <th>Account Name</th>
                    <th>Payment Method</th>
                    <th>Cheque No</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $totalTransaction = 0; ?>
                @foreach($purchaseInvoiceTransactions as $purchaseInvoiceTransaction )
                    <tr class="odd gradeX">
                        <td>{{\App\Transaction::convertDate($purchaseInvoiceTransaction->created_at)}}</td>
                        <td>{{$purchaseInvoiceTransaction->accountCategory->name}}</td>
                        <td>{{$purchaseInvoiceTransaction->accountName->name}}</td>
                        <td>{{$purchaseInvoiceTransaction->payment_method}}</td>
                        <td>
                            @if($purchaseInvoiceTransaction->cheque_no)
                                {{ $purchaseInvoiceTransaction->cheque_no }}
                            @else
                                {{"Not Available"}}
                            @endif
                        </td>
                        <td>{{$purchaseInvoiceTransaction->amount}}</td>
                        <td>
                            @if($purchaseInvoiceTransaction->remarks)
                                {{ $purchaseInvoiceTransaction->remarks }}
                            @else
                                {{"Not Available"}}
                            @endif

                        </td>
                        <td>
                            <a class="btn green" href="{{URL::to('purchases/voucher/'.$purchaseInvoiceTransaction->id)}}">Voucher</a>
                            @if( Session::get('user_role') == "admin")
                                <input type="button"  id="deletePurchaseTransaction" style="width:127px;" value="delete" data-ref="{{$purchaseInvoiceTransaction->account_name_id}}"  onclick="return confirm('Are you sure you want to delete this item?');" class="btn red deletePurchaseTransaction" rel={{$purchaseInvoiceTransaction->id}}  />
                            @endif

                        </td>
                        <?php $totalTransaction = $totalTransaction + $purchaseInvoiceTransaction->amount; ?>
                    </tr>
                @endforeach

                <tr style="background-color:#b2b2b2">
                    <td>Total Amount</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> {{ $totalTransaction }}</td>
                </tr>

                </tbody>
            </table>
            <?php $result = $total-$totalTransaction;?>
            @if($result <=0)
                <h4 style="color: green;margin-left: 260px;">You don't have any due</h4>
            @else
                <h4 style="color: red ;margin-left: 260px;">You have {{$result}} taka Due </h4>
            @endif

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" data-dismiss="modal" class="btn">Close</button>
            </div>

        </div>
    </div>
</div>
