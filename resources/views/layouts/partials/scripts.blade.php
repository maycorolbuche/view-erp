<style>
    /* demo page styles */
    body {
        min-height: 2300px;
    }

    .affix-pane.affix {
        top: 80px;
    }

    .admin-form .panel.heading-border:before,
    .admin-form .panel .heading-border:before {
        transition: all 0.7s ease;
    }

    .custom-nav-animation li {
        display: none;
    }

    .custom-nav-animation li.animated {
        display: block;
    }
</style>

<!-- BEGIN: PAGE SCRIPTS -->

<!-- jQuery -->
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery-1.11.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

<!-- Bootstrap -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>

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

/*
        setTimeout(function() {
            adminForm.addClass('theme-primary');
            Panel.addClass('panel-primary');

            $(options).each(function(i, e) {
                if ($(e).hasClass('block')) {
                    $(e).removeClass().addClass('block mt15 option option-primary');
                } else {
                    $(e).removeClass().addClass('option option-primary');
                }
            });
            $(switches).each(function(i, ele) {

                if ($(ele).hasClass('switch-round')) {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass(
                            'block mt15 switch switch-round switch-primary');
                    } else {
                        $(ele).removeClass().addClass('switch switch-round switch-primary');
                    }
                } else {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-primary');
                    } else {
                        $(ele).removeClass().addClass('switch switch-primary');
                    }
                }
            });
            buttons.removeClass().addClass('button btn-primary');
        }, 2200);
*/


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
    });
</script>
<!-- END: PAGE SCRIPTS -->
