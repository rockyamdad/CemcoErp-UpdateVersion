jQuery(document).ready(function() {
    // Put page-specific javascript here
   // $('select').select2();
    var form = $('#imports_form');
    var error1 = $('.alert-danger', form);
    var success1 = $('.alert-success', form);


    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            branch_id: {
                required: true
            },
            consignment_name: {
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
         error2.hide();
         }*/
    });


    var labelClass = {
        'Deactivate' : 'danger',
        'Activate' : 'success'
    };
    $('body').on('click', ".changeStatusImport", function (e) {
        e.preventDefault();
        var el = $(this);
        $.ajax({
            url: el.attr('href'),
            dateType: 'json',
            success: function (data) {
                var span = el.closest('tr').find('.import-status > span');
                span
                    .html(data.status)
                    .removeClass("label-success")
                    .removeClass("label-danger")
                    .addClass("label-" + labelClass[data.status]);

                el
                    .attr('href', "change-status/" + data.status + "/" + data.id)

            }
        });
    });





    var formImportDetails = $('#imports_details_form');
    var error2 = $('.alert-danger', formImportDetails);
    var success2 = $('.alert-success', formImportDetails);

    formImportDetails.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            product_id: {
                required: true
            },
            quantity: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success2.hide();
            error2.show();
            App.scrollTo(error2, -200);
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
         error2.hide();
         }*/
    });

//bootstrap modal
/*
    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        //var modal_id = $(this).attr('data-target');
        $.get(url, function(data) {
            $(data).modal();
        });
    });
*/

//stay selected tab
    $('#importCostTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#importCostTab a[href="' + hash + '"]').tab('show');

    //proforma invoice validation

    var formProformaInvoice = $('#imports_proforma_invoice_form');
    var error3 = $('.alert-danger', formProformaInvoice);
    var success3 = $('.alert-success', formProformaInvoice);

    formProformaInvoice.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            invoice_no: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success3.hide();
            error3.show();
            App.scrollTo(error3, -200);
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
         error2.hide();
         }*/
    });

    // Bank Cost validation

    var formBankCost = $('#imports_bank_cost_form');
    var error4 = $('.alert-danger', formBankCost);
    var success4 = $('.alert-success', formBankCost);

    formBankCost.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            lc_no: {
                required: true
            },
            bank_name: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success4.hide();
            error4.show();
            App.scrollTo(error4, -200);
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
         error2.hide();
         }*/
    });

    // CNF Cost validation

    var formCnfCost = $('#imports_cnf_cost_form');
    var error5 = $('.alert-danger', formCnfCost);
    var success5 = $('.alert-success', formCnfCost);

    formCnfCost.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            clearing_agent_name: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success5.hide();
            error5.show();
            App.scrollTo(error5, -200);
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
         error2.hide();
         }*/
    });

    // Others Cost validation

    var formOtherCost = $('#imports_other_costs_form');
    var error6 = $('.alert-danger', formOtherCost);
    var success6 = $('.alert-success', formOtherCost);

    formOtherCost.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            tt_charge: {
                required: true
            },
            dollar_to_bd_rate: {
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            success6.hide();
            error6.show();
            App.scrollTo(error6, -200);
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
         error2.hide();
         }*/
    });



    //stay selected tab
    $('#importAddTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#importAddTab a[href="' + hash + '"]').tab('show');
    $('select').select2();
    $('.date-picker').datepicker();

});

