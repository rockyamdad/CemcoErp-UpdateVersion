<div class="tab-pane fade" id="cnfCost">

    {!!Form::model($imports->cnfCost,array('action' => array('ImportController@postUpdateCnfCost',$imports->cnfCost->id), 'method' => 'post', 'class'=>'form-horizontal',
    'id'=>'imports_cnf_cost_form'))!!}
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
            {!! HTML::decode(Form::label('clearing_agent_name','Clearing Agent Name',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('clearing_agent_name',null,array('placeholder' => 'Clearing Agent Name', 'class' =>
                'form-control','id' => 'clearing_agent_name'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('bill_no','Bill No',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('bill_no',null,array('placeholder' => 'Bill No', 'class' => 'form-control','id' =>
                'bill_no'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('bank_no','Bank No',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('bank_no',null,array('placeholder' => 'Bank No', 'class' => 'form-control','id' =>
                'bank_no'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('association_fee','Association Fee ',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('association_fee',null,array('placeholder' => 'Association Fee ', 'class' =>
                'form-control','id' => 'association_fee'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('po_cash','PO Cash',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('po_cash',null,array('placeholder' => 'PO Cash', 'class' => 'form-control','id' =>
                'po_cash'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('port_charge','Port Charge',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('port_charge',null,array('placeholder' => 'Port Charge', 'class' => 'form-control','id' =>
                'port_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('shipping_charge','Shipping Charge',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('shipping_charge',null,array('placeholder' => 'Shipping Charge', 'class' =>
                'form-control','id' => 'shipping_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('noc_charge','NOC Charge',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('noc_charge',null,array('placeholder' => 'NOC Charge', 'class' => 'form-control','id' =>
                'noc_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('labour_charge','Labour Charge',array('class' => 'control-label col-md-3')))
            !!}
            <div class="col-md-4">
                {!!Form::text('labour_charge',null,array('placeholder' => 'Labour Charge', 'class' =>
                'form-control','id' => 'labour_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('jetty_charge','Jetty Charge',array('class' => 'control-label col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('jetty_charge',null,array('placeholder' => 'Jetty Charge', 'class' => 'form-control','id'
                => 'jetty_charge'))!!}
            </div>
        </div>
        <div class="form-group">
            {!! HTML::decode(Form::label('agency_commission','Agency Commission',array('class' => 'control-label
            col-md-3'))) !!}
            <div class="col-md-4">
                {!!Form::text('agency_commission',null,array('placeholder' => 'Agency Commission', 'class' =>
                'form-control','id' => 'agency_commission'))!!}
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