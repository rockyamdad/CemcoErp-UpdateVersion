<div class="tab-pane fade active in" id="ImportDetailsAdd">
    {!!Form::open(array('url' => '/saveImportDetails', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'imports_details_form'))!!}
    <div class="form-body">
        <div class="alert alert-danger display-hide">
            <button data-close="alert" class="close"></button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success display-hide">
            <button data-close="alert" class="close"></button>
            Your form validation is successful!
        </div>
        {!! Form::hidden('import_num',$imports->id) !!}
        <div class="form-group">
            {!!HTML::decode(Form::label('product_id','Choose Product <span class="required">*</span>',array('class' => 'control-label col-md-3')))!!}
            <div class="col-md-4">
                {!!Form::select('product_id',[null=>'Please Select Product'] +$productAll,'null', array('class'=>'form-control','id'=>'product_id') )!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('quantity','Quantity<span class="required">*</span>',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('quantity',null,array('placeholder' => 'Quantity', 'class' => 'form-control','id' => 'quantity'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('total_booking_price','Booking Price/Unit',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('total_booking_price',null,array('placeholder' => 'Booking Price', 'class' => 'form-control','id' => 'total_booking_price'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('total_cfr_price','CFR Price/Unit',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('total_cfr_price',null,array('placeholder' => 'CFR Price', 'class' => 'form-control','id' => 'total_cfr_price'))!!}
            </div>
        </div>

        <div class="form-actions fluid">
            <div class="col-md-offset-3 col-md-9">
                {!!Form::button('Save',array('type' => 'submit','class' => 'btn green','id' => 'save'))!!}
                {!!Form::button('Cancel',array('type'=>'reset', 'class' => 'btn default','id' => 'cancel'))!!}

            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
