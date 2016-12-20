<script>

</script>
<div class="modal-dialog shape" id="modal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Discount Percentage</h3>
        </div>
        <div class="modal-body">
            {!!Form::open(array('url' => '/saveReceive', 'method' => 'post', 'class'=>'form-horizontal payment_form',
            ))!!}
            <div class="form-body">

                <div class="alert alert-danger display-hide">
                    <button data-close="alert" class="close"></button>
                    You have some form errors. Please check below.
                </div>


                <div class="portlet-body form" id="testt">

                    <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="col-md-7">
                            {!!Form::text('discount_percentage',$sales->discount_percentage,array('placeholder' => 'Discount Percentage', 'class' =>
                            'form-control','id'=>'discount_percentage'))!!}

                        </div>

                    </div>
                </div>

            </div>
            {!!Form::close()!!}

                      <div class="modal-footer">
                          <button type="button" class="btn blue" onclick="addDiscountPercentage();">Save changes</button>
                          <button type="button" data-dismiss="modal" class="btn" onclick="closeModal();">Close</button>
                       </div>

        </div>
    </div>
</div>


<script>
    function closeModal(){
        $('#modal').modal('toggle');
        $("#sale").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
    function addDiscountPercentage(){
        var discount_percentage = $('#discount_percentage').val();
        $.ajax({
            type: "get",
            url: "savediscount/{{$sales->id}}",
            data:{'data':discount_percentage},
            dateType: 'json',
            success: function (data) {
                $('#modal').modal('toggle');
                $("#sale").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
                $('.modal-backdrop').hide();
//                $('#modal').modal('toggle').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
//                $('.modal-backdrop').hide();
            }
        });
    }
</script>
