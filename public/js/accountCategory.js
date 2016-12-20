jQuery(document).ready(function() {
    // Put page-specific javascript here
    $('#accountcategory_table').DataTable({
            "bPaginate": false
        }
    );
    var form = $('.account_category_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    //form.validate({
    //    errorElement: 'span', //default input error message container
    //    errorClass: 'help-block', // default input error message class
    //    focusInvalid: false, // do not focus the last invalid input
    //    ignore: "",
    //    rules: {
    //        name: {
    //            required: true
    //        }
    //
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



    $('.editAccount').live("click", function() {
        var id =$(this).attr('rel');
        var name = $(this).attr('data-ref');
        $('#accountCategoryId').val(id);
        $('#nameEdit').val(name);

    });
    $('select').select2();

    var formEdit = $('.account_category_form_edit');
    var error2 = $('.alert-danger', formEdit);
    var success2 = $('.alert-success', formEdit);

    formEdit.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            name: {
                required: true
            }

        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success2.hide();
            error2.show();
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

});