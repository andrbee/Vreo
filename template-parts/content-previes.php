<?php
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);

$meta = new stdClass;
$tags=(array)get_the_tags();
if(!empty($tags)){
	foreach($tags as $tag) {
		$masiv[] = $tag->slug;
	}
}


$args = array(
	'post_status' => 'publish ',
	'tag' => $masiv
);
$posts3 = get_posts( $args );

foreach( get_post_meta( $post->ID ) as $k => $v )
	$meta->$k = $v[0];
?>
<script>
	$('body').on('click','.preview',function () {

		var campaignDescription = CKEDITOR.instances['editor7'].getData();
		var editor1 = CKEDITOR.instances['editor1'].getData();
		var campaignDescAddition = $("input[name='campaign-desc-addition']").val();
		var editor2 = CKEDITOR.instances['editor2'].getData();
		var campaignYtTitle = $("input[name='campaign-yt-title']").val();
		var campaignUrlTitle = $("input[name='campaign-yt-url']").val();
		var Urlgetvalue = campaignUrlTitle.split("v=")[1];
		var playerPrevie = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+Urlgetvalue+'" frameborder="0" allowfullscreen></iframe>';
		$('#youtubeUrlPreview').html(playerPrevie);


		var imgHeader = $('#imgHeaderBg').attr('src');
		var imgAge = $('#imgAgeBg').attr('src');
		var imgImage = $('#imgImageBg').attr('src');
		var imgBackground = $('#imgBg').attr('src');
		var profilePhoto = $('#profilePhoto').attr('src');
		var sliderTitle = $("input[name='slider-title']").val();
		var campaignCost= $("#cost-campaign").val();
		var campaignPicNuber = $("input[name='pic-number-campaign']").val();
		var campaignVideoNumber = $("input[name='video-number-campaign']").val();
		var campaignBudgetNumber = $("input[name='budget-number-campaign']").val();
		var slider=$(".sliderPreview");
		var imgSlides=$("#dropbox img");
		imgSlides.each(function (indx,element) {
			var slide=$('<div></div>').append(element);
			slider.append(slide);
		})
		$('.sliderPreview').slick({
			autoplay: true,
			autoplaySpeed: 2000
		});
		
		$('#titlePreview').text(campaignDescription);
		$('#editor1Preview').html(editor1);
		$('#descAdditionPreview').text(campaignDescAddition);
		$('#editor2Preview').html(editor2);
		$('#sliderTitlePreview').text(sliderTitle);
		$('#campaignCost').text(campaignCost);
		$('#campaignPicNuberPreview').text(campaignPicNuber);
		$('#campaignVideoNumberPreview').text(campaignVideoNumber);
		$('#campaignBudgetNumberPreview').text(campaignBudgetNumber);
		$('#youtubeTitlePreview').text(campaignYtTitle);
		$('#youtubeTitlePreview').text(campaignYtTitle);
		var testHeader = $('#imgHeaderNew>img').attr('src');
		var testAge = $('#imgAgeNew>img').attr('src');
		var testImage = $('#imgImageNew>img').attr('src');
		var testBg = $('#imgBgNew>img').attr('src');

		test = $('.hashtag-text').serializeArray();

		for (var i = 0; i < test.length; i++) {
			$(".hashTagPreview").before(
				'<button  style="margin-right: 2px" class="btn btn-circle hasgBtnPreview">'+test[i].value+'</button>'
			);
		}
		$('#profilePhotoPreview').attr('src', profilePhoto);
		if (testHeader == undefined){
			imgHeader = $('#imgHeaderBg').attr('src');
			$('#imgHeaderBgPreview').attr('src', imgHeader);

		} else {
			imgHeader = $('#imgHeaderNew>img').attr('src');
			$('#imgHeaderBgPreview').attr('src', imgHeader);
		}

		if (testAge == undefined){
			imgAge = $('#imgAgeBg').attr('src');
			$('#imgAgePreview').attr('src', imgAge);

		} else {
			imgAge = $('#imgAgeNew>img').attr('src');
			$('#imgAgePreview').attr('src', imgAge);
		}

		if (testImage == undefined){
			imgImage = $('#imgImageBg').attr('src');
			$('#imgImagePreview').attr('src', imgImage);

		} else {
			imgImage = $('#imgImageNew>img').attr('src');
			$('#imgImagePreview').attr('src', imgImage);
		}
		if (testBg == undefined){
			imgBackground = $('#imgBg').attr('src');
			$('#imgBgPreview').attr({
				style: 'background-image: url('+imgBackground+');background-repeat: no-repeat;background-size:cover;padding-top: 20px;padding-bottom: 20px;margin-bottom: 20px;'
			});

		} else {
			imgBackground = $('#imgBgNew>img').attr('src');
			$('#imgBgPreview').attr({
				style: 'background-image: url('+imgBackground+');background-repeat: no-repeat;background-size:cover;padding-top: 20px;padding-bottom: 20px;margin-bottom: 20px;'
			});
		}


		$('button[type=button]').click(function () {
			$(".hasgBtnPreview").remove();
		});

	});

</script>
<!-- /.modal -->
<div class=" fade" id="full" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><i class="icon-magnifier"></i> Preview</h4>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="profile">
						<div class="age" style="position: absolute; width: 80px;height: 80px; border: 2px solid white; border-radius: 10px; right: 20px;top: 20px;"><img style="width: 100%; max-width: 76px;max-height: 76px;" src="" id="imgAgePreview"></div>
						<img id="imgHeaderBgPreview" style="max-height: 450px" src="" class="profile-img" alt="profile background users">
						<div class="profile-company">
							<? if($user_info->user_login=='developer4'){?><img src="<?=get_template_directory_uri()?>/assets/pages/img/flag/de.png" width="34" height="34" alt="Сountry flag" class="profile-company__img">
							<?}else{?><img src="<?=get_template_directory_uri()?>/assets/img/flags/<?=strtolower($user_info->country);?>.png" width="34" height="34" alt="Сountry flag" class="profile-company__img"><?}?>
							<h2 class="profile-company__name"><?=$user_info->companyname ?></h2>
							<?php
								require_once('countries.php');
								foreach ($countries as $key => $value) {
									if ($user_info->country == $key) {
										$countriProfile = $value;
										break;
									}
								}
							?>
							<p class="profile-company__address"><?=$user_info->address ?>, <?=$countriProfile; ?></p>
						</div>
						<div class="profile-user">
							<button class="btn green">Connect</button>
							<img id="profilePhotoPreview" src="" class="profile-user__img" alt="<?=$user_info->user_nicename ?>">
							<button class="btn green-haze">Bookmark</button>
						</div>
						<div class="profile-hash ">
							<span class="hashTagPreview"></span>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="content__campaign" id="imgBgPreview">
						<div class="row">
							<div class="col-md-6">
<!--								<h2 id='titlePreview'></h2>-->
								<p id='editor1Preview'></p>
							</div>
							<div class="col-md-6">
								<h2 id="youtubeTitlePreview"></h2>
								<div style="position:relative;height:0;padding-bottom:56.25%">
									<div id="youtubeUrlPreview"></div>
								</div>
								<img style="width:100%;margin-top: 20px;max-height: 650px" src="" id="imgImagePreview" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="row">


					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="dashboard-stat blue-soft">
								<div class="visual">
									<img
										src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/vreo_icon_text_light.png"
										alt="">
								</div>
								<div class="dasborard-campaign">
									<div class="number"><span id="campaignCost"></span></div>
									<!--  <? /* $post->cost_campaign */?> &#8364;</div> -->
									<div class="desc"> Cost per view</div>
								</div>
								<div class="dasborard-campaign">
									<div class="number"><span id="campaignPicNuberPreview"></span>x</div>
									<div class="desc"> Picture advertising</div>
								</div>
								<div class="dasborard-campaign">
									<div class="number"><span id="campaignVideoNumberPreview"></span>x</div>
									<div class="desc"> Video advertising </div>
								</div>
								<div class="dasborard-campaign">
									<div class="number">
										<?
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
										<!--                  <button class="btn btn-circle red-flamingo"> #hitech </button>-->
										<!--                  <button class="btn btn-circle red-flamingo"> #beer </button>-->
										<!--                  <button class="btn btn-circle red-flamingo"> #clothing </button>-->
									</div>
									<div class="desc"> are matching partners for <?=$post->post_title;?></div>
								</div>
								<div class="dasborard-campaign">
									<div class="number"><span id="campaignBudgetNumberPreview"></span> &#8364;</div>
									<div class="desc"> Budget possible </div>
								</div>
								<a class="more text-right" href="javascript:;"> Whats that?
									<i class="icon-question m-icon-white" style="margin-left: 5px;"></i>
								</a>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading" style="background-color: #f1d00f;">
									<h3><i class="fa fa-check"></i> <span id="descAdditionPreview"></span></h3>
								</div>
								<div class="panel-body" style="background-image: url(<?=get_template_directory_uri()?>/assets/img/mar_bg.jpg);background-repeat: no-repeat; background-size: cover;
									color: #fff;"> <p id='editor2Preview'></p>  </div>
							</div>
						</div>
						<div class="col-md-6">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h2 id='sliderTitlePreview'></h2>
									</div>
									<div class="panel-body">
										<div class="sliderPreview">

										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->