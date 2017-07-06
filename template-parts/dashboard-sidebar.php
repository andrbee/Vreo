<?php
global $wpdb;
$activitic_status = $wpdb->get_results( "SELECT `id_user`,`status` FROM activities WHERE id_user = $cur_user_id");
$col = 0;
foreach ($activitic_status as $key) {
    if($key->status == false) {
        $arr[$col] = $key->status;
        $col++;
    }
}
$outCol = count($arr);
?>
<div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <!-- <div class="menu-toggler sidebar-toggler">
                            <img src="/img/icons-sidebar/burgermenu.svg" alt="" >
                            <span></span>
                        </div> -->
                        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <li class="heading">
                                <h3 class="uppercase">Dashboard</h3>
                            </li>
                            <li class="nav-item start">
                                <a href="<?=get_site_url()?>/category/marketplace/" class="nav-link ">
                                    <!--<i class="fa fa-shopping-cart font-green"></i>-->
                                    <span class="dashboard-icons-marketplace"></span>
                                    <span class="title">Marketplace</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                           <li class="nav-item start">
                                    <a href="/category/brands/" class="nav-link ">
                                        <!--<i class="fa fa-shopping-cart font-green"></i>-->
                                        <span class="dashboard-icons-brands"></span>
                                        <span class="title">Brands</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            <li class="nav-item start ">
                                <a href="/activities/" class="nav-link ">
                                    <span class="dashboard-icons-activites"></span>
                                    <span class="title">Notifications</span>
                                    <?php if($outCol == true): ?>
                                    <span class="badge badge-danger"><?=$outCol;?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item start ">
                                <a href="/messenger/" class="nav-link ">
                                    <span class="dashboard-icons-messenger"></span>
                                    <span class="title">Messenger</span>
                                    <? if(fep_get_new_message_number()>0){?><span class="badge badge-danger"><?=fep_get_new_message_number();?></span><?}?>
                                </a>
                            </li>
                            <li class="nav-item start ">
                                <a href="/analytics/" class="nav-link ">
                                    <span class="dashboard-icons-analytics"></span>
                                    <span class="title">Analytics</span>
                                </a>
                            </li>
                            <?php if ($user_info->roles[0] == 'developer'): ?>
                                <li class="heading">
                                    <h3 class="uppercase">Campaigns</h3>
                                </li>
                                <li class="nav-item start">
                                    <a href="/new-campaign/" class="nav-link ">
                                        <span class="dashboard-icons-new-campaign"></span>
                                        <span class="title">New Campaign</span>
                                    </a>
                                </li>
                                <li class="nav-item start ">
                                    <a href="/edit-campaign/" class="nav-link ">
                                        <span class="dashboard-icons-my-campaigns"></span>
                                        <span class="title">My Campaigns</span>
                                    </a>
                                </li>
                              <?php endif; ?>
                            <li class="heading">
                                <h3 class="uppercase">My account</h3>
                            </li>
                            <?php if ($user_info->roles[0] == 'brand'): ?>
                                <li class="nav-item start ">
                                    <a href="/list-advertisement/" class="nav-link ">
                                        <span class="dashboard-icons-my-campaigns"></span>
                                        <span class="title">My advertisement</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item start">
                                <a href="/profile/" class="nav-link ">
                                    <span class="dashboard-icons-my-profile"></span>
                                    <span class="title">My profile</span>
                                </a>
                            </li>
                            <li class="nav-item start">
                                <a href="/edit-profile/" class="nav-link ">
                                    <span class="dashboard-icons-edit-profile"></span>
                                    <span class="title">Edit my profile</span>
                                </a>
                            </li>
                            <li class="nav-item start ">
                                <a href="/my-files/" class="nav-link ">
                                    <span class="dashboard-icons-my-files"></span>
                                    <span class="title">My files</span>
                                </a>
                            </li>
                            <li class="nav-item start ">
                                <a href="http://docs.vreo.io/" class="nav-link " target="_blank">
                                    <span class="dashboard-icons-help"></span>
                                    <span class="title">Help</span>
                                </a>
                            </li>
                            <?php
                            if ($user_info->roles[0] == 'developer'):
                                ?>
                                <li class="nav-item start">
                                    <a href="/plugin/" class="nav-link ">
                                        <span class="dashboard-icons-plugins"></span>
                                        <span class="title">Plugin & IDs</span>
                                    </a>
                                </li>

                            <?php endif; ?>
                            <li class="nav-item start ">
                            <a href="<?=wp_logout_url(); ?>"  class="btn btn-side mrktpls_log_out">
                                <i class="icon-login font-white"></i>
                                <span class="title">Log Out </span>
                            </a>
                            </li>
                        </ul>

                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
