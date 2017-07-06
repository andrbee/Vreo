<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package metronic
 */

?>

<!-- END : LOGIN PAGE 5-2 -->
<!--[if lt IE 9]>
<script src="<?=get_template_directory_uri()?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=get_template_directory_uri()?>/assets/global/plugins/excanvas.min.js"></script>
<script src="<?=get_template_directory_uri()?>/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/js.cookie.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery.blockui.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery-validation/js/additional-methods.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/select2/js/select2.full.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/backstretch/jquery.backstretch.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery-validation/js/additional-methods.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= get_template_directory_uri() ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>

<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- <script src="/assets/pages/scripts/login-5.min.js" type="text/javascript"></script> -->
<script
    src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"
    type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/components-bootstrap-select.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/form-validation-md.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/form-wizard.js" type="text/javascript"></script>
<!--<script src="--><? //=get_template_directory_uri()?><!--/assets/pages/scripts/ui-buttons.min.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= get_template_directory_uri() ?>/assets/layouts/layout/scripts/layout.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/layouts/layout/scripts/demo.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/layouts/global/scripts/quick-sidebar.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/layouts/global/scripts/quick-nav.min.js"
        type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script type="text/javascript">
    var Login = function () {

        var handleLogin = function () {

            $('.login-form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    remember: {
                        required: false
                    }
                },

                messages: {
                    username: {
                        required: "Username is required."
                    },
                    password: {
                        required: "Password is required."
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit
                    $('.alert-danger', $('.login-form')).show();
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },

                errorPlacement: function (error, element) {
                    error.insertAfter(element.closest('.input-icon'));
                },

                submitHandler: function (form) {
                    form.submit(); // form validation success, call ajax form submit
                }
            });

            $('.login-form input').keypress(function (e) {
                if (e.which == 13) {
                    if ($('.login-form').validate().form()) {
                        $('.login-form').submit(); //form validation success, call ajax form submit
                    }
                    return false;
                }
            });

            $('.forget-form input').keypress(function (e) {
                if (e.which == 13) {
                    if ($('.forget-form').validate().form()) {
                        $('.forget-form').submit();
                    }
                    return false;
                }
            });

            $('#forget-password').click(function () {
                $('.login-form').hide();
                $('.forget-form').show();
            });

            $('#back-btn').click(function () {
                $('.login-form').show();
                $('.forget-form').hide();
            });
            $('#back-btn-expReg').click(function () {
                $('.login-start').show();
                $('.express-registration').hide();
            });

            $('#expReg').click(function () {
                $('.login-start').hide();
                $('.express-registration').show();
            });
            $('#norReg').click(function () {
                $('.login-start').hide();
                $('.normal-registration').show();
            });
            $('.socicon-btn').attr('disabled', true);
        }
        return {
            //main function to initiate the module
            init: function () {

                handleLogin();

                // init background slide images
                $('.login-bg').backstretch([
                        <?php
                        if (!empty(get_option('uploader_custom'))) {
                            foreach (get_option('uploader_custom') as $image) {
                                if (!empty(wp_get_attachment_url($image))) {
                                    echo "\"" . wp_get_attachment_url($image) . "\",";
                                }
                            }
                        }?>
                    ], {
                        fade: 1000,
                        duration: 8000
                    }
                );

                $('.forget-form').hide();
                $('.express-registration').hide();
                $('.normal-registration').hide();

            }

        };

    }();

    jQuery(document).ready(function () {
        Login.init();
    });
</script>

<?php wp_footer(); ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter44585116 = new Ya.Metrika({
                    id: 44585116,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks"); </script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/44585116" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript> <!-- /Yandex.Metrika counter -->
</body>
</html>
