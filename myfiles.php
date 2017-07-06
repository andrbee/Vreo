<?php
/*
 * Template name: My files
 */

get_header('dashboard');

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
                <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </ul>
        </div>
        <?php
            require 'vendor/autoload.php';
            $config = require 'inc/config.php';
            require_once get_template_directory() ."/template-parts/my_files.php";

        ?>

        <!-- BEGIN PROFILE IMG -->

        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <script>
        $(document).ready(function() {
            $('time.timeago').timeago();
        });
    </script>
<?php
get_footer('dashboard');
