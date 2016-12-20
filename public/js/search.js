jQuery(document).ready(function() {
    // Put page-specific javascript here
   // $('#stock_Product_search_result_table').DataTable();
   // $('#stock_search_result_table').DataTable();
   // $('#stock_requisition_search_result_table').DataTable();
    $('.date-picker').datepicker();

    $('select').select2();

    $('#branch_id').live("change", function () {
        var branch_id = $('#branch_id').val();
        $('#category_id').empty();
        var newOption = $('<option value="">Choose Category</option>');
        $('#category_id').append(newOption);
        $.ajax({
            type: "get",
            url: "category/"+branch_id,
            success: function (html) {
                $('#category_id').append(html);

            }
        });
    });

    $('#category_id').live("change", function () {
        $('#product_id').empty();
        var newOption = $('<option value="">Choose Products</option>');
        $('#product_id').append(newOption);
        var category_id = $('#category_id').val();
        $.ajax({
            type: "get",
            url: "products/"+category_id,
            success: function (html) {
                $('#product_id').append(html);

            }
        });
    });

});