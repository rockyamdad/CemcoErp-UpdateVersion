<div class="tab-pane fade active in" id="importAdd">

    {!!Form::open(array('url' => '/saveImport', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'imports_form'))!!}
    <div class="form-body">
        <div class="alert alert-danger display-hide">
            <button data-close="alert" class="close"></button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success display-hide">
            <button data-close="alert" class="close"></button>
            Your form validation is successful!
        </div>

        <div class="form-group">
            {!!HTML::decode(Form::label('branch_id','Product Branch<span class="required">*</span>',array('class' => 'control-label col-md-3')))!!}
            <div class="col-md-4">
                {!!Form::select('branch_id',[null=>'Please Select Branch'] +$branchAll,'null', array('class'=>'form-control ','id'=>'add_branch_id') )!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('consignment_name','Consignment Name<span class="required">*</span>',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('consignment_name',null,array('placeholder' => 'Consignment Name', 'class' => 'form-control','id' => 'consignment_name'))!!}
            </div>
        </div>
        <div class="form-group">
            {!!HTML::decode(Form::label('description','Description',array('class' => 'control-label col-md-3')))!!}
            <div class="col-md-4">
                {!!Form::textarea('description',null,array('class' => 'form-control','id' => 'description', 'rows'=>'3'))!!}
            </div>
        </div>

        <div class="form-actions fluid">
            <div class="col-md-offset-3 col-md-9">
                {!!Form::button('Save',array('type' => 'submit','class' => 'btn green','id' => 'save'))!!}
                {!!Form::button('Cancel',array('type'=>'reset', 'class' => 'btn default','id' => 'cancel'))!!}

            </div>
        </div>
        {!!Form::close()!!}
        <!-- END FORM-->
    </div>
</div>
