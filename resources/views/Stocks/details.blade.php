<script>
    function closeModal() {
        /*$('#sale').modal('hide');
         $('body').removeClass('modal-open');
         $('.modal-backdrop').hide();*/
        $("#sale").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
</script>
<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <?php
            $branch = new \App\Branch();
            $branchName = \App\Branch::find($stock->branch_id);
            ?>
            <h3>Stock Detail for {{$branchName->name}}</h3>
            <?php
                $stockdetails = \App\StockDetail::where('invoice_id','=',$stock->invoice_id)->first();
                //var_dump($stock->invoice_id); die();
                $stockName = \App\StockInfo::find($stockdetails->stock_info_id);
            ?>

            <h4>Branch Name : <?php echo $branchName->name; ?></h4>
            <h4>Stock Name : <?php echo $stockName->name; ?></h4>
            <h4>Product Type : <?php echo $stockdetails->product_type; ?></h4>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-bordered table-hover"  id="saleDetailtable">
                <thead style="background-color: #68bbec">
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                    @if( Session::get('user_role') == "admin")
                    <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <?php $total = 0; ?>
                @foreach($stockDetails as $stockDetail )
                <?php
                $stocks = new \App\StockInfo();
                $branch = new \App\Branch();
                $stockName = \App\StockInfo::find($stockDetail->stock_info_id);
                //$branchName = \App\Branch::find($saleDetail->branch_id);

                $categoryName = \App\Category::find($stockDetail->product->category_id);
                $subCategoryName = \App\SubCategory::find($stockDetail->product->sub_category_id);
                ?>
                <tr class="odd gradeX">
                    <td>{{$stockDetail->product->name.'('.$categoryName->name.')'.'('.(($subCategoryName!=null)?$subCategoryName->name: '').')'}}</td>
                    <td>{{$stockDetail->quantity}}</td>
                    <td>
                        @if($stockDetail->remarks)
                        {{ $stockDetail->remarks }}
                        @else
                        {{"Not Available"}}
                        @endif

                    </td>
                    @if( Session::get('user_role') == "admin")
                    <td>
                        @if ($stock->confirmation == 0)
                        <input type="button"   style="width:70px;" value="delete" class="btn red deleteStockDetail" rel='{{$stockDetail->id}}' >
                        @endif
                        {{--<a class="btn red btn-sm" href="{{ URL::to('/deleteDetail/'.$stockDetail->id)}}"--}}
                           {{--onclick="return confirm('Are you sure you want to delete this item?');"><i--}}
                                {{--class="fa fa-trash-o"></i> Delete</a>--}}


                    </td>
                    @endif

                </tr>
                @endforeach

                </tbody>
            </table>

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" data-dismiss="modal" class="btn">Close</button>
            </div>

        </div>
    </div>
</div>

