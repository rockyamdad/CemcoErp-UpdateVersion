<script>
    function closeModal() {
        /*$('#sale').modal('hide');
         $('body').removeClass('modal-open');
         $('.modal-backdrop').hide();*/
        $("#ajax").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
</script>
<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Create Account Name</h3>
        </div>
        <div class="modal-body">
            {!!Form::open(array('url' => '/saveAccountName', 'method' => 'post', 'class'=>'form-horizontal account_name_form',
                     ))!!}
            <div class="form-body">

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
                            {!!HTML::decode(Form::label('branch_id','Choose Branch<span class="required">*</span>',array('class'
                            => 'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::select('branch_id',[null=>'Please Select Branch'] +$branchAll,'null',
                                array('class'=>'form-control ','id'=>'branch_id') )!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!HTML::decode(Form::label('account_category_id','Account Category<span class="required">*</span>',array('class'
                            => 'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::select('account_category_id',[null=>'Please Select Account Category'] +$accountCategoriesAll,'null', array('class'=>'form-control') )!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!HTML::decode(Form::label('name','Name<span class="required">*</span>',array('class' =>
                            'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::text('name',null,array('placeholder' => 'Name', 'class' =>
                                'form-control','id'=>'name'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!HTML::decode(Form::label('opening_balance','Opening Balance',array('class' =>
                            'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::text('opening_balance',0.0,array( 'class' =>
                                'form-control','id'=>'opening_balance'))!!}
                            </div>
                        </div>

                        <div class="form-actions fluid">
                            <div class="col-md-offset-3 col-md-9">
                                {!!Form::button('Save',array('type' => 'submit','class' => 'btn blue','id' => 'saveAccount'))!!}
                                <button type="button" onclick="closeModal()" data-dismiss="modal" class="btn">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {!!Form::close()!!}

            {{--          <div class="modal-footer">
                           <button type="button" data-dismiss="modal" class="btn">Close</button>
                           <button type="button" class="btn blue">Save changes</button>
                       </div>--}}

        </div>
    </div>
</div>
