<div class="tab-pane fade  in" id="bankCost">

    {!!Form::model($imports->bankCost,array('action' =>array('ImportController@postUpdateBankCost',$imports->bankCost->id), 'method' => 'post', 'class'=>'form-horizontal',
    'id'=>'imports_bank_cost_form'))!!}
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
            {!! HTML::decode(Form::label('lc_no','L/C No',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('lc_no',null,array('placeholder' => 'L/C No', 'class' => 'form-control','id' =>
                'lc_no'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('bank_name','Bank Name',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('bank_name',null,array('placeholder' => 'Bank Name', 'class' => 'form-control','id' =>
                'bank_name'))!!}
            </div>
        </div>
        <div class="form-group">

            {!!HTML::decode(Form::label('lc_date','L/C Date:',array('class' =>
            'control-label col-md-3')))!!}
            <div class="col-md-4">
                <div class="input-append date input-icon" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <i class="fa fa-calendar"></i>
                    {!!Form::text('lc_date',$imports->bankCost->lc_date,array('size'=>'16','class' =>
                    'form-control m-wrap m-ctrl-medium date-picker'))!!}
                    <span class="add-on"><i class="icon-calendar"></i></span>

                </div>
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('lc_commission_charge','L/C Commission Charge',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('lc_commission_charge',null,array('placeholder' => 'L/C Commission Charge', 'class' =>
                'form-control','id' => 'lc_commission_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('vat_commission','Vat On Commission ',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('vat_commission',null,array('placeholder' => 'Vat On Commission ', 'class' =>
                'form-control','id' => 'vat_commission'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('stamp_charge','Stamp Charge',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('stamp_charge',null,array('placeholder' => 'Stamp Charge', 'class' => 'form-control','id'
                => 'stamp_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('swift_charge','Swift Charge',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('swift_charge',null,array('placeholder' => 'Swift Charge', 'class' => 'form-control','id'
                => 'swift_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('lca_charge','LCA Charge',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('lca_charge',null,array('placeholder' => 'LCA Charge', 'class' => 'form-control','id' =>
                'lca_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('insurance_charge','Insurance Charge',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('insurance_charge',null,array('placeholder' => 'Insurance Charge', 'class' =>
                'form-control','id' => 'insurance_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('bank_service_charge','Bank Service Charge',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('bank_service_charge',null,array('placeholder' => 'Bank Service Charge', 'class' =>
                'form-control','id' => 'bank_service_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('others_charge','Others Charge',array('class' => 'control-label col-md-3')))
            !!}
            <div class="col-md-4">
                {!!Form::text('others_charge',null,array('placeholder' => 'Others Charge', 'class' =>
                'form-control','id' => 'others_charge'))!!}
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
