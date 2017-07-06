<?php
/*
 * Template name: Marketplace
 */

get_header('dashboard');
$config= require "inc/config.php";

//			if ( have_posts() ) :
//
//
//
//
//			endif;

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$tags=(array)get_the_tags();
if(!empty($tags)){
	foreach($tags as $tag) {
		$masiv[] = $tag->slug;
	}
}

$catID=get_cat_ID(single_term_title('',false));
if(isset($_GET['hashtag'])){
//	$args = array('category'=>$catID,'author'=>$cur_user_id,'tag'=> $_GET['hashtag']);
//	$args = array('category'=>$catID,'tag'=> $_GET['hashtag']);
    $tagCountries = $_GET['hashtag'];
    require_once('template-parts/countries.php');
    $tagsExplode = get_tags();
    $masSearch = preg_split("/[\s,]+/", $tagCountries);

    foreach ( $tagsExplode as $item ) {
        foreach ($masSearch as $key => $value) {
            if ($value == $item->slug) {
                $masSearch[$key] = ",".$value.",";
            }

        }
    }
     $masSearch = implode(" ", $masSearch);
     $masSearch = explode(',', trim($masSearch));
     $tagCountries = preg_split("/[\s,]+/", $tagCountries);
     $tagCountries = implode("", $tagCountries);
     $masSearch = array_diff($masSearch, array(''));

    if(count($masSearch) == 2) {
        foreach ($countries as $key => $value){

            if ($value == ucfirst(trim($masSearch[1]))) {
                $countriesSearch = $key;
                $hashTagSearch = $masSearch[0];
                break;
            } else {
                $countriesSearch = $key;
                $hashTagSearch = $masSearch[1];
            }
        }

    } else {
            foreach ($countries as $key => $value){
                if ($value == ucfirst($tagCountries)){
                    $countriesSearch  = $key;
                    $hashTagSearch = "";
                    break;
                } else {
                    $countriesSearch = "";
                    $hashTagSearch = trim($tagCountries);
                }
            }
        }

    // ==================================================================================================
    if((!empty($hashTagSearch) && !empty($countriesSearch)) || (!empty($countriesSearch) && !empty($hashTagSearch))){
        $textSearch = "hashtag and countries";
        $args = array(
            'post_status' => 'publish',
            'post_type'   => 'post',
            'tag'         => $hashTagSearch,
            'meta_query' => array(
                array(
                    'key'     => 'campaign_countries',
                    'value'   => $countriesSearch,
                    'compare' => 'LIKE'
                )
            )

        );
    } elseif (!empty($countriesSearch)) {
        $textSearch = "countries";
        $args = array(
            'post_status' => 'publish',
            'post_type'   => 'post',
            'meta_query' => array(
                array(
                    'key'     => 'campaign_countries',
                    'value'   => $countriesSearch,
                    'compare' => 'LIKE'
                )
            )
        );

    } elseif (!empty($hashTagSearch)) {
        $textSearch = "hashtag";
        $args = array(
            'category'=>$catID,
            'post_status' => 'publish',
            'post_type'   => 'post',
            'tag'         => $hashTagSearch,
        );

    } else {
        $textSearch = "hashtag";
        $args = array('category'=>$catID,'tag'=> $_GET['hashtag']);

    }
    // ==================================================================================================
} else {
	$args = array(
//		'author' => $user_info->ID,
		'post_status' => 'publish ',
		'category'=>$catID,
		'numberposts'=>8
	);
}
$posts3 = get_posts( $args );?>


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
<?if(single_term_title('',false)=='Brands'){
  require_once get_template_directory() ."/template-parts/developer-page-brands.php";
}?>
<?if(single_term_title('',false)=='Marketplace' and !isset($_GET['hashtag'])){?>
		<div class="header__marketplace" style="margin-bottom: 24px;position: relative;background-repeat: no-repeat;-webkit-background-size: contain;background-size: contain;width: 100%;height: 440px;background-image: url(<?=get_template_directory_uri()."/assets/img/"?>/marketplaceheader.jpg); height: 0;
    padding-bottom: 31.25%;">
<!--			<button type="button" class="btn " style="background-color: #EA5997;color: #ffffff;border-radius:3px !important;padding-top: 9px;padding-bottom: 9px;padding-left: 30px;padding-right: 30px;position: absolute;bottom: 30px;left: 50%; transform: translateX(-50%);">View special</button>-->
		</div>
		<div class="row">

			<?php
			//print_r(get_category_by_slug( 'marketplace' ));
			$args= array(
				'child_of'     => get_category_by_slug( 'marketplace' )->term_id,
				'hide_empty'   => 0,
				'hierarchical' =>true
			);
			$categories = get_categories($args);

			$json_file=file_get_contents($_SERVER['DOCUMENT_ROOT']."/wp-content/themes/metronic/assets/json/colors_categ.json", true);
			$colors_categ=json_decode($json_file, true);
			foreach ($categories as $categ) {?>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 margin-bottom-10">
					<a href="<?=get_site_url()?>/category/<?=$categ->slug?>/" class="clearfix">
						<div class="dashboard-stat blue" title="<?=$categ->name?>" style="background-color: <?=$colors_categ[$categ->name]?>;">
							<div class="visual">
								<img style="width: 100%;" src="<?=get_template_directory_uri()."/assets/img/categ_icons/".strtolower($categ->name)?>.png" alt="">
							</div>
							<div class="details">
								<div class="number"><?=$categ->name?></div>
								<div class="desc"><?php if($categ->count<=0){echo "there are no campaigns";}elseif ($categ->count==1){echo "$categ->count campaign available";}else{echo "$categ->count campaigns available";}?></div>
							</div>
							<a class="more" style="filter: contrast(130%);background-color: <?=$colors_categ[$categ->name]?>;" href="<?=get_site_url()?>/category/<?=$categ->slug?>/"> View <?=$categ->name?> campaigns
								<span style="float: right;" data-toggle="tooltip" data-placement="top" title="<?=$categ->name." ".$categ->count." campaigns"?>">?</span>
							</a>
						</div>
					</a>
				</div>
			<?}
			?>
		</div><? }?>
	<?php
	// Getting ID category
	$developerCat = get_category(get_query_var('cat'),false);
	?>
		<?if(single_term_title('',false)=='Marketplace' and !isset($_GET['hashtag'])) {?>
		<div class="profile-title">
			<h2>New</h2>
		</div>
		<?} elseif(single_term_title('',false)=='Marketplace' and isset($_GET['hashtag'])){?>
			<div class="profile-title">
				<h4><a href="<?=$_GET['back_url']?>">back</a></h4>
				<h2>Searching results <?=$textSearch;?> "<i style='color: brown;'><?=$_GET['hashtag']?>"</i>.</h2>
			</div>
		<?}?>
		<?if(!empty($posts3)) {?>
		<div class="row"><?php

			foreach ($posts3 as $key){
				$cur_id = $key->post_author;
//				$all_user_info = get_userdata($cur_id);
				$user_info = get_userdata($cur_id);
				?>
				<div class="col-md-3 mt-20">
					<div class="mt-widget-2">
						<div class="mt-head" style="display: block;position: relative;">
							<a class="img_cart_cmpgns" style="background-image: url(<?=$config['s3']['cdnPath']."/".urlencode($key->campaign_bg_header_file)?>);" href="<?=$key->guid?>"></a>
							<div class="categ_list_campaign" style=" padding-left: 20px; padding-right: 5px; padding-bottom: 10px; padding-top: 10px; position: absolute; bottom: 0; left: 0;  background: rgba(0,0,0,0.7); width: 100%;">
								<?
								$list_categ=get_the_category($key->ID);
								foreach ($list_categ as $categ){?>
									<img data-toggle="tooltip" data-placement="top" title="<?=$categ->name?>" style="width:20px; margin: 0px 5px;" src="<?=get_template_directory_uri()."/assets/img/categ_icons/".strtolower($categ->name)?>.png" alt="">
								<?}?>
							</div>
							<div class="categ_list_platform" style="width: 114px;padding-left: 5px;padding-right: 10px;padding-bottom: 10px; position: absolute;bottom: 0;right: 0;">
								<?
								$list_platforms=get_post_meta( $key->ID, 'campaign_platform');
								
								if(!empty($list_platforms)){
									foreach ($list_platforms[0] as $platform){?>
										<img data-toggle="tooltip" data-placement="top" title="<?=ucfirst($platform) ?>" style="width:20px;" src="<?=get_template_directory_uri()."/assets/img/platforms_icon/".strtolower($platform)?>.png" alt="">
									<?}}?>
							</div>
							<div class="age_campaign" style="display: block;position: absolute;right: 0px;top: 0px;width: 50px;height: 50px;padding-top: 10px;padding-right: 10px;">
								<?if(!empty($key->campaign_age_file)){?><img style="width: 100%" src="<?=$config['s3']['cdnPath']."/".urlencode($key->campaign_age_file)?>" alt=""><?} else{echo "<h4 style='margin: 0;vertical-align: top;text-align: right;color: greenyellow'>0+</h4>";}?>
							</div>
							<div class="mt-head-user">
								<div class="mt-head-user-img">
									<a href="/profile/?&user_id=<?=$user_info->ID?>" class="link_cart_cmpg_prf-pic" style="background-image: url(<?php
                                    if(!empty($user_info->profilePic)){
                                        echo $user_info->profilePic;
                                    } else {
                                        echo get_template_directory_uri()."/assets/avatar-4.png";
                                    }
                                    ?>);"></a>">
								</div>
							</div>
						</div>
						<div class="mt-body">
							<a href="<?=$key->guid?>" class="cart_link_title_cmpgns"><h3 class="mt-body-title"> <?=$key->post_title;?> </h3></a>
							<p class="mt-body-description"> <?=$key->post_content;?> </p>
							<ul class="mt-body-stats">
								<?php
								$tags=(array)get_the_tags($key->ID);
								global $wpdb;
								if(!empty($tags)){
									foreach($tags as $tag) {
										$colors_tags_db = $wpdb->get_results( "SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='".$tag->slug."'" );
										echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
										foreach ($colors_tags_db as $clr_tg){
											echo $clr_tg->color_tag;
										}
										echo "\">$tag->name</button>";
									}
								}


								?>
							</ul>
							<div class="mt-body-actions">
								<div class="btn-group btn-group btn-group-justified">
									<a href="<?=$key->guid?>" class="btn">
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
			<?php }
			?></div>
		<?} else {?>
			<?php
			// Getting parent ID category
		  $developerCatParent = get_category(get_query_var('cat'),false);
			if ($developerCatParent->category_parent == $developerCat->term_id) {
			?>
				<div class="profile-title">
					<h2>There are no campaigns</h2>
					<div class="panel panel-primary">
						<div class="panel-heading" style="background-color: #e74c3c;">
							<h3 style="display: inline-block;"><span aria-hidden="true" class="icon-pin"></span> Marketplace recommendations</h3>
						</div>

						<div class="panel-body">


							<?php

							//					$args = array('posts_per_page' => 8,'author'=>$cur_user_id,'orderby' => 'rand');
							$term=$_GET['hashtag'];
							$tags = get_tags(array(
								'name__like'   => "#".$term
							));
							$s='';
							foreach ($tags as $tag) {
								$s.=$tag->slug.",";
							}
							$args = array('posts_per_page' => 4,'tag'=>$s);
							$posts_rec=get_posts($args);
						
							foreach ($posts_rec as $key){
								$cur_id = $key->post_author;
								$all_user_info = get_userdata($cur_id);
								?>
								<div class="col-md-3">
									<div class="mt-widget-2">
										<div class="mt-head" style="display: block;position: relative;">
											<a class="img_cart_cmpgns" style="background-image: url(<?=$config['s3']['cdnPath']."/".urlencode($key->campaign_bg_header_file)?>);" href="<?=$key->guid?>"></a>
											<div class="categ_list_campaign" style="padding-left: 20px; padding-right: 5px; padding-bottom: 10px; padding-top: 10px; position: absolute; bottom: 0; left: 0;  background: rgba(0,0,0,0.7); width: 100%;">
												<?
												$list_categ=get_the_category($key->ID);
												if(!empty($list_categ)){
													foreach ($list_categ as $categ){?>
														<img data-toggle="tooltip" data-placement="top" title="<?=$categ->name?>" style="width:20px; margin: 0px 5px;" src="<?=get_template_directory_uri()."/assets/img/categ_icons/".strtolower($categ->name)?>.png" alt="">
													<?}}?>
											</div>
											<div class="categ_list_platform" style="width: 114px;padding-left: 5px;padding-right: 10px;padding-bottom: 10px; position: absolute;bottom: 0;right: 0;">

												<?
												$list_platforms=get_post_meta( $key->ID, 'campaign_platform');
												if(!empty($list_platforms)){
													foreach ($list_platforms[0] as $platform){?>
														<img data-toggle="tooltip" data-placement="top" title="<?=ucfirst($platform) ?>" style="width:20px;" src="<?=get_template_directory_uri()."/assets/img/platforms_icon/".strtolower($platform)?>.png" alt="">
													<?}}?>
											</div>
											<div class="age_campaign" style="display: block;position: absolute;right: 0px;top: 0px;width: 50px;height: 50px;padding-top: 10px;padding-right: 10px;">
												<?if(!empty($key->campaign_age_file)){?><img style="width: 100%" src="<?=$config['s3']['cdnPath']."/".urlencode($key->campaign_age_file)?>" alt=""><?} else{echo "<h4 style='margin: 0;vertical-align: top;text-align: right;color: greenyellow'>0+</h4>";}?>
											</div>
											<div class="mt-head-user">
												<div class="mt-head-user-img">
													<a href="/profile/?&user_id=<?=$user_info->ID?>" class="link_cart_cmpg_prf-pic" style="background-image: url(<?php
                                                    if(!empty($user_info->profilePic)){
                                                        echo $user_info->profilePic;
                                                    } else {
                                                        echo get_template_directory_uri()."/assets/avatar-4.png";
                                                    }
                                                    ?>);"></a>
												</div>
											</div>
										</div>
										<div class="mt-body">
											<a href="<?=$key->guid?>" class="cart_link_title_cmpgns"><h3 class="mt-body-title"> <?=$key->post_title;?> </h3></a>
											<p class="mt-body-description"> <?=$key->post_content;?> </p>
											<ul class="mt-body-stats">
												<?php
												$tags=(array)get_the_tags($key->ID);
												global $wpdb;
												if(!empty($tags)){
													foreach($tags as $tag) {
														$colors_tags_db = $wpdb->get_results( "SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='".$tag->slug."'" );
														echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
														foreach ($colors_tags_db as $clr_tg){
															echo $clr_tg->color_tag;
														}
														echo "\">$tag->name</button>";
													}
												}


												?>
											</ul>
											<div class="mt-body-actions">
												<div class="btn-group btn-group btn-group-justified">
													<a href="<?=$key->guid?>" class="btn">
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
							<?php } ?>
						</div>
					</div>

				</div>
		<?} /*else {
				require_once get_template_directory() ."/template-parts/developer-category-brands.php";
			}*/ }
		?>


		<!-- END CONTENT BODY -->
	</div>

	<!-- END CONTENT -->

	<script> $(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
			<?php
get_footer('dashboard');