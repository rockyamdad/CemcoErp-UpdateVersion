jQuery(document).ready(function() {
    // Put page-specific javascript here
    $('#stock_table').DataTable({
        "bPaginate": false
    });
    var form = $('#balance_transfer_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            from_branch_id: {
                required: true
            },
            to_branch_id: {
                required: true
            },
            from_account_category_id: {
                required: true
            },
            to_account_category_id: {
                required: true
            },
            from_account_name_id: {
                required: true
            },
            to_account_name_id: {
                required: true
            },
            amount: {
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
    $('#from_account_name_id').live("change", function () {
        var account_id = $('#from_account_name_id').val();
        $.ajax({
            type: "get",
            url: "accountbalance/"+account_id,
            success: function (html) {
                $('.balance_show').html(html);

            }
        });
    });
    $('#to_account_name_id').live("change", function () {
        var account_id = $('#to_account_name_id').val();
        $.ajax({
            type: "get",
            url: "accountbalance/"+account_id,
            success: function (html) {
                $('.balance_show2').html(html);

            }
        });
    });
    $('#from_account_category_id').live("change", function () {
        var from_account_category_id = $('#from_account_category_id').val();
        var branch = $('#from_branch_id').val();
        $('#from_account_name_id').empty();
        var newOption = $('<option value="">Select Account</option>');
        $('#from_account_name_id').append(newOption);
        $.ajax({
            type: "get",
            url: "categories/"+from_account_category_id,
            data:{'data':branch},
            success: function (html) {
                $('#from_account_name_id').append(html);

            }
        });

    });
    $('#to_account_category_id').live("change", function () {
        var to_account_category_id = $('#to_account_category_id').val();
        var branch = $('#to_branch_id').val();
        $('#to_account_name_id').empty();
        var newOption = $('<option value="">Select Account</option>');
        $('#to_account_name_id').append(newOption);
        $.ajax({
            type: "get",
            url: "categories/"+to_account_category_id,
            data:{'data':branch},
            success: function (html) {
                $('#to_account_name_id').append(html);

            }
        });

    });

    $('select').select2();
    $('#to_account_name_id').live("change", function () {
        var to_account_id = $('#to_account_name_id').val();
        var from_account_id = $('#from_account_name_id').val();
        if(to_account_id == from_account_id){
            alert('Opps!! You choose same Account' );
            var url      = window.location.pathname;
            window.location.href = url;
        }
        if(!from_account_id){
            alert('Opps!!You have to choose from Account name' );
            var url      = window.location.pathname;
            window.location.href = url;
        }



    });

});