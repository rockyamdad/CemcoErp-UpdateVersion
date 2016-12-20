jQuery(document).ready(function() {
    /*  $('#salestable').DataTable({
     "bPaginate": false
     });*/

    $('#stock_table').DataTable({
        "bPaginate": false
    });
    var form = $('#stock_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);

    $('select').select2();
    $("#branch_id").attr('readonly','readonly');
    $("#stock_info_id").attr('readonly','readonly');
    $("#product_type").attr('readonly','readonly');
    $("#entry_type").attr('readonly','readonly');

    $('#branch_id').live("change", function () {
        $("#branch_id").attr('readonly','readonly');
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

    $('#stock_info_id').live("change", function () {
        $("#stock_info_id").attr('readonly','readonly');
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


    $('#product_type').live("change", function () {
        $("#product_type").attr('readonly','readonly');
        var product_type = $('#product_type').val();
        var branch = $('#branch_id').val();
        //alert(branch);
        $('#product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "products/"+product_type,
            data:{'data':branch},
            success: function (html) {

                $('#product_id').append(html);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    });


    function stockFormValidation() {

        var branch = $.trim($('#branch_id').val());
        var stock = $.trim($('#stock_info_id').val());
        var type = $.trim($('#product_type').val());
        var entry_type = $.trim($('#entry_type').val());
        var product = $.trim($('#product_id').val());
        var quantity = $.trim($('#product_quantity').val());
        //var price = $.trim($('#price').val());
        //alert(branch+"_"+stock+"_"+type+"_"+entry_type+"_"+product+"_"+quantity);
        if ((entry_type === '') || (product === '') || (quantity === '') || (branch==='') || (stock === '') || (type === '')) {
            return false;
        } else {
            return true;
        }
    }


    $(".saveStocks").live("click", function () {

        if(stockFormValidation()){
            $.ajax({
                type: "POST",
                url: "/saveStock2",
                data :  $('#stock_form').serialize(),
                dataType:'json',
                success:function(stock)
                {

                    //$("#branch_id").select2('val', '');
                    //$("#stock_info_id").select2('val', '');
                    //$("#product_type").select2('val', '');
                    //$("#entry_type").select2('val', '');

                    $("#product_id").select2('val', '');
                    $("#to_stock_info_id").select2('val', '');
                    //$("#price").val('');
                    $("#product_quantity").val('');
                    $("#remarks").val('');
                    $(".msg").hide();
                    $(".available").html('');

                    var html = [];
                    if(stock.entry_type == "StockIn") {
                        html.push('<td>' + stock.product_id + '</td>');
                        html.push('<td>' + stock.product_quantity + '</td>');
                        html.push('<td>' + stock.consignment_name + '</td>');
                        if( stock.remarks == ''){
                            html.push('<td>' + "Not Available" + '</td>');
                        }else{
                            html.push('<td>' + stock.remarks + '</td>');
                        }
                    } else if (stock.entry_type == "StockOut"){
                        html.push('<td>' + stock.product_id + '</td>');
                        html.push('<td>' + stock.product_quantity + '</td>');
                        html.push('<td>' + stock.remarks + '</td>');
                    } else if (stock.entry_type == "StockOut" || stock.entry_type ==  "Wastage"){
                        html.push('<td>' + stock.product_id + '</td>');
                        html.push('<td>' + stock.product_quantity + '</td>');
                        if( stock.remarks == ''){
                            html.push('<td>' + "Not Available" + '</td>');
                        }else{
                            html.push('<td>' + stock.remarks + '</td>');
                        }
                    } else {
                        html.push('<td>' + stock.product_id + '</td>');
                        html.push('<td>' + stock.product_quantity + '</td>');
                        html.push('<td>' + stock.to_stock_info_id + '</td>');
                        if( stock.remarks == ''){
                            html.push('<td>' + "Not Available" + '</td>');
                        }else{
                            html.push('<td>' + stock.remarks + '</td>');
                        }
                    }


                    html.push('<td><input type="button"   style="width:70px;" value="delete" class="btn red deleteStockDetail2" rel=' + stock.id + ' ></td>');

                    html = '<tr>' + html.join('') + '<tr>';
                    $('#stockTable  > tbody:first').append(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        } else {
            alert('You forgot to fill something out');
        }
    });





    $('#entry_type').live("change", function () {
        $("#entry_type").attr('readonly','readonly');
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



















    $("#edit_branch_id").attr('readonly','readonly');
    //edit
    $('#edit_branch_id').live("change", function () {
        var branch_id = $('#edit_branch_id').val();
        $('#edit_product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#edit_product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../products/"+branch_id,
            success: function (html) {
                $('#edit_product_id').append(html);

            }
        });
    });

    $('#edit_product_type').live("change", function () {
        var product_type = $('#edit_product_type').val();
        var branch = $('#edit_branch_id').val();
        $('#edit_product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#edit_product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../product/"+product_type,
            data:{'data':branch},
            success: function (html) {
                $('#edit_product_id').append(html);


            }
        });
    });


    $('#payment_method').live("change", function () {

        var payment_method = $('#payment_method').val();
        if(payment_method != 'Cash'){
            $( ".cheque_no_section" ).removeClass("hidden");
        }else{
            $( ".cheque_no_section" ).addClass("hidden");
        }
    });

    $('#product_id').live("change", function () {
        var product_id = $('#product_id').val();
        var stock_info_id = $('#stock_info_id').val();

        $.ajax({
            type: "get",
            url: "quantity/"+product_id,
            data:{'stock_info_id':stock_info_id, 'product_id': product_id},
            success: function (html) {
                //alert(html);
                $('.available').html(html);

            }
        });
    });

    $('.productIdInEditStockInvoice').live("change", function () {
        var product_id = $('#product_id').val();
        var stock_info_id = $('#stock_info_id').val();

        $.ajax({
            type: "get",
            url: "../quantity/"+product_id,
            data:{'stock_info_id':stock_info_id, 'product_id': product_id},
            success: function (html) {
                $('.available').html(html);
            }
        });
    });

    $('#edit_product_id').live("change", function () {
        var product_id = $('#edit_product_id').val();
        var stock_info_id = $('#stock_info_id').val();
        $.ajax({
            type: "get",
            url: "../productbalance/"+product_id,
            data:{'data':stock_info_id},
            success: function (html) {
                $('.balance_show').html(html);

            }
        });
    });

    $("#salePayment").on("shown.bs.modal", function() {
        $('.date-picker').datepicker();
    });

    $("#salePayment2").on("shown.bs.modal", function() {
        $('.date-picker').datepicker();
    });

    $('#product_id').live("change", function () {
        var product_id = $('#product_id').val();
        $.ajax({
            type: "get",
            url: "productprice/"+product_id,
            success: function (html) {
                $('#price').val(html);

            }
        });
    });
    $('#edit_product_id').live("change", function () {
        var product_id = $('#edit_product_id').val();
        $.ajax({
            type: "get",
            url: "../productprice/"+product_id,
            success: function (html) {
                $('#price').val(html);

            }
        });
    });


    $('.deleteStockDetail2').live("click", function() {

        var stockDetailId = $(this).attr('rel');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Stock Detail?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "../delete/"+stockDetailId,
                dateType: 'json',
                success: function (data) {
                    //alert(data);
                    parent.remove();
                    if(data != '')
                        location.reload();
                }
            });
        }
    });

});