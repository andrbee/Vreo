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
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
?>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> 2017 &copy; vreo.io &nbsp;&nbsp;
        <a href="<?= content_url('/uploads/docs/Advertiser_AGB.PDF') ?>">Advertiser AGB</a>&nbsp;
        <a href="<?= content_url('/uploads/docs/Publisher_AGB.PDF') ?>">Publisher AGB</a>&nbsp;
        <a href="<?= content_url('/uploads/docs/FAQ_vreo.pdf') ?>">FAQ</a>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
</div>


<!--[if lt IE 9]>
<script src="<?=get_template_directory_uri()?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=get_template_directory_uri()?>/assets/global/plugins/excanvas.min.js"></script>
<script src="<?=get_template_directory_uri()?>/assets/global/plugins/ie8.fix.min.js"></script>

<![endif]-->
<!-- BEGIN CORE PLUGINS -->

<script src="<?= get_template_directory_uri() ?>/js/hashtags.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/js/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/js/jquery.filedrop.js"></script>
<script src="<?= get_template_directory_uri() ?>/js/script.js"></script>
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
<script src="<?= get_template_directory_uri() ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<? // if(strtolower(get_the_title())=="analytics"){?>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/flot/jquery.flot.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/flot/jquery.flot.resize.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/flot/jquery.flot.categories.min.js"
        type="text/javascript"></script>

<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/morris/morris.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/morris/raphael-min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/counterup/jquery.waypoints.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/counterup/jquery.counterup.min.js"
        type="text/javascript"></script>


<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"
        type="text/javascript"></script>
<script
    src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js"
    type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/amcharts/ammap/ammap.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/amcharts/amstockcharts/amstock.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/fullcalendar/fullcalendar.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/horizontal-timeline/horizontal-timeline.js"
        type="text/javascript"></script>

<!--<script src="--><? //=get_template_directory_uri()?><!--/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>-->
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jquery.sparkline.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"
        type="text/javascript"></script>
<script
    src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"
    type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/components-bootstrap-multiselect.min.js"
        type="text/javascript"></script>

<? if (strtolower(get_the_title()) == "analytics") { ?>
    <script src="<?= get_template_directory_uri() ?>/assets/global/plugins/flot/jquery.flot.pie.min.js"
            type="text/javascript"></script>
    <!--<script src="--><? //=get_template_directory_uri()?><!--/assets/global/plugins/flot/jquery.flot.stack.min.js" type="text/javascript"></script>-->
    <!--<script src="--><? //=get_template_directory_uri()?><!--/assets/global/plugins/flot/jquery.flot.crosshair.min.js" type="text/javascript"></script>-->
    <!--<script src="--><? //=get_template_directory_uri()?><!--/assets/global/plugins/flot/jquery.flot.axislabels.js" type="text/javascript"></script>-->
<? } ?>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->

<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/components-bootstrap-select.min.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/apps/scripts/inbox.min.js" type="text/javascript"></script>

<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->


<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/profile.min.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
        type="text/javascript"></script>
<script src="<?= get_template_directory_uri() ?>/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
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
<script src="<?= get_template_directory_uri() ?>/js/jquery.timeago.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/js/main.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script>
    $('.sliderPreview').slick({
        autoplay: true,
        autoplaySpeed: 2000
    });

</script>
<script>


    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#tags")
    // остановить смену фокуса, если выделен один из элементов автозаполнения
        .bind("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).data("autocomplete").menu.active) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 0,
            source: function (request, response) {
                $.ajax({
                    url: "<?=get_template_directory_uri()?>/search_hasgtags.php",
                    type: "GET",
                    dataType: "json",
                    data: {term: request.term},
                    success: function (data) {
                        response($.map(data, function (item) {
                            return item;
                        }));
                    }
                });
            },
            focus: function () {
                // отменяем вставку значения на получение фокуса
                return false;
            },
            select: function (event, ui) {
                var terms = split(this.value);
                // удаляем вводимую часть текста и помещаем вместо нее выбранный элемент
                terms.pop();
                terms.push(ui.item.value);
                // собираем все элементы в строку, разделяя их запятыми и вставляем
                // строку обратно в текстовое поле
                terms.push("");
                this.value = terms.join(",");
                return false;
            }
        });
</script>
<script src="<?= get_template_directory_uri() ?>/js/campaign-new.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd5-X61bh-u7jADplEoJNVI_qQ6sBAzAA&callback=initMap" async
        defer></script>

<!-- END THEME LAYOUT SCRIPTS -->

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
