<script>
    function closeModal() {
        /*$('#sale').modal('hide');
         $('body').removeClass('modal-open');
         $('.modal-backdrop').hide();*/
        $("#expensePayment").modal('hide').on('hidden.bs.modal', functionThatEndsUpDestroyingTheDOM);
        $('.modal-backdrop').hide();
    }
</script>
<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Make Payment</h3>
            <h5 style="color: red ;">You have {{$totalExpense - $transactionsPaid[0]->totalPaid}} taka Due </h5>
        </div>
        <div class="modal-body">
            {!!Form::open(array('url' => '/saveMake', 'method' => 'post', 'class'=>'form-horizontal payment_form',
                     ))!!}
            <div class="form-body">

                <div class="alert alert-danger display-hide">
                    <button data-close="alert" class="close"></button>
                    You have some form errors. Please check below.
                </div>


                <div class="portlet-body form" id="testt">
                    <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group">
                            {!!HTML::decode(Form::label('branch_id','Choose Branch<span class="required">*</span>',array('class'
                            => 'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::select('branch_id',[null=>'Please Select Branch'] +$branchAll,'null',
                                array('class'=>'form-control ','id'=>'branch') )!!}
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
                            <label class="control-label col-md-4">Choose Category Name<span class="required">*</span></label>

                            <div class="col-md-7">
                                <select id="account_name_id" name="account_name_id" class="form-control">
                                    <option value="">Select Category Name</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!!HTML::decode(Form::label('payment_method','Payment Method',array('class' => 'control-label col-md-4')))!!}
                            <div class="col-md-7">

                                {!! Form::select('payment_method',[null=>'Please Select Payment Method'] + array('Cash' => 'On Cash', 'Check' => 'On Check'),'null',
                                array('class'=>'form-control' ,'id'=>'payment_method'))!!}
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-md-4"></label>
                            <div class="col-md-7 balance_show">
                            </div>
                        </div>
                        <div class="form-group hidden  cheque_no_section">
                            {!!HTML::decode(Form::label('cheque_no','Cheque No',array('class' =>
                            'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::text('cheque_no',null,array('placeholder' => 'Cheque No', 'class' =>
                                'form-control','id'=>'cheque_no'))!!}
                            </div>
                        </div>
                        <div class="form-group hidden  cheque_no_section">
                            {!!HTML::decode(Form::label('cheque_date','Cheque Date',array('class' =>
                            'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                <div class="input-append date input-icon" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                    <i class="fa fa-calendar"></i>
                                    {!!Form::text('cheque_date',null,array('size'=>'16','class' =>
                                    'form-control m-wrap m-ctrl-medium date-picker'))!!}
                                    <span class="add-on"><i class="icon-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden  cheque_no_section">
                            {!!HTML::decode(Form::label('cheque_bank','Cheque Bank',array('class' =>
                            'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::text('cheque_bank',null,array('placeholder' => 'Cheque Bank', 'class' =>
                                'form-control','id'=>'cheque_bank'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!HTML::decode(Form::label('amount','Amount<span class="required">*</span>',array('class' =>
                                           'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::text('amount',null,array('placeholder' => 'Amount', 'class' =>
                                               'form-control','id'=>'amount'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!HTML::decode(Form::label('remarks','Remarks',array('class' =>
                                          'control-label col-md-4')))!!}
                            <div class="col-md-7">
                                {!!Form::text('remarks',null,array('placeholder' => 'Remarks', 'class' =>
                                'form-control','id'=>'remarks'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5">
                                {!!Form::hidden('invoice_id',$invoice_id,array('class' => 'form-control ','id'=>'invoice_id'))!!}
                            </div>
                        </div>
                        <div class="form-actions fluid">
                            <div class="col-md-offset-3 col-md-9">
                                {!!Form::button('Save',array('type' => 'submit','class' => 'btn blue','id' => 'savePayment'))!!}
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

<script>
    $('.date-picker').datepicker();
</script>
