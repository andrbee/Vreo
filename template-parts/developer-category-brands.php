<!-- === THE CARDS PROFILE BRANDS === -->
<?if(single_term_title('',false)=='Brands' and !isset($_GET['hashtag'])) {?>
	<div class="profile-title">
		<h2>Brands recently joined vreo</h2>
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
				?>

				<div class="col-md-3 mt-20">
					<div class="mt-widget-2">
						<div class="mt-head" style="display: block;position: relative;">
							<a class="img_cart_cmpgns" style="background-image: url(<?=$key->profileHeaderPic;?>);" href="/profile/?&user_id=<?=$key->ID;?>"></a>
							<div class="mt-head-user">
								<div class="mt-head-user-img">
									<a href="/profile/?&user_id=<?=$key->ID;?>" class="link_cart_cmpg_prf-pic" style="background-image: url(<?php
                                    if(!empty($key->profilePic)){
                                        echo $key->profilePic;
                                    } else {
                                        echo get_template_directory_uri()."/assets/avatar-4.png";
                                    }
                                    ?>);"></a>">
								</div>
							</div>
						</div>
						<div class="mt-body">
							<a href="/profile/?&user_id=<?=$key->ID;?>" class="cart_link_title_cmpgns"><h3 class="mt-body-title"> <?=$key->display_name;?> </h3></a>
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
			<?php }
			$user_brands = get_userdata($key->ID);
			?>
		</div>
	</div>
<?php } ?>
<!-- === END CARDS PROFILE BRANDS === -->
<!-- Slider setting -->
<script>

	$(document).ready(function(){
		$('.brands-item').slick({
			arrows: true
		});
	});

</script>
<!-- End slider setting -->