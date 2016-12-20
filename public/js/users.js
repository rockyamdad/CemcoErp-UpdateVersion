jQuery(document).ready(function() {
    $('#user_table').DataTable({
        "bPaginate": false,
        "scrollX": false,
        "scrollCollapse": true,
    });
    var form1 = $('#user_form');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            username: {
                minlength: 4,
                required: true
            },
            role: {
                required: true
            },
            branch_id: {
                required: true
            },
            sex: {
                required: true
            },
            password: {
                minlength: 6,
                required: true
            },
            email: {
                required: true,
                email: true
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
                var span = el.closest('tr').find('.user-status > span');
                span
                    .html(ucfirst(data.status))
                    .removeClass("label-success")
                    .removeClass("label-danger")
                    .addClass("label-" + labelClass[data.status]);

                el
                    .attr('href', "changeStatus/" + data.status + "/" + data.id)

            }
        });
    });

    /*     jQuery.validator.addMethod(
     "textonly",
     function(value, element)
     {
     valid = false;
     check = /[^-\.a-zA-Z\s\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02AE]/.test(value);
     if(check==false)
     valid = true;
     return this.optional(element) || valid;
     },
     jQuery.format("Please only enter letters.")
     )*/
})