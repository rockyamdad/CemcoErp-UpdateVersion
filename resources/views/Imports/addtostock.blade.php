<script>
    function closeModal() {
        /*$('#sale').modal('hide');
         $('body').removeClass('modal-open');
         $('.modal-backdrop').hide();*/
        $("#salePayment").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
</script>
<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">

            <div class="form-body">
                jdaskjd kasdjlkas
            </div>
            {{--          <div class="modal-footer">
                           <button type="button" data-dismiss="modal" class="btn">Close</button>
                           <button type="button" class="btn blue">Save changes</button>
                       </div>--}}

        </div>
    </div>
</div>