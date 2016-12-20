jQuery(document).ready(function() {
    // Put page-specific javascript here

    var form = $('#sub_category_form');
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
    //        },
    //        branch_id: {
    //            required: true
    //        },
    //        category_id: {
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

    $('#add_branch_id').live("change", function () {
        var branch_id = $('#add_branch_id').val();
        $.ajax({
            type: "get",
            url: "branchCategory/"+branch_id,
            success: function (html) {
                $('#add_category_id').html(html);

            }
        });
    });
    $('#edit_branch_id').live("change", function () {
        var branch_id = $('#edit_branch_id').val();
        //alert(location.href);
        $.ajax({
            type: "get",
            url: "../categorybybranch/"+branch_id,
            success: function (html) {
                $('#edit_category_id').html(html);

            }
        });
    });

    $('select').select2();
})