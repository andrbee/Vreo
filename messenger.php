<?php
/*
 * Template name: Messenger
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$tags=(array)get_the_tags();
if(!empty($tags)){
    foreach($tags as $tag) {
        $masiv[] = $tag->slug;
    }
}



$args = array(
    'author' => $user_info->ID,
    'post_status' => 'publish ',
    'tag' => $masiv
);
$posts3 = get_posts( $args );
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
                        <!-- END PAGE BAR -->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <!-- BEGIN PROFILE IMG -->

                        <?php
                            echo do_shortcode('[front-end-pm]');
                        ?>
                       <!-- <div class="inbox">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="inbox-sidebar">
                                        <a href="javascript:;" data-title="Compose" class="btn red compose-btn btn-block">
                                            <i class="fa fa-edit"></i> Compose </a>
                                        <ul class="inbox-nav">
                                            <li class="active">
                                                <a href="javascript:;" data-type="inbox" data-title="Inbox"> Inbox
                                                    <span class="badge badge-success">3</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-type="important" data-title="Inbox"> Important </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-type="sent" data-title="Sent"> Sent </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-type="draft" data-title="Draft"> Draft
                                                    <span class="badge badge-danger">8</span>
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="javascript:;" class="sbold uppercase" data-title="Trash"> Trash
                                                    <span class="badge badge-info">23</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="inbox-contacts">
                                            <li class="divider margin-bottom-30"></li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img class="contact-pic" src="<?/*=get_template_directory_uri()*/?>/assets/pages/media/users/avatar4.jpg">
                                                    <span class="contact-name">Adam Stone</span>
                                                    <span class="contact-status bg-green"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img class="contact-pic" src="<?/*=get_template_directory_uri()*/?>/assets/pages/media/users/avatar2.jpg">
                                                    <span class="contact-name">Lisa Wong</span>
                                                    <span class="contact-status bg-red"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img class="contact-pic" src="<?/*=get_template_directory_uri()*/?>/assets/pages/media/users/avatar5.jpg">
                                                    <span class="contact-name">Nick Strong</span>
                                                    <span class="contact-status bg-green"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img class="contact-pic" src="<?/*=get_template_directory_uri()*/?>/assets/pages/media/users/avatar6.jpg">
                                                    <span class="contact-name">Anna Bold</span>
                                                    <span class="contact-status bg-yellow"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img class="contact-pic" src="<?/*=get_template_directory_uri()*/?>/assets/pages/media/users/avatar7.jpg">
                                                    <span class="contact-name">Richard Nilson</span>
                                                    <span class="contact-status bg-green"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="inbox-body">
                                        <div class="inbox-header">
                                            <h1 class="pull-left">Inbox</h1>
                                            <form class="form-inline pull-right" action="index.html">
                                                <div class="input-group input-medium">
                                                    <input type="text" class="form-control" placeholder="Password">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn green">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="inbox-content"> </div>
                                    </div>
                                </div>
                            </div>
                    </div>-->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <div class="page-quick-sidebar">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                                    <span class="badge badge-danger">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                                    <span class="badge badge-success">7</span>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-bell"></i> Alerts </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-info"></i> Notifications </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-speech"></i> Activities </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-settings"></i> Settings </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
                <!-- END QUICK SIDEBAR -->


<?php
get_footer('dashboard');
