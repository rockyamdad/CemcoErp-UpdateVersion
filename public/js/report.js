jQuery(document).ready(function() {
    // Put page-specific javascript here

    $('.date-picker').datepicker()

    $('select').select2();


    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(data) {
            $(data).modal();

        });
    });
    $('#branch_id').live("change", function () {
        var branch_id = $('#branch_id').val();
        $('#category_id').empty();
        var newOption = $('<option value="">Please Select Category</option>');
        $('#category_id').append(newOption);
        $.ajax({
            type: "get",
            url: "category/"+branch_id,
            success: function (html) {
                $('#category_id').append(html);

            }
        });
    });


});
