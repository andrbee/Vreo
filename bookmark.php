<?php
/*
 * Template name: Bookmark
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
global $wpdb;
$bookMarkList_db = $wpdb->get_results( "SELECT * FROM bookmark WHERE id_users = $cur_user_id ORDER BY data DESC ");
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
			<div class="col-lg-12">
				<div class="portlet light portlet-fit ">
					<div class="portlet-body">
						<div class="mt-element-list">
							<div class="mt-list-container list-default">
								<?
									if (!empty($bookMarkList_db)):
								?>
								<ul>
									<?php foreach ($bookMarkList_db as $key): ?>
									<li class="mt-list-item">
										<div class="list-icon-container">
											<a href="javascript:;" onclick="bookMarkSigned(<?=$key->id_users;?>,<?=$key->id_post;?>,'bookmarkCardSigned')">
												<i class="icon-close"></i>
											</a>
										</div>
										<div class="list-datetime"><time class="timeago" datetime="<?=$key->data;?>"></div>
										<div class="list-item-content">
											<h3 class="uppercase bold">
												<?=$key->message;?>
											</h3>
										</div>
									</li>
									<?php endforeach; ?>
								</ul>
								<?php
									else:
										echo "<h3>You have no bookmarks!</h3>";
									endif;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- END CONTENT -->

	<script>
		$(document).ready(function() {
			$('time.timeago').timeago();
		});
	</script>
	<script>
		function bookMarkSigned(idCart, idUser, typeBtn) {
			var idProfile = idCart;
			var devIdProfile = idUser;
			var btnType = typeBtn;
			Data = new Date();
			var Year = Data.getFullYear();
			var Month = Data.getMonth() + 1;
			var Day = Data.getDate();
			var Hour = Data.getHours();
			var Minutes = Data.getMinutes();
			var Seconds = Data.getSeconds();
			var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
			$.ajax({
				type: 'post',
				url: "<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php",
				data: 'id_user='+idProfile+'&dev_user='+devIdProfile+'&profileBtn='+btnType+'&timeOut='+out,
				success: function (data) {
					window.location.reload();
				},
			});
		}
	</script>
<?php
get_footer('dashboard');
