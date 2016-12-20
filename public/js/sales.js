jQuery(document).ready(function() {
  /*  $('#salestable').DataTable({
        "bPaginate": false
    });*/
    $(".saveSales").live("click", function () {
        if(saleFormValidation()){
            $.ajax({
                type: "POST",
                url: "/saveSale",
                data :  $('#sale_form').serialize(),
                dataType:'json',
                success:function(sale)
                {
                    $("#stock_info_id").select2('val', '');
                    $("#product_type").select2('val', '');
                    $("#product_id").select2('val', '');
                    $("#price").val('');
                    $("#quantity").val('');
                    $("#remarks").val('');
                    $(".msg").hide();

                    var html = [];

                    html.push('<td>' + sale.product_type + '</td>');
                    html.push('<td>' + sale.product_id + '</td>');
                    html.push('<td>' + sale.stock_info_id + '</td>');
                    html.push('<td>' + sale.price + '</td>');
                    html.push('<td>' + sale.quantity + '</td>');
                    if( sale.remarks == ''){
                        html.push('<td>' + "Not Available" + '</td>');
                    }else{
                        html.push('<td>' + sale.remarks + '</td>');
                    }
                    html.push('<td><input type="button"   style="width:70px;" value="delete" class="btn red deleteSaleDetail" rel=' + sale.id + ' ></td>');

                    html = '<tr>' + html.join('') + '<tr>';
                    $('#saleTable  > tbody:first').append(html);
                }
            });
        } else {
            alert('You forgot to fill something out');
        }
    });
    $(".editSale").live("click", function () {
        if(saleFormValidationEdit()){
            var saleId = $(this).attr('rel');
            $.ajax({
                type: "POST",
                url: "/updatePurchases/"+saleId,
                data :  $('#sale_form').serialize(),
                dataType:'json',
                success:function(sale)
                {
                    $("#stock_info_id").select2('val', '');
                    $("#edit_product_type").select2('val', '');
                    $("#edit_product_id").select2('val', '');
                    $("#price").val('');
                    $("#quantity").val('');
                    $("#remarks").val('');
                    $(".msg").hide();

                    var html = [];

                    html.push('<td>' + sale.product_type + '</td>');
                    html.push('<td>' + sale.product_id + '</td>');
                    html.push('<td>' + sale.stock_info_id + '</td>');

                    html.push('<td>' + sale.price + '</td>');
                    html.push('<td>' + sale.quantity + '</td>');
                    if( sale.remarks == ''){
                        html.push('<td>' + "Not Available" + '</td>');
                    }else{
                        html.push('<td>' + sale.remarks + '</td>');
                    }
                    html.push('<td><input type="button"  style="width:70px;" value="delete" class="btn red deleteSaleDetail" rel=' + sale.id + ' ></td>');

                    html = '<tr>' + html.join('') + '<tr>';
                    $('#saleTable  > tbody:first').append(html);
                }
            });
        } else {
            alert('You forgot to fill something out');
        }
    });
    function saleFormValidationEdit() {

        var branch = $.trim($('#edit_branch_id').val());
        var stock = $.trim($('#stock_info_id').val());
        var type = $.trim($('#edit_product_type').val());
        var party = $.trim($('#edit_party_id').val());
        var product = $.trim($('#edit_product_id').val());
        var quantity = $.trim($('#quantity').val());
        var price = $.trim($('#price').val());

        if ((party === '') || (product === '') || (quantity === '' || price==='') || (branch==='') || (stock === '') || (type === '')) {
            return false;
        } else {
            return true;
        }
    }
    function saleFormValidation() {

        var branch = $.trim($('#branch_id').val());
        var stock = $.trim($('#stock_info_id').val());
        var type = $.trim($('#product_type').val());
        var party = $.trim($('#party_id').val());
        var product = $.trim($('#product_id').val());
        var quantity = $.trim($('#quantity').val());
        var price = $.trim($('#price').val());

        if ((party === '') || (product === '') || (quantity === '' || price==='') || (branch==='') || (stock === '') || (type === '')) {
            return false;
        } else {
            return true;
        }
    }
   $('select').select2();
    $('.deleteSale').live("click", function() {

        var saleDetailId = $(this).attr('rel');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Sales Detail?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "/deleteDetail/"+saleDetailId,
                dateType: 'json',
                success: function (data) {
                    parent.remove();
                }
            });
        }
    });
    $('.deleteSaleDetail').live("click", function() {

        var saleDetailId = $(this).attr('rel');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Sales Detail?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "/deleteDetail/"+saleDetailId,
                dateType: 'json',
                success: function (data) {
                    parent.remove();
                }
            });
        }
    });
    $('#party_id').live("change", function () {
        $("#party_id").attr('readonly','readonly');
    });


    $("#edit_party_id").attr('readonly','readonly');



    $('.deleteSaleTransaction').live("click", function() {

        var transactionId = $(this).attr('rel');
        var account_id = $(this).attr('data-ref');
        var parent = $(this).closest('tr');
        var answer     = confirm("Are you sure you want to delete this Sale Transaction?");
        if(answer) {
            $.ajax({
                type: "Get",
                url: "/deleteTransaction/"+transactionId,
                dateType: 'json',
                data:{'data':account_id},
                success: function (data) {
                    parent.remove();
                }
            });
        }
    });


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

    $('#product_type').live("change", function () {
        var product_type = $('#product_type').val();
        var branch = $('#branch_id').val();
        $('#product_id').empty();
        var newOption = $('<option value="">Select Product</option>');
        $('#product_id').append(newOption);
        $.ajax({
            type: "get",
            url: "product/"+product_type,
            data:{'data':branch},
            success: function (html) {
                $('#product_id').append(html);


            }
        });
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
        $('#stock_info_id').empty();
        var newOption = $('<option value="">Select Stock</option>');
        $('#stock_info_id').append(newOption);
        $.ajax({
            type: "get",
            url: "stocks/"+product_id,
            success: function (html) {
                var data = JSON.parse(html);
                $('#stock_info_id').append(data.list);
                $('#price').val(data.price);
            }
        });
    });
    $('#edit_product_id').live("change", function () {
        var product_id = $('#edit_product_id').val();
        $('#stock_info_id').empty();
        var newOption = $('<option value="">Select Stock</option>');
        $('#stock_info_id').append(newOption);
        $.ajax({
            type: "get",
            url: "../stocks/"+product_id,
            success: function (html) {
                var data = JSON.parse(html);
                $('#stock_info_id').append(data.list);
                $('#price').val(data.price);
            }
        });
        //var stock_info_id = $('#stock_info_id').val();
        //$.ajax({
        //    type: "get",
        //    url: "../productbalance/"+product_id,
        //    data:{'data':stock_info_id},
        //    success: function (html) {
        //        $('.balance_show').html(html);
        //
        //    }
        //});
    });

    $("#salePayment").on("shown.bs.modal", function() {
        $('.date-picker').datepicker();
    });

    $("#salePayment2").on("shown.bs.modal", function() {
        $('.date-picker').datepicker();
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
    //$('#confirmRemarks').live("click", function () {
    //
    //
    //});


});