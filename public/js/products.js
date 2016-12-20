jQuery(document).ready(function() {

    var form = $('#product_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            name: {
                required: true
            },
            branch_id: {
                required: true
            },
            category_id: {
                required: true
            },
            product_type: {
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

    $('#products_branch_id').live("change", function () {
        var branch_id = $('#products_branch_id').val();
        $('#products_category_id').empty();
        var newOption = $('<option value="">Choose Category</option>');
        $('#products_category_id').append(newOption);
        $.ajax({
            type: "get",
            url: "category/"+branch_id,
            success: function (html) {
                $('#products_category_id').append(html);

            }
        });
    });

    $('#products_category_id').live("change", function () {

        var category_id = $('#products_category_id').val();
        var branch_id = $('#products_branch_id').val();
        $('#products_sub_category_id').empty();
        var newOption = $('<option value="">Choose Sub Category</option>');
        $('#products_sub_category_id').append(newOption);
        $.ajax({
            type: "get",
            url: "sub/"+category_id,
            data: "branch_id=" + branch_id ,
            success: function (html) {
                $('#products_sub_category_id').append(html);

            }
        });
    });

    $('#category_id').live("change", function () {
        var category_id = $('#category_id').val();
        $('#product_id').empty();
        var newOption = $('<option value="">Choose Product</option>');
        $('#product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "products/"+category_id,
            success: function (html) {
                $('#product_id').append(html);

            }
        });
    });

    $('select').select2();

    $('#products_edit_branch_id').live("change", function () {
        var branch_id = $('#products_edit_branch_id').val();
        $.ajax({
            type: "get",
            url: "../category/"+branch_id,
            success: function (html) {
                $('#products_edit_category_id').html(html);

            }
        });
    });
    $('#products_edit_category_id').live("change", function () {
        var category_id = $('#products_edit_category_id').val();
        var branch_id = $('#products_edit_branch_id').val();
        $('#products_edit_sub_category_id').empty();
        var newOption = $('<option value="">Select Sub Category</option>');
        $('#products_edit_sub_category_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../sub/"+category_id,
            data: {'branch_id':branch_id},
            success: function (html) {
                $('#products_edit_sub_category_id').append(html);

            }
        });
    });

    var branch_id = $('#products_edit_branch_id').val();
    var category_id = $('#products_edit_category_id').attr('rel');
    $.ajax({
        type: "get",
        url: "../category/"+branch_id,
        data:{'data':category_id},
        success: function (html) {
            $('#products_edit_category_id').append(html);

        }
    });


    var branch_id = $('#products_edit_branch_id').val();
    var sub_category_id = $('#products_edit_sub_category_id').attr('rel');
    $.ajax({
        type: "get",
        url: "../sub/"+category_id,
        data: {'branch_id':branch_id,'data':sub_category_id},
        success: function (html) {
            $('#products_edit_sub_category_id').append(html);

        }
    });

});