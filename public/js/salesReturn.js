jQuery(document).ready(function() {
    var form = $('#sales_return_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    //form.validate({
    //    errorElement: 'span', //default input error message container
    //    errorClass: 'help-block', // default input error message class
    //    focusInvalid: false, // do not focus the last invalid input
    //    ignore: "",
    //    rules: {
    //        party_id: {
    //            required: true
    //        },
    //        cus_ref_no: {
    //            required: true
    //        },
    //        branch_id: {
    //            required: true
    //        },
    //        product_type: {
    //            required: true
    //        },
    //        product_id: {
    //            required: true
    //        },
    //        quantity: {
    //            required: true
    //        },
    //        return_amount: {
    //            required: true
    //        },
    //        consignment_name: {
    //            required: true
    //        }
    //    },
    //
    //    invalidHandler: function (event, validator) { //display error alert on form submit
    //        success1.hide();
    //        error1.show();
    //        App.scrollTo(error1, -200);
    //    },
    //
    //    highlight: function (element) { // hightlight error inputs
    //        $(element)
    //            .closest('.form-group').addClass('has-error'); // set error class to the control group
    //    },
    //
    //    unhighlight: function (element) { // revert the change done by hightlight
    //        $(element)
    //            .closest('.form-group').removeClass('has-error'); // set error class to the control group
    //    },
    //
    //    success: function (label) {
    //        label
    //            .closest('.form-group').removeClass('has-error'); // set success class to the control group
    //    }
    //
    //    /* submitHandler: function (form) {
    //     success1.show();
    //     error1.hide();
    //     }*/
    //});

    $('select').select2();

    $('#product_type').live("change", function () {
        var product_type = $('#product_type').val();
        var branch = $('#branch_id').val();
        if (product_type != '' && branch != '') {
            $('#product_id').empty();
            var newOption = $('<option value="">Select Product</option>');
            $('#product_id').append(newOption);
            $.ajax({
                type: "get",
                url: "product/" + product_type,
                data: {'branch': branch, 'product_type': product_type},
                success: function (html) {
                    $('#product_id').append(html);
                }
            });
        }
    });

    $('#party_id').live("change", function () {
        $("#party_id").attr('readonly','readonly');
    });

    $('#product_status').live("change", function () {
        $("#product_status").attr('readonly','readonly');
    });

    $('#ref_no').live("focusout", function () {
        if($('#ref_no').val() != '') {
            $("#ref_no").attr('readonly', 'readonly');
        }
    });

    $('#discount_percentage').live("focusout", function () {
        if($('#discount_percentage').val() != '') {
            $("#discount_percentage").attr('readonly', 'readonly');
        }
    });


    $('#branch_id').live("change", function () {
        $("#branch_id").attr('readonly','readonly');
        var product_type = $('#product_type').val();
        var branch = $('#branch_id').val();
        if (product_type != '' && branch != '') {
            $('#product_id').empty();
            var newOption = $('<option value="">Select Product</option>');
            $('#product_id').append(newOption);
            $.ajax({
                type: "get",
                url: "product/" + product_type,
                data: {'branch': branch, 'product_type': product_type},
                success: function (html) {
                    $('#product_id').append(html);
                }
            });
        }
    });

    $('.saveSalesReturn').live("click", function () {
        var product_type = $('#product_type').val();
        var branch = $('#branch_id').val();
        var party_id = $('#party_id').val();
        var product_status = $('#product_status').val();
        var ref_no = $('#ref_no').val();
        var discount_percentage = $('#discount_percentage').val();
        var product_id = $('#product_id').val();
        var product_quantity = $('#quantity').val();
        var unit_price = $('#unit_price').val();
        var consignment_name = $('#consignment_name').val();
        var remarks = $('#remarks').val();

        if (product_type != '' && branch != '' && party_id != '' && product_status != '' && ref_no != '' && discount_percentage != '' && product_type != '' && product_id != '' && product_quantity != '' && unit_price != '') {
            $.ajax({
                type: "POST",
                data :  $('#sales_return_form').serialize(),
                url: "../saveSalesReturn",
                dataType:'json',
                success: function (stock) {
                    $("#product_type").select2('val', '');
                    $("#product_id").select2('val', '');
                    $("#consignment_name").select2('val', '');
                    $("#quantity").val('');
                    $("#remarks").val('');
                    $("#unit_price").val('');
                    $(".msg").hide();
                    $(".available").html('');

                    var html = [];
                    html.push('<td>' + stock.product_type + '</td>');
                    html.push('<td>' + stock.product_id + '</td>');
                    html.push('<td>' + stock.quantity + '</td>');
                    html.push('<td>' + stock.unit_price + '</td>');
                    html.push('<td>' + stock.consignment_name + '</td>');


                    html.push('<td><input type="button"   style="width:70px;" value="delete" class="btn red deleteStockDetail2" rel=' + stock.id + ' ></td>');

                    html = '<tr>' + html.join('') + '<tr>';
                    $('#stockTable  > tbody:first').append(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }else {
            alert('fill all fields');
        }
    });

    $('.deleteSaleReturnDetail').live("click", function() {

        var stockDetailId = $(this).attr('rel');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Stock Detail?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "delete/"+stockDetailId,
                dateType: 'json',
                success: function (data) {
                    parent.remove();
                    if(data != '')
                        location.reload();
                }
            });
        }
    });

});