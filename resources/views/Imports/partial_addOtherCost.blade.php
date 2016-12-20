<div class="tab-pane fade " id="otherCost">

    {!!Form::open(array('url' => '/saveOtherCost', 'method' => 'post', 'class'=>'form-horizontal',
    'id'=>'imports_other_costs_form'))!!}
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
            {!! HTML::decode(Form::label('dollar_to_bd_rate','Dollar Rate<span class="required">*</span>',array('class' => 'control-label col-md-3')))
            !!}
            <div class="col-md-4">
                {!!Form::text('dollar_to_bd_rate',null,array('placeholder' => 'Current Dollar Rate', 'class' =>
                'form-control','id' => 'dollar_to_bd_rate'))!!}
            </div>
        </div>



        <div id="tt">
            <div class="form-group">
                {!! HTML::decode(Form::label('tt_charge','Tt Amount',array('class' => 'control-label col-md-3'))) !!}
                <div class="col-md-4">
                    <input placeholder="Tt Charge" class="form-control" id="tt_charge" name="tt_charge[]" type="text" value="">

                </div>
            </div>

            <div class="form-group">
                {!! HTML::decode(Form::label('dollar_rate_per_tt','Dollar Rate',array('class' => 'control-label col-md-3'))) !!}
                <div class="col-md-4">
                    <input placeholder="Dollar rate" class="form-control" id="dollar_rate_per_tt" name="dollar_rate_per_tt[]" type="text" value="">
                </div>
            </div>

        </div>
        <div class="form-group">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <a class="btn red" onclick="addNewTT();">+</a>
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

<script>
    function addNewTT(){
        var html = "<div class='form-group'><label class='control-label col-md-3'>Tt Amount</label><div class='col-md-4'><input placeholder=\"Tt Charge\" class=\"form-control\" id=\"tt_charge\" name=\"tt_charge[]\" type=\"text\" value=\"\"></div></div>";
        html += "<div class='form-group'><label class='control-label col-md-3'>Dollar Rate</label><div class='col-md-4'><input placeholder=\"Dollar Rate\" class=\"form-control\" id=\"dollar_rate_per_tt\" name=\"dollar_rate_per_tt[]\" type=\"text\" value=\"\"></div></div>";
        $('#tt').append(html);
    }
</script>