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
    $("#party_id").attr('readonly','readonly');
    $("#product_status").attr('readonly','readonly');
    $("#ref_no").attr('readonly','readonly');
    $("#discount_percentage").attr('readonly','readonly');







    function stockFormValidation() {

        var branch = $.trim($('#branch_id').val());
        var stock = $.trim($('#stock_info_id').val());
        var type = $.trim($('#product_type').val());
        var entry_type = $.trim($('#entry_type').val());
        var product = $.trim($('#product_id').val());
        var quantity = $.trim($('#product_quantity').val());
        //var price = $.trim($('#price').val());
        alert(branch+"_"+stock+"_"+type+"_"+entry_type+"_"+product+"_"+quantity);
        if ((entry_type === '') || (product === '') || (quantity === '') || (branch==='') || (stock === '') || (type === '')) {
            return false;
        } else {
            return true;
        }
    }


    $(".saveSalesReturn").live("click", function () {

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
                url: "../../saveSalesReturn",
                data :  $('#stock_form').serialize(),
                dataType:'json',
                success:function(stock)
                {

                    //$("#branch_id").select2('val', '');
                    //$("#stock_info_id").select2('val', '');
                    //$("#product_type").select2('val', '');
                    //$("#entry_type").select2('val', '');

                    $("#product_type").select2('val', '');
                    $("#product_id").select2('val', '');
                    $("#quantity").val('');
                    $("#remarks").val('');
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
        } else {
            alert('You forgot to fill something out');
        }
    });






    //
    //
    //
    //$('.productIdInEditStockInvoice').live("change", function () {
    //    var product_id = $('#product_id').val();
    //    var stock_info_id = $('#stock_info_id').val();
    //
    //    $.ajax({
    //        type: "get",
    //        url: "../quantity/"+product_id,
    //        data:{'stock_info_id':stock_info_id, 'product_id': product_id},
    //        success: function (html) {
    //            $('.available').html(html);
    //        }
    //    });
    //});


    $("#salePayment").on("shown.bs.modal", function() {
        $('.date-picker').datepicker();
    });

    $("#salePayment2").on("shown.bs.modal", function() {
        $('.date-picker').datepicker();
    });

    //$('#product_id').live("change", function () {
    //    var product_id = $('#product_id').val();
    //    $.ajax({
    //        type: "get",
    //        url: "productprice/"+product_id,
    //        success: function (html) {
    //            $('#price').val(html);
    //
    //        }
    //    });
    //});
    //$('#edit_product_id').live("change", function () {
    //    var product_id = $('#edit_product_id').val();
    //    $.ajax({
    //        type: "get",
    //        url: "../productprice/"+product_id,
    //        success: function (html) {
    //            $('#price').val(html);
    //
    //        }
    //    });
    //});


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

                    alert(data);
                    parent.remove();
                    if(data != '') {
                        window.location = "/salesreturn/index";
                    }
                }
            });
        }
    });

});