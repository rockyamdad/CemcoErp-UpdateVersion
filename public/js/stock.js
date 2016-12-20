jQuery(document).ready(function() {
    // Put page-specific javascript here
    $('#stock_table').DataTable({
        "bPaginate": false
    });
    var form = $('#stock_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            product_type: {
                required: true
            },
            product_id: {
                required: true
            },
            branch_id: {
                required: true
            },
            stock_info_id: {
                required: true
            },
            entry_type: {
                required: true
            },
            product_quantity: {
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

    $('#product_type').live("change", function () {
        var product_type = $('#product_type').val();
        var branch = $('#products_branch_id').val();
        $('#product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "products/"+product_type,
            data:{'branch_id':branch},
            success: function (html) {
                $('#product_id').append(html);


            }
        });
    });
    $('#edit_product_type').live("change", function () {
        var product_type = $('#edit_product_type').val();
        var branch = $('#products_branch_id').val();
        $('#edit_product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#edit_product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../products/"+product_type,
            data:{'data':branch},
            success: function (html) {
                $('#edit_product_id').append(html);

            }
        });
    });

    $('#entry_type').live("change", function () {
        var entry_type = $('#entry_type').val();
        var product_type = $('#product_type').val();
        if((entry_type=='StockIn') && ((product_type =='Foreign') || (product_type == 'Finish Goods') ))
        {
            $('.to_stock_section').hide();
            $('.consignment_name_section').show();
            $.ajax({
                type: "get",
                url: "imports",
                success: function (html) {
                    $('#consignment_name').html(html);

                }
            });

        }
        if(entry_type=='Transfer')
        {
            $('.to_stock_section').show();
            $('.consignment_name_section').hide();
            $.ajax({
                type: "get",
                url: "stocks/infos",
                success: function (html) {
                    $('#to_stock_info_id').html(html);

                }
            });

        }
        if(entry_type=='Wastage')
        {
            $('.to_stock_section').hide();
            $('.consignment_name_section').hide();
        }
        if(entry_type=='StockOut')
        {
            $('.to_stock_section').hide();
            $('.consignment_name_section').hide();
        }


    });
    $('#edit_entry_type').live("change", function () {
        var entry_type = $('#edit_entry_type').val();
        var product_type = $('#edit_product_type').val();
        if((entry_type=='StockIn') && ((product_type =='Foreign') || (product_type == 'Finish Goods') ))
        {
            $('.to_stock_section').hide();
            $('.consignment_name_section').show();
            $.ajax({
                type: "get",
                url: "../imports",
                success: function (html) {
                    $('#consignment_name').html(html);

                }
            });

        }
        if(entry_type=='Transfer')
        {
            $('.to_stock_section').show();
            $('.consignment_name_section').hide();
            $.ajax({
                type: "get",
                url: "../stocks/infos",
                success: function (html) {
                    $('#to_stock_info_id').html(html);

                }
            });

        }
        if(entry_type=='Wastage')
        {
            $('.to_stock_section').hide();
            $('.consignment_name_section').hide();
        }
        if(entry_type=='StockOut')
        {
            $('.to_stock_section').hide();
            $('.consignment_name_section').hide();
        }

    });

    $('select').select2();

    var entry_type = $('#edit_entry_type').val();
    var product_type = $('#edit_product_type').val();
    if(entry_type=='' || (entry_type !='StockIn' &&  product_type !='Local')){
        $('.consignment_name_section').hide();
    }
    if(entry_type!='Transfer')
    {
        $('.to_stock_section').hide();
    }




    $('#product_id').live("change", function () {
        var product_id = $('#product_id').val();
        var stock_info_id = $('#stock_info_id').val();
        $.ajax({
            type: "get",
            url: "quantity",
            data:{'stock_info_id':stock_info_id,'product_id':product_id},
            success: function (html) {
                $('.available').html(html);

            }
        });
    });
    $('#stock_info_id').live("change", function () {
        var product_id = $('#product_id').val();
        var stock_info_id = $('#stock_info_id').val();
        $.ajax({
            type: "get",
            url: "quantity",
            data:{'stock_info_id':stock_info_id,'product_id':product_id},
            success: function (html) {
                $('.available').html(html);

            }
        });
    });

    var entry_type = $('#edit_entry_type').val();
    var stock_id = $('#to_stock_info_id').attr('rel');
    if(entry_type=='Transfer')
    {
        $('.to_stock_section').show();
        $('.consignment_name_section').hide();
        $.ajax({
            type: "get",
            url: "../stocks/infos",
            data:{'data':stock_id},
            success: function (html) {
                $('#to_stock_info_id').html(html);

            }
        });

    }
    $('#edit_product_type').live("change", function () {
        var branch = $('#products_branch_id').val();
        var edit_product_id = $('#edit_product_id').attr('rel');
        var edit_product_type = $('#edit_product_type').val();
        $('#edit_product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#edit_product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../products/"+edit_product_type,
            data:{'branch_id':branch,'product_id':edit_product_id},
            success: function (html) {
                $('#edit_product_id').append(html);

            }
        });
    });
    var branch = $('#products_branch_id').val();
    var edit_product_id = $('#edit_product_id').attr('rel');
    var edit_product_type = $('#edit_product_type').val();
    $('#edit_product_id').empty();
    var newOption = $('<option value="">Select Product</option>');
    $('#edit_product_id').append(newOption);
    $.ajax({
        type: "get",
        url: "../products/"+edit_product_type,
        data:{'branch_id':branch,'product_id':edit_product_id},
        success: function (html) {
            $('#edit_product_id').append(html);

        }
    });


    $('#to_stock_info_id').live("change", function () {
        var to_stock_info_id = $('#to_stock_info_id').val();
        var from_stock_info_id = $('#stock_info_id').val();
        if(to_stock_info_id == from_stock_info_id){
            alert('Opps!! You choose same stock' );
            var url      = window.location.pathname;
            window.location.href = url;
        }
        if(!from_stock_info_id){
            alert('Opps!!You have choose from Stock' );
            var url      = window.location.pathname;
            window.location.href = url;
        }


    });
});