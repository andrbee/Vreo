<?php if(single_term_title('',false)=='Brands'): ?>
	<!-- === BANNER === -->
	<div class="header__marketplace" style="margin-bottom: 24px;position: relative;background-repeat: no-repeat;-webkit-background-size: contain;background-size: contain;width: 100%;height: 440px;height: 0;padding-bottom: 31.25%;background-image: url(<?=get_template_directory_uri()."/assets/img/"?>/marketplaceheader.jpg);">
		<!--			<button type="button" class="btn " style="background-color: #EA5997;color: #ffffff;border-radius:3px !important;padding-top: 9px;padding-bottom: 9px;padding-left: 30px;padding-right: 30px;position: absolute;bottom: 30px;left: 50%; transform: translateX(-50%);">View special</button>-->
	</div>
	<!-- === END BANNER === -->
	<!-- === TABLE CATEGORY BRANDS === -->
	<div class="row">
	<?php
		$args= array(
			'child_of'     => get_category_by_slug( 'brands' )->term_id,
			'hide_empty'   => 0,
			'hierarchical' => true,
			'orderby' => 'ID'
		);
		$categories = get_categories($args);
		$json_file=file_get_contents($_SERVER['DOCUMENT_ROOT']."/wp-content/themes/metronic/assets/json/colors_categ_brands.json", true);
		$colors_categ=json_decode($json_file, true);
		foreach ($categories as $categ):?>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 margin-bottom-10">
				<a href="<?=get_site_url()?>/category/<?=$categ->slug?>/" class="clearfix">
					<div class="dashboard-stat blue" title="<?=$categ->name?>" style="background-color: <?=$colors_categ[$categ->name][0]['upper']?>;">
						<div class="visual">
							<img style="width: 100%;" src="<?=get_template_directory_uri()."/assets/img/categ_brands/".strtolower($categ->slug)?>.png" alt="">
						</div>
						<div class="details">
							<div class="number"><?=$categ->name?></div>
							<div class="desc"><?=$categ->count ?> available brands</div>
						</div>
						<a class="more" style="background-color: <?=$colors_categ[$categ->name][1]['lower']?>;" href="<?=get_site_url()?>/category/<?=$categ->slug?>/"> View <?=$categ->name?> brands
							<span style="float: right;" data-toggle="tooltip" data-placement="top" title="<?=$categ->name." ".$categ->count." campaigns"?>">?</span>
						</a>
					</div>
				</a>
			</div>
		<? endforeach; ?>
	</div>
	<!-- === END TABLE CATEGORY BRANDS === -->

	<!-- === THE CARDS PROFILE BRANDS === -->
	<?if(single_term_title('',false)=='Brands' and !isset($_GET['hashtag'])) {?>
		<div class="profile-title">
			<h2>Recently joined brands</h2>
		</div>
		<?php
			$argsUser = array('order' => 'DESC','orderby' => 'user_registered','role__not_in' => array('administrator','developer'), 'number' => 15);
			$masUser = get_users($argsUser);
			?>
	<?} elseif(single_term_title('',false)=='Brands' and isset($_GET['hashtag'])){?>
		<div class="profile-title">
			<h4><a href="<?=$_GET['back_url']?>">back</a></h4>
			<h2>Searching results hashtag "<i style='color: brown;'><?=$_GET['hashtag']?>"</i>.</h2>
		</div>
	<?}?>


	<?php
	 if(!empty($masUser)) {
	?>
		<div class="row">
			<div class="brands-item" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
				<?php
				foreach ($masUser as $key){
					$cur_id = $key->post_author;
					$user_info = get_userdata($cur_id);
                    if ($key->visible_brands != "invisible"):
					?>

					<div class="col-md-3 mt-20">
						<div class="mt-widget-2">
							<div class="mt-head" style="display: block;position: relative;">
								<a class="img_cart_cmpgns" style="background-image: url(<?=$key->profileHeaderPic;?>);" href="/profile/?&user_id=<?=$key->ID;?>"></a>
								<div class="mt-head-user">
									<div class="mt-head-user-img">
										<a href="/profile/?&user_id=<?=$key->ID;?>" class="link_cart_cmpg_prf-pic" style="background-image: url(<?=$key->profilePic; ?>);"></a>">
									</div>
								</div>
							</div>
							<div class="mt-body">
								<a href="/profile/?&user_id=<?=$key->ID;?>" class="cart_link_title_cmpgns"><h3 class="mt-body-title"> <?=$key->display_name;?></h3></a>
								<p class="mt-body-description"> <?=$key->about_short;?> </p>
								<div class="mt-body-actions">
									<div class="btn-group btn-group btn-group-justified">
										<a href="/profile/?&user_id=<?=$key->ID;?>" class="btn">
											<i class="fa fa-file-text-o"></i> More details </a>
										<?php
										$bookmarkCard_db = $wpdb->get_results( "SELECT * FROM bookmark WHERE id_users = $cur_user_id AND id_post = $key->ID");

										if (!empty($bookmarkCard_db)) { ?>
											<a href="javascript:;" onclick="bookMarkCard(<?=$key->ID;?>,<?=$cur_user_id?>,'signedCardMark')" class="btn profileBtnMark">
												<i class="fa fa-bookmark"></i> Signed Mark </a>
											<?php
										} else {
											?>
											<a href="javascript:;" onclick="bookMarkCard(<?=$key->ID;?>,<?=$cur_user_id?>,'bookmarkCard')" class="btn profileBtnMark" >
												<i class="fa fa-bookmark"></i> Bookmark </a>
											<?php
										}
										?>
										<script>
											function bookMarkCard(idCart, idUser, typeBtn) {
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
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; }
				$user_brands = get_userdata($key->ID);
				?>
				</div>
		</div>
	<?php } ?>
	<!-- === END CARDS PROFILE BRANDS === -->



<?php endif; ?>
<!-- Slider setting -->
<script>

	$(document).ready(function(){
		$('.brands-item').slick({
			arrows: true
		});
	});

</script>
<!-- End slider setting -->