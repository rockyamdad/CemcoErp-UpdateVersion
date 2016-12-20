<div class="tab-pane fade active in" id="proformaInvoice">

    {!!Form::open(array('url' => '/saveProformaInvoice', 'method' => 'post', 'class'=>'form-horizontal',
    'id'=>'imports_proforma_invoice_form'))!!}
    <div class="form-body">
        <div class="alert alert-danger display-hide">
            <button data-close="alert" class="close"></button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success display-hide">
            <button data-close="alert" class="close"></button>
            Your form validation is successful!
        </div>

        {!! Form::hidden('import_id',$imports->id) !!}

        <div class="form-group">
            {!! HTML::decode(Form::label('invoice_no','Invoice No<span class="required">*</span>',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('invoice_no',null,array('placeholder' => 'Invoice No', 'class' => 'form-control','id' =>
                'invoice_no'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('beneficiary_name','Beneficiary Name',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('beneficiary_name',null,array('placeholder' => 'Beneficiary Name', 'class' =>
                'form-control','id' => 'beneficiary_name'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('terms','Terms',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('terms',null,array('placeholder' => 'Terms', 'class' => 'form-control','id' =>
                'terms'))!!}
            </div>
        </div>


        <div class="form-actions fluid">
            <div class="col-md-offset-3 col-md-9">
                {!!Form::button('Save',array('type' => 'submit','class' => 'btn green','id' => 'save'))!!}
                {!!Form::button('Cancel',array('type'=>'reset', 'class' => 'btn default','id' => 'cancel'))!!}

            </div>
        </div>

        <!-- END FORM-->
    </div>
    {!!Form::close()!!}
</div>