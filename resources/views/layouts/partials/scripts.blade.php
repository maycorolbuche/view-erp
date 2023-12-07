<!-- BEGIN: PAGE SCRIPTS -->

<!-- jQuery -->
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery-1.11.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

<!-- Bootstrap -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>

<!-- Datatables -->
<script type="text/javascript" src="{{ asset('vendor/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>

<!-- Datatables Tabletools addon -->
<script type="text/javascript"
    src="{{ asset('vendor/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>

<!-- Datatables Bootstrap Modifications  -->
<script type="text/javascript" src="{{ asset('vendor/plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>

<!-- Page Plugins -->
<script type="text/javascript" src="{{ asset('assets/admin-tools/admin-forms/js/jquery.validate.min.js') }}"></script>
<!--
<script type="text/javascript" src="{{ asset('vendor/plugins/daterange/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}">
</script>
-->
<script type="text/javascript" src="{{ asset('vendor/plugins/colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/plugins/jquerymask/jquery.mask.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/plugins/magnific/jquery.magnific-popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/plugins/telinput/intlTelInput.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/plugins/chosen/chosen.jquery.min.js') }}"></script>

<!-- Confirm -->
<!-- https://craftpip.github.io/jquery-confirm/ -->
<script type="text/javascript" src="{{ asset('vendor/plugins/confirm/jquery-confirm.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/plugins/confirm/jquery-confirm.min.css') }}">

<!-- Theme Javascript -->
<script type="text/javascript" src="{{ asset('assets/js/utility/utility.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {

        "use strict";

        // Init Theme Core    
        Core.init({
            sbl: localStorage.getItem("sidemenu_class") ?? "sb-l-o"
        });
        loading(false);

        // Init custom page animation
        setTimeout(function() {
            $('.custom-nav-animation li').each(function(i, e) {
                var This = $(this);
                var timer = setTimeout(function() {
                    This.addClass('animated animated-short zoomIn');
                }, 50 * i);
            });
        }, 500);

        // Init tray navigation smooth scroll
        $('.tray-nav a').smoothScroll({
            offset: -145
        });

        // Form Switcher
        $('#form-switcher > button').on('click', function() {
            var btnData = $(this).data('form-layout');
            var btnActive = $('#form-elements-pane .admin-form.active');

            // Remove any existing animations and then fade current form out
            btnActive.removeClass('slideInUp').addClass('animated fadeOutRight animated-shorter');
            // When above exit animation ends remove leftover classes and animate the new form in
            btnActive.one(
                'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
                function() {
                    btnActive.removeClass('active fadeOutRight animated-shorter');
                    $('#' + btnData).addClass('active animated slideInUp animated-shorter')
                });
        });

        // Cache some dom elements
        var adminForm = $('.admin-form');
        var options = adminForm.find('.option');
        var switches = adminForm.find('.switch');
        var buttons = adminForm.find('.button');

        var Panel = $('#p1');

        // Form Skin Switcher
        $('#skin-switcher a').on('click', function() {
            var btnData = $(this).data('form-skin');

            $('#skin-switcher a').removeClass('item-active');
            $(this).addClass('item-active')

            adminForm.each(function(i, e) {
                var skins =
                    'theme-primary theme-info theme-success theme-warning theme-danger theme-alert theme-system theme-dark'
                var panelSkins =
                    'panel-primary panel-info panel-success panel-warning panel-danger panel-alert panel-system panel-dark'
                $(e).removeClass(skins).addClass('theme-' + btnData);
                Panel.removeClass(panelSkins).addClass('panel-' + btnData);
            });

            $(options).each(function(i, e) {
                if ($(e).hasClass('block')) {
                    $(e).removeClass().addClass('block mt15 option option-' + btnData);
                } else {
                    $(e).removeClass().addClass('option option-' + btnData);
                }
            });
            $(switches).each(function(i, ele) {
                if ($(ele).hasClass('switch-round')) {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-round switch-' +
                            btnData);
                    } else {
                        $(ele).removeClass().addClass('switch switch-round switch-' + btnData);
                    }
                } else {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-' + btnData);
                    } else {
                        $(ele).removeClass().addClass('switch switch-' + btnData);
                    }
                }

            });
            buttons.removeClass().addClass('button btn-' + btnData);
        });

        $("#toggle_sidemenu_l,.sidebar-toggle-mini a").click(function() {
            setTimeout(function() {
                let type = $("body").hasClass("sb-l-c") ?
                    "sb-l-c" :
                    $("body").hasClass("sb-l-m") ?
                    "sb-l-m" :
                    "sb-l-o";

                localStorage.setItem("sidemenu_class", type);
            }, 1000);
        });



        $(".validate").validate({

            /* @validation states + elements 
            ------------------------------------------- */

            errorClass: "has-error",
            //validClass: "has-success",
            validClass: "",
            errorElement: "em",

            /* @validation rules 
            ------------------------------------------ */

            rules: {},

            /* @validation error messages 
            ---------------------------------------------- */

            messages: {},

            /* @validation highlighting + error placement  
            ---------------------------------------------------- */

            highlight: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element.parent());
                }
            }

        });

        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo é obrigatório.",
            remote: "Por favor, corrija este campo.",
            email: "Por favor, informe um endereço de e-mail válido.",
            url: "Por favor, informe uma URL válida.",
            date: "Por favor, informe uma data válida.",
            dateISO: "Por favor, informe uma data válida (no formato ISO).",
            number: "Por favor, informe um número válido.",
            digits: "Por favor, informe somente dígitos.",
            creditcard: "Por favor, informe um número de cartão de crédito válido.",
            equalTo: "Por favor, informe o mesmo valor novamente.",
            accept: "Por favor, informe um valor com uma extensão válida.",
            maxlength: jQuery.validator.format("Por favor, informe no máximo {0} caracteres."),
            minlength: jQuery.validator.format("Por favor, informe pelo menos {0} caracteres."),
            rangelength: jQuery.validator.format(
                "Por favor, informe um valor com comprimento entre {0} e {1} caracteres."),
            range: jQuery.validator.format("Por favor, informe um valor entre {0} e {1}."),
            max: jQuery.validator.format("Por favor, informe um valor menor ou igual a {0}."),
            min: jQuery.validator.format("Por favor, informe um valor maior ou igual a {0}.")
        });


        $(".chosen-select").chosen({
            no_results_text: "Sem resultados para",
            placeholder_text_single: "Selecione uma opção",
            placeholder_text_multiple: "Selecione as opções",

            allow_single_deselect: true,
            no_results_text: 'Nenhum resultado para ',
            placeholder_text_multiple: ' ',
            placeholder_text_single: ' ',
            width: '100%'
        });


        // Init jQuery masked inputs *********************************************************************

        $(".slug").mask("AAAAAAAAAAAAAAAAAAAA");

        $(".cpf").mask("000.000.000-00", {
            reverse: false
        });
        $(".cnpj").mask("00.000.000/0000-00", {
            reverse: false
        });
        var cpfcnpj_mask = function(val) {
                return val.replace(/\D/g, "").length <= 11 ? "000.000.000-009" : "00.000.000/0000-00";
            },
            opfcnpj_opt = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(cpfcnpj_mask.apply({}, arguments), options);
                }
            };
        $(".cpf_cnpj").mask(cpfcnpj_mask, opfcnpj_opt);

        $(".rg").mask("#.##0.000-A", {
            reverse: true
        });
        $(".rg").blur(function() {
            var valor = this.value;
            if (valor != "") {
                valor = valor.replace(/[^\d]$/, "X");
                this.value = valor;
            }
        });

        $('.pis').mask('000.00000.00-0');
        $('.zip_code').mask('00000-000');


        $(".money").mask("#.##0,00", {
            reverse: true,
            placeholder: "0,00"
        });
        $(".money").blur(function() {
            var valor = this.value;
            if (valor != "") {
                if (valor.indexOf(",") < 0) {
                    valor = valor + ",00";
                }
                valor = valor.replace(/^[0|\.]+(?!\,)+/, "");
                this.value = valor;
            }
        });
        $(".money").each(function() {
            $(this).blur();
        });

        $(".phone").intlTelInput({
            // whether or not to allow the dropdown
            allowDropdown: true,
            // if there is just a dial code in the input: remove it on blur, and re-add it on focus
            autoHideDialCode: true,
            // add a placeholder in the input with an example number for the selected country
            autoPlaceholder: "polite",
            // modify the auto placeholder
            customPlaceholder: null,
            // append menu to specified element
            dropdownContainer: null,
            // don't display these countries
            excludeCountries: [],
            // format the input value during initialisation and on setNumber
            formatOnDisplay: true,
            // geoIp lookup function
            geoIpLookup: null,
            // inject a hidden input with this name, and on submit, populate it with the result of getNumber
            hiddenInput: "",
            // initial country
            initialCountry: "br",
            // localized country names e.g. { 'de': 'Deutschland' }
            localizedCountries: null,
            // don't insert international dial codes
            nationalMode: true,
            // display only these countries
            onlyCountries: [],
            // number type to use for placeholders
            placeholderNumberType: "MOBILE",
            // the countries at the top of the list. defaults to united states and united kingdom
            preferredCountries: ["br", "us"],
            // display the country dial code next to the selected flag so it's not part of the typed number
            separateDialCode: false,
            // specify the path to the libphonenumber script to enable validation/formatting
            utilsScript: "",
        });
        phone_mask_fn();

        // End jQuery masked inputs *********************************************************************



        $('.numeric').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

    });


    function phone_mask_fn() {
        var phone_mask = function(val) {
                var p = (val.substring(0, 1) == "+");
                var ddi = "";
                if (p) {
                    val = val + " ";
                    ddi = val.substring(1, val.indexOf(" ")).replace(/\D/g, "");
                    mask_ddi = ddi.replace(/[0-9]/g, "0");
                    if (mask_ddi == "") {
                        mask_ddi = "0";
                    }
                }
                var tel = val.replace(/\D/g, "");
                var mask = "";
                //console.log(val);

                if (p) {
                    if (ddi == "55") {
                        mask = tel.length === 13 ? "(00) 00000-0000" : "(00) 0000-00009";
                    } else if (ddi == "1") {
                        mask = "(000) 000-0000";
                    } else if (ddi == "351" || ddi == "244") {
                        mask = "000 000 000";
                    } else {
                        mask = "00000000000000000000";
                    }

                    mask = "+" + mask_ddi + " " + mask;

                } else {

                    if (tel.substring(0, 4) == "0800") {
                        mask = "0000 000 0000";
                    } else if (tel.substring(0, 1) != "0" && tel.length > 0) {
                        mask = "+0 00000000000000000000";
                    } else {
                        mask = "00000000000000000000";
                    }

                }
                return mask;
            },
            phone_opt = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(phone_mask.apply({}, arguments), options);
                },
            };
        $(".phone").mask(phone_mask, phone_opt);
    }

    function tel_unmask(el) {
        el.unmask();
    }

    function tel_mask(el) {
        var ddi = el.attr("data-dial-code");
        var val = el.val();
        val = val.replace(/\D/g, "");
        if (ddi == val.substring(0, ddi.length)) {
            val = ddi + " " + val.substring(ddi.length, val.length);
            val = val.replace("  ", " ");
            el.val("+" + val);
        } else if (val.substring(0, 1) != "0" && val.length > 0 && val.length <= 4) {
            el.val("+" + val);
        } else if (el.val().substring(0, 2) == "+0") {
            el.val(val);
        }

        phone_mask_fn();
    }

    function loading(show) {
        if (show == undefined) {
            show = true;
        }

        if (show) {
            $('#loading-overlay').fadeIn();
        } else {
            $('#loading-overlay').fadeOut();
        }
    }

    function check(name, action) {

        if (action == 'reverse') {
            $(`input[name^="${name}["]`).each(function() {
                $(this).prop('checked', !$(this).prop('checked'));
            });
        } else {
            $(`input[name^="${name}["]`).prop('checked', (action == 'all'));
        }
    }

    function sum_checkbox_value(name, action, formatted) {
        if (formatted == undefined) {
            formatted = false;
        }

        let select = '';
        if (action == 'checked') {
            select = ':checked';
        } else if (action == 'not-checked') {
            select = ':not(:checked)';
        }

        let sum = 0;
        $(`input[name^="${name}["]${select}`).each(function() {
            sum += parseFloat($(this).data('value') || 0);
        });

        if (formatted) {
            return sum.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        } else {
            return sum.toFixed(2);
        }
    }
</script>
<!-- END: PAGE SCRIPTS -->
