jQuery(document).ready(function() {

    // Put page-specific javascript here
    $('#branch_table').DataTable({
        "bPaginate": false
    });
    var form = $('#branch_form');
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
            location: {
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

    function ucfirst(str) {

        str += '';
        var f = str.charAt(0)
            .toUpperCase();
        return f + str.substr(1);
    }

    var labelClass = {
        'Deactivate' : 'danger',
        'Activate' : 'success'
    };
    $('body').on('click', ".changeStatus", function (e) {
        e.preventDefault();
        var el = $(this);
        $.ajax({
            url: el.attr('href'),
            dateType: 'json',
            success: function (data) {
                var span = el.closest('tr').find('.branch-status > span');
                span
                    .html(ucfirst(data.status))
                    .removeClass("label-success")
                    .removeClass("label-danger")
                    .addClass("label-" + labelClass[data.status]);

                el
                    .attr('href', "changeStatusBranch/" + data.status + "/" + data.id)

            }
        });
    });

})