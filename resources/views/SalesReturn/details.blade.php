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
            <h3>Sales Detail for {{$sr->branch->name}}</h3>
            <?php

            $party = \App\Party::where('id','=',$sr->party_id)->first();
            ?>

            <h4>Party Name : <?php echo $party->name; ?></h4>
            <h4>Product Status: <?php echo $sr->product_status; ?></h4>
            <h4>Ref noe : <?php echo $sr->ref_no; ?></h4>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-bordered table-hover"  id="saleDetailtable">
                <thead style="background-color: #68bbec">
                <tr>
                    <th>Product Type</th>
                    <th>Product Name</th>
                    <th>Discount Percentage</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Consignment Name</th>
                    <th>Remarks</th>
                    @if( Session::get('user_role') == "admin")
                    <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <?php $total = 0; ?>
                @foreach($srDetails as $srDetail )
                <?php
                //$branchName = \App\Branch::find($saleDetail->branch_id);

                $categoryName = \App\Category::find($srDetail->product->category_id);
                $subCategoryName = \App\SubCategory::find($srDetail->product->sub_category_id);
                        $total += $srDetail->quantity * $srDetail->unit_price;
                ?>
                <tr class="odd gradeX">
                    <td>{{$srDetail->product_type}}</td>
                    <td>{{$srDetail->product->name.'('.$categoryName->name.')'.'('.$subCategoryName->name.')'}}</td>
                    <td><?php echo $sr->discount_percentage; ?>%</td>
                    <td>{{$srDetail->quantity}}</td>
                    <td>{{$srDetail->unit_price}}</td>
                    <td>{{$srDetail->consignment_name}}</td>
                    <td>
                        @if($srDetail->remarks)
                        {{ $srDetail->remarks }}
                        @else
                        {{"Not Available"}}
                        @endif

                    </td>
                    @if( Session::get('user_role') == "admin")
                    <td>
                        <input type="button"   style="width:70px;" value="delete" class="btn red deleteSaleReturnDetail" rel='{{$srDetail->id}}' >
                        {{--<a class="btn red btn-sm" href="{{ URL::to('/deleteDetail/'.$stockDetail->id)}}"--}}
                           {{--onclick="return confirm('Are you sure you want to delete this item?');"><i--}}
                                {{--class="fa fa-trash-o"></i> Delete</a>--}}


                    </td>
                    @endif

                </tr>
                @endforeach

                </tbody>
            </table>

            <p>Total Return Amount: {{$total - (($total*$sr->discount_percentage)/100)}}</p>

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" data-dismiss="modal" class="btn">Close</button>
            </div>

        </div>
    </div>
</div>
