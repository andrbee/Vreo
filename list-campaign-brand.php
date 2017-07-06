<?php
/*
 * Template name: List Campaign Brand
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
global $wpdb;
$result = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_brand = $cur_user_id");
?>

<!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                        <?php require_once 'inc/campaing-error.php'; ?>
                        <div class="profile-title">
                        	<h2><?php wp_title("", true); ?></h2>
                        </div>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
						<?php require_once 'template-parts/breadcrumbs.php'; ?>
                        <!-- END PAGE BAR -->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <!-- Begin button save and public -->
                        <div class="row">
                               <div class="col-md-6">
                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                    <div class="portlet">
                                        <div class="portlet-body">
                                            <div class="table-scrollable">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <i class="fa fa-briefcase"></i> Campaign
                                                        </th>
                                                        <th>
                                                            <i class="fa fa-user"></i> Developer
                                                        </th>
                                                        <th> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        foreach ($result as $item):
                                                            $post_id = get_post( $item->id_campaign );
                                                            $user_info_brand = get_userdata($item->id_dev)
                                                    ?>
                                                        <tr>

                                                            <td class="highlight">
                                                                <div class="info"> </div>
                                                                <span style="margin-left: 5px;"> <?php echo $post_id->post_title; ?> </span>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?php echo $user_info_brand->display_name; ?>
                                                            </td>
                                                            <td style="width: 320px;">
                                                                <a href="/update-third-step/?idDev=<?php echo $item->id_dev; ?>&pageId=<?php echo $item->id_campaign; ?>" class="btn btn-outline btn-circle yellow-gold btn-sm ">
                                                                    <i class="fa fa-edit"></i>Change ad</a>
                                                                <a href="/place-step-second/?idDev=<?php echo $item->id_dev; ?>&pageId=<?php echo $item->id_campaign; ?>" class="btn btn-outline btn-circle green btn-sm purple">
                                                                    <i class="fa fa-edit"></i> My advertisement </a>
                                                            </td>
                                                        </tr>
                                                     <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END SAMPLE TABLE PORTLET-->
                                </div>

                        </div>
                </div>
                <!-- END CONTENT -->


<?php
get_footer('dashboard');
