<?php
/**
 * Template Name: Plugin
 */

/*
 * Template name: My files
 */

get_header('dashboard');
$config = require TEMPLATEPATH . '/inc/config.php';
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);


?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">

    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->
        <div class="profile-title">
            <h2><?php wp_title("", true); ?></h2>
        </div>
        <!-- END THEME PANEL -->
        <!-- BEGIN PAGE BAR -->
        <div class="breadcrumbs page-bar" typeof="BreadcrumbList" vocab="https://schema.org/">
            <ul class="page-breadcrumb">
                <?php if (function_exists('bcn_display')) {
                    bcn_display();
                } ?>
            </ul>
        </div>
        <h4> Developer ID: <?=get_current_user_id()?> </h4>
        <h4> Developer Access Token: <?=get_user_meta(get_current_user_id(),"token_id",true)?> </h4>
        <?
        global $wpdb;
        $resPlugins = $wpdb->get_results('SELECT * FROM vreo_plugins');
        function getSize($inputSize)
        {
            $size = $inputSize;

            if ($size < 1024) {
                $size .= " b";
            } elseif ($size < (1024 * 1024)) {
                $size = round(($size / 1024), 1) . " kb";
            } else {
                $size = round((($size / 1024) / 1024), 1) . " mb";
            }
            return $size;
        }

        if (!empty($resPlugins)) {
            ?>
            <div class="table-scrollable" style="margin-top: 30px !important;">
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">
                            <span data-sort="platform" class="sortFiles">Platform </span>
                        </th>
                        <th>
                            <span data-sort="name" class="sortFiles">Name</span>
                        </th>
                        <th class="text-center">
                            <span data-sort="version" class="sortFiles">Version</span>
                        </th>
                        <th class="text-center">
                            <span data-sort="size" class="sortFiles">Size</span>
                        </th>
                        <th class="text-center">
                            <span>Download</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="sortable">
                    <? foreach ($resPlugins as $plugin) {
                        $platform = $plugin->platform;
                        $name = $plugin->name;
                        $version = $plugin->version;
                        $url = $config['s3']['cdnPath'] . "/" . $plugin->url;
                        $size = $plugin->size;
                        ?>
                        <tr>
                            <td class="text-center" data-sort="platform"
                                data-value="<?= $platform ?>"><?= $platform ?></td>
                            <td data-sort="name" data-value="<?= $name ?>"><?= $name ?></td>
                            <td class="text-center" data-sort="version"
                                data-value="<?= $version ?>"><?= $version ?></td>
                            <td class="text-center" data-sort="size"
                                data-value="<?= $size ?>"><?= getSize($size) ?></td>
                            <td class="text-center"><a href="<?= $url ?>"><button type="button" class="btn btn-success"><i class="icon-arrow-down"></i>&nbsp;Download</button></a></td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
            </div>
        <? } ?>
    </div>
    <!-- END CONTENT BODY -->
    <!-- END CONTENT -->
    <script src="<?= get_template_directory_uri() ?>/js/sortable-plugins.js"></script>
    <script>
        $(document).ready(function () {
            $('time.timeago').timeago();
        });
    </script>
<?php
get_footer('dashboard');

