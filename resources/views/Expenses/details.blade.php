<script>
    function closeModal() {
        /*$('#sale').modal('hide');
         $('body').removeClass('modal-open');
         $('.modal-backdrop').hide();*/
        $("#Expense").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
</script>
<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Expense Transaction</h3>
        </div>
        <div class="modal-body">

            <table class="table table-striped table-bordered table-hover"  id="expenseTransactiontable">
                <thead style="background-color:dodgerblue">
                <tr>
                    <th>Date</th>
                    <th>Branch</th>
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
                @foreach($expenseTransactions as $expenseTransaction )
                    <?php
                    $branch = \App\Branch::find($expenseTransaction->branch_id);
                    ?>
                    <tr class="odd gradeX">
                        <td>{{\App\Transaction::convertDate($expenseTransaction->created_at)}}</td>
                        <td>{{$branch->name}}</td>
                        <td>{{$expenseTransaction->accountCategory->name}}</td>
                        <td>{{$expenseTransaction->accountName->name}}</td>
                        <td>{{$expenseTransaction->payment_method}}</td>
                        <td>{{$expenseTransaction->cheque_no}}</td>
                        <td>{{$expenseTransaction->amount}}</td>
                        <td>
                            @if($expenseTransaction->remarks)
                                {{ $expenseTransaction->remarks }}
                            @else
                                {{"Not Available"}}
                            @endif

                        </td>
                        <td>
                            <a class="btn green" href="{{URL::to('expenses/voucher/'.$expenseTransaction->id)}}">Voucher</a>
                            @if( Session::get('user_role') == "admin")
                                <input type="button"  id="deleteExpenseTransaction" style="width:127px;" data-ref="{{$expenseTransaction->account_name_id}}" value="delete"   class="btn red deleteExpenseTransaction" rel={{$expenseTransaction->id}}  />
                            @endif

                        </td>
                        <?php $totalTransaction = $totalTransaction + $expenseTransaction->amount; ?>
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
                    <td> {{ $totalTransaction }}</td>
                </tr>

                </tbody>
            </table>
            <?php $result = $expense-$totalTransaction;?>
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
