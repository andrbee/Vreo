<?php
/*
 * Template name: List Campaign
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
global $wpdb;
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


                               <div class="col-md-7">
                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                    <div class="portlet">
                                        <div class="portlet-body">
                                            <div class="table-scrollable">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <i class="fa fa-key"></i> ID
                                                        </th>
                                                        <th>
                                                            <i class="fa fa-briefcase"></i> Campaign
                                                        </th>
                                                        <th>
                                                            <i class="fa fa-lock"></i> Status
                                                        </th>
                                                        <th> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $postList = query_posts(array('author'   => $cur_user_id, 'post_status' => array( 'completed', 'draft','publish'), 'orderby' => array( 'post_status' => 'ASC' )));
                                                        foreach( array_reverse($postList) as $post ){
                                                            ?>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <span style="margin-left: 5px;"> <?=$post->ID;?> </span>
                                                        </td>
                                                        <td class="highlight">
                                                            <div class="info"> </div>
                                                            <span style="margin-left: 5px;"> <?php the_title(); ?> </span>
                                                        </td>
                                                        <td style="text-align: center;">
                                                        <?php
                                                            switch ($post->post_status) {
                                                              case 'publish':
                                                                    echo "<span class=\"font-green-jungle\"><b>".$post->post_status."ed"."</b></span>";
                                                              break;
                                                              case 'draft':
                                                                    echo "<span class=\"font-red-thunderbird\"><b>".$post->post_status."</b></span>";
                                                              break;
                                                              case 'completed':
                                                                    echo "<span class=\"font-blue-madison\"><b>Closed</b></span>";
                                                              break;
                                                            }
                                                          ?>
                                                        </td>
                                                        <td style="width: 520px;">
                                                            <?php
                                                            $result = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_dev = $cur_user_id AND id_campaign = $post->ID");
                                                            if ( $result ):
                                                            ?>
                                                                <a href="/place-step-second/?idDev=<?php echo $cur_user_id; ?>&pageId=<?php echo $post->ID; ?>" class="btn btn-outline btn-circle yellow-gold btn-sm">
                                                                    <i class="fa fa-edit"></i> Status Log </a>
                                                            <?php endif; ?>
                                                            <form action="/edit-campaign/edit"  method="POST" style="display: inline-block;">
                                                                <button class="btn btn-outline btn-circle green btn-sm purple" name="edit" value="<?=$post->ID;?>">
                                                                <i class="fa fa-edit"></i> Edit </button>
                                                            </form>
                                                            <form id="campaign-form-delete" action="<?php echo get_stylesheet_directory_uri() ?>/inc/campaign-delete.php" method="POST" style="display: inline-block;">
                                                              <input type="hidden" name="postID" value="<?=$post->ID;?>">
                                                              <?php if ($post->post_status == 'completed'): ?>

                                                              <!--<button  class="btn btn-outline btn-circle blue-madison"   name="list-button" value="uncompleted">
                                                                      <span class="glyphicon glyphicon-ok"> </span> Re-open campaign  </button>-->
                                                              <?php elseif ($post->post_status=="draft"): ?>
                                                                <button  class="btn btn-outline btn-circle blue-madison"   name="list-button" value="publish">
                                                                      <span class="glyphicon glyphicon-ok"> </span> Publish </button>
                                                                  <?php elseif ($post->post_status=="publish"): ?>
                                                                  <button  class="btn btn-outline btn-circle blue-madison"   name="list-button" value="completed">
                                                                      <span class="glyphicon glyphicon-ok"> </span> Close campaign </button>
                                                                  <?php else: ?>
                                                                <button  class="btn btn-outline btn-circle blue-madison"   name="list-button" value="completed">
                                                                      <span class="glyphicon glyphicon-ok"> </span> Completed </button>
                                                              <?php endif; ?>
                                                                <?php
                                                                    // Проверка на показ рекламы, если есть показ блокируем кнопку Delete
                                                                $resultDelete = $wpdb->get_results("SELECT developer_game_id FROM pl_get_random_advertiser WHERE developer_game_id = $post->ID LIMIT 1");
                                                                ?>
                                                                <button  data-toggle="confirmation" data-placement="right w100wewe0 bgr" data-original-title="" title="" aria-describedby="confirmation421674" class="btn btn-outline btn-circle dark btn-sm black"   name="list-button" value="delete" <?php if ($resultDelete) { echo 'disabled';} ?>>
                                                                  <i class="fa fa-trash-o"></i> Delete </button>
<!--                                                                <button class="btn btn-outline purple-sharp  uppercase" >Confirmation on right</button>-->
                                                            </form>
                                                        </td>
                                                    </tr>

                                                        <?php } ?>
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
