jQuery(document).ready(function() {
    // Put page-specific javascript here

    $('#savePayment').live("click", function () {

        var form = $('.payment_form');
        var error1 = $('.alert-danger', form);
        var success1 = $('.alert-success', form);

        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                amount: {
                    required: true
                },
                account_category_id: {
                    required: true
                },
                account_name_id: {
                    required: true
                },
                payment_method: {
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


        });
    });

    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var invoice = $(this).attr('rel');
        $.get(url, function(data) {
            $(data).modal();
            $('#invoice_id').val(invoice);
        });
    });
    //$('select').select2();


    $('#account_category_id').live("change", function () {
        var account_category = $('#account_category_id').val();
        var branch = $('#branch').val();
        $('#account_name_id').empty();
        var newOption = $('<option value="">Select Account</option>');
        $('#account_name_id').append(newOption);
        $.ajax({
            type: "get",
            url: "categories/"+account_category,
            data:{'data':branch},
            success: function (html) {
                $('#account_name_id').append(html);

            }
        });
    });
    $('#account_name_id').live("change", function () {
        var account_id = $('#account_name_id').val();
        $.ajax({
            type: "get",
            url: "accountbalance/"+account_id,
            success: function (html) {
                $('.balance_show').html(html);

            }
        });
    });
    $('#p_account_category_id').live("change", function () {
        var account_category = $('#p_account_category_id').val();
        var branch = $('#p_branch_id').val();
        $('#p_account_name_id').empty();
        var newOption = $('<option value="">Select Account</option>');
        $('#p_account_name_id').append(newOption);
        $.ajax({
            type: "get",
            url: "categories/"+account_category,
            data:{'data':branch},
            success: function (html) {
                $('#p_account_name_id').append(html);

            }
        });
    });
    $('#p_account_name_id').live("change", function () {
        var account_id = $('#p_account_name_id').val();
        $.ajax({
            type: "get",
            url: "accountbalance/"+account_id,
            success: function (html) {
                $('.balance_show').html(html);

            }
        });
    });
    $('#p_party_id').live("change", function () {
        var party_id = $('#p_party_id').val();
        $.ajax({
            type: "get",
            url: "partydue/"+party_id,
            success: function (html) {
                $('.due_show').html(html);

            }
        });
    });
});