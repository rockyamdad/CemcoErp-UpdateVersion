jQuery(document).ready(function() {
    // Put page-specific javascript here
    /*$('#Expensetable').DataTable({
        "bPaginate": false
    });*/
    var form = $('#expense_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    //form.validate({
    //    errorElement: 'span', //default input error message container
    //    errorClass: 'help-block', // default input error message class
    //    focusInvalid: false, // do not focus the last invalid input
    //    ignore: "",
    //    rules: {
    //        category: {
    //            required: true
    //        },
    //        branch_id: {
    //            required: true
    //        },
    //        amount: {
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


    $('.deleteExpenseTransaction').live("click", function() {
        var transactionId = $(this).attr('rel');
        var account_id = $(this).attr('data-ref');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Expense Transaction?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "/deleteExpenseTransaction/"+transactionId,
                dateType: 'json',
                data:{'data':account_id},
                success: function (data) {
                    parent.remove();
                    var url = window.location.pathname;
                    window.location.href = url;
                }
            });
        }
    });


    $('#payment_method').live("change", function () {

        var payment_method = $('#payment_method').val();
        if(payment_method != 'Cash'){
            $( ".cheque_no_section" ).removeClass("hidden");
        }else{
            $( ".cheque_no_section" ).addClass("hidden");
        }
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


});