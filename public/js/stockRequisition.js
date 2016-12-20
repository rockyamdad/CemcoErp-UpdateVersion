jQuery(document).ready(function() {
    $('#Requisitiontable').DataTable({
        "bPaginate": false
    });
    $("#saveRequisition").live("click", function () {
        if(requisitionFormValidation()){
            $('#requisition_id').val(Math.floor(Math.random()*9999999999));
            $.ajax({
                type: "POST",
                url: "/saveRequisition",
                data :  $('#stock_requisition_form').serialize(),
                dataType:'json',
                success:function(requisition)
                {
                    $("#stock_requisition_form")[0].reset();
                    $("#branch_id").select2('val', '');
                    $("#product_id").select2('val', '');
                    $("#party_id").select2('val', '');

                    var html = [];
                    html.push('<td>' + requisition.branch + '</td>');
                    html.push('<td>' + requisition.party + '</td>');
                    html.push('<td>' + requisition.product + '</td>');
                    html.push('<td>' + requisition.quantity + '</td>');
                    if( requisition.remarks == ''){
                        html.push('<td>' + "Not Available" + '</td>');
                    }else{
                        html.push('<td>' + requisition.remarks + '</td>');
                    }
                    html.push('<td><input type="button"  id="deleteRequisition" style="width:70px;" value="delete" class="btn red deleteRequisition deleteRequisitionEdit" rel=' + requisition.id + ' ></td>');

                    html = '<tr>' + html.join('') + '<tr>';
                    $('#requisitionTable  > tbody:first').append(html);
                }
            });
        } else {
            alert('You forgot to fill something out');
        }
    });

    $('.deleteRequisition').live("click", function() {
        var requisitionId = $(this).attr('rel');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Requisition?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "requisitions/delete/"+requisitionId,
                dateType: 'json',
                success: function (data) {
                    parent.remove();
                }
            });
        }
    });

    function requisitionFormValidation() {

        var branch = $.trim($('#branch_id').val());
        var party = $.trim($('#party_id').val());
        var product = $.trim($('#product_id').val());
        var quantity = $.trim($('#requisition_quantity').val());
        if (party === '' || (product === '') || (quantity === '') || (branch ==='')) {
            return false;
        } else {
            return true;
        }
    }
    function requisitionEditFormValidation() {

        var branch = $.trim($('#edit_branch_id').val());
        var party = $.trim($('#party_id').val());
        var product = $.trim($('#product_id').val());
        var quantity = $.trim($('#requisition_quantity').val());
        alert(branch);

        if (party === '' || (product === '') || (quantity === '') || (branch ==='')) {
            return false;
        } else {
            return true;
        }
    }


    var form = $('#issued_requisition_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            issued_quantity: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        }

        /* submitHandler: function (form) {
         success1.show();
         error1.hide();
         }*/
    });

    $('select').select2();
    $('.issued').live("click", function() {
        var id =$(this).attr('rel');
        $('#requisitionId').val(id);

    });
    $('#branch_id').live("change", function () {
        var branch_id = $('#branch_id').val();
        $('#product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "products/"+branch_id,
            success: function (html) {
                $('#product_id').append(html);

            }
        });
    });

    $('.deleteRequisitionEdit').live("click", function() {
        var requisitionId = $(this).attr('rel');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Requisition?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "../delete/"+requisitionId,
                dateType: 'json',
                success: function (data) {
                    parent.remove();
                }
            });
        }
    });
    $('#edit_branch_id').live("change", function () {
        var branch_id = $('#edit_branch_id').val();
        $('#product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../products/"+branch_id,
            success: function (html) {
                $('#product_id').append(html);

            }
        });
    });
    $("#saveRequisitionEdit").live("click", function () {
        if(requisitionEditFormValidation()){
            $('#requisition_id').val(Math.floor(Math.random()*9999999999));
            $.ajax({
                type: "POST",
                url: "/saveRequisition",
                data :  $('#stock_requisition_form').serialize(),
                dataType:'json',
                success:function(requisition)
                {
                    $("#stock_requisition_form")[0].reset();

                    var html = [];
                    html.push('<td>' + requisition.branch + '</td>');
                    html.push('<td>' + requisition.party + '</td>');
                    html.push('<td>' + requisition.product + '</td>');
                    html.push('<td>' + requisition.quantity + '</td>');
                    if( requisition.remarks == ''){
                        html.push('<td>' + "Not Available" + '</td>');
                    }else{
                        html.push('<td>' + requisition.remarks + '</td>');
                    }
                    html.push('<td><input type="button"  id="deleteRequisition" style="width:70px;" value="delete" class="btn red  deleteRequisitionEdit" rel=' + requisition.id + ' ></td>');

                    html = '<tr>' + html.join('') + '<tr>';
                    $('#requisitionTable  > tbody:first').append(html);
                }
            });
        } else {
            alert('You forgot to fill something out');
        }
    });

});