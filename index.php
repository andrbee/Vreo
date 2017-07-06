<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package metronic
 * 
 */

get_header();

$users = get_users();
foreach ($users as $key) {
	$array_users[$key->user_login] = $key->user_email;
}
$array_users = json_encode($array_users);
?>

<body class=" login">
<script>
	var dateVar = new Date();
	var offset = -dateVar.getTimezoneOffset();
	document.cookie = "timezone="+offset;
</script>
			<!-- BEGIN : LOGIN PAGE 5-2 -->
			<div class="user-login-5">
					<div class="row bs-reset">
							<div class="col-md-12 col-xs-12 col-sm-12 col-lg-6 login-container bs-reset">
								<a href="/"><img class="login-logo login-6" src="<?=get_template_directory_uri()?>/assets/pages/img/login/logo-vreo.png" /></a>
									<div class="login-content login-start" >
											<h1>Welcome to vreo</h1>
											<p>To start using the marketplace, please sign in. Don‘t have an account yet? Please register. If you just want to get a quick impression, you can use express registration and fill in just a few details. You can update your account later on.</p>
											<?php
											if (isset($_GET['login'])) :
												switch ($_GET['login']) :
													case 'failed': {
														echo '<div class="error">The information you have entered is not correct.</div>';
														break;
													}
												endswitch;
											endif;
											?>
											<form action="<?php echo get_option('home'); ?>/wp-login.php" class="login-form" method="post">
													<div class="alert alert-danger display-hide">
															<button class="close" data-close="alert"></button>
															<span>Enter any username and password. </span>
													</div>
													<div class="row">
															<div class="col-md-5 col-xs-6 col-sm-5 col-lg-5">
																	<input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" name="log"
																	 value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" required/> </div>
															<div class="col-md-5 col-xs-6 col-sm-5 col-lg-5">
																	<input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="pwd" required/> </div>
															<div class="col-md-2 col-xs-12 col-sm-2 col-lg-2">
																<button class="btn blue" name="submit" type="submit">Sign In</button>
															</div>
													</div>
													<div class="row">
															<div class="col-md-2 col-xs-3 col-sm-3 col-lg-2">
																<button class="btn blue" name="submit" type="submit">Sign In</button>
															</div>
															<div class="col-md-4 col-xs-5 col-sm-4 col-lg-4">
																	<label class="rememberme mt-checkbox mt-checkbox-outline">
																			<input type="checkbox" name="rememberme" value="forever" /> Remember me
																			<span></span>
																	</label>
															</div>
															<div class="col-md-8 col-xs-4 col-sm-5 col-lg-8 text-right">
																	<div class="forgot-password">
																			<a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
																	</div>

															</div>
													</div>
											</form>
											<!-- BEGIN FORGOT PASSWORD FORM -->
											<form class="forget-form" action="javascript:;" method="post">
													<h3>Forgot Password ?</h3>
													<p> Enter your e-mail address below to reset your password. </p>
													<div class="form-group">
															<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
													<div class="form-actions">
															<button type="button" id="back-btn" class="btn blue btn-outline">Back</button>
															<button type="submit" class="btn blue uppercase pull-right">Submit</button>
													</div>
											</form>
											<!-- END FORGOT PASSWORD FORM -->
										<div class="row">
											<div class="col-md-8 col-xs-8 col-sm-8 col-lg-8">
												<p>New to vreo?</p>
												<button class="btn blue " name="submit" id="expReg" type="submit" >Express registration</button>
												<span class="registration-button"> or </span>
												<button class="btn blue " name="submit" id="norReg" type="submit" >Normal registration</button>
<!--											<button class="btn default disabled" name="submit" type="submit">Express registration</button>
											<span class="registration-button"> or </span>
											<button class="btn default disabled" name="submit"  type="submit">Normal registration</button>-->
											</div>
										</div>
									</div>
									
								<?php require_once('template-parts/express-registration.php'); ?>
								<?php require_once('template-parts/normal-registration.php'); ?>
									<div class="login-footer">
											<div class="row bs-reset">
													<div class="col-xs-12 col-md-5 col-sm-5 col-lg-5 bs-reset">
													
													</div>
													<div class="col-xs-12 col-md-7 col-sm-7 col-lg-7 bs-reset">
															<div class="login-copyright text-right">
																	<p>2017 &copy; vreo.io</p>
															</div>
													</div>
											</div>
									</div>
							</div>
							<div class="col-md-12 col-xs-12 col-sm-12 col-lg-6 bs-reset">
									<div class="login-bg"> </div>
							</div>
					</div>
			</div>
<script>
	$(document).ready(function() {
		var valLogin = false;
		var valEmailFirst = false;
		var valEmailRepeat = false;
		var validLoginNormal = false;
		var validEmailNormal = false;

		$('#categoriesBrandsExp').multiselect({
			enableFiltering: true,
			includeSelectAllOption: true,
			selectAllJustVisible: false
		});
		$('#categoriesBrandsNorm').multiselect({
			enableFiltering: true,
			includeSelectAllOption: true,
			selectAllJustVisible: false
		});

		$(".user-login").keyup(function () {
			var userInformation = <?=$array_users;?>;
			var userLogin = $(".user-login").val();
			if(userLogin != 0)
			{
				for (var key in userInformation) {
					if(key == userLogin )
					{
						document.getElementById('validLogin').innerHTML = "<i style=\"color: red;\" class=\"fa fa-exclamation-circle\" title=\"Sorry! This user exists!\"></i>";
						valLogin = false;
						break;
					} else {
						document.getElementById('validLogin').innerHTML = "<i style=\"color: green;\" class=\"fa fa-check-circle\"></i>";
						valLogin = true;
					}
				}
			} else {
				$("#validLogin").css({
					"background-image": "none"
				});
			}
		});
		$(".email1").keyup(function () {
			var userInformation = <?=$array_users;?>;
			var email1 = $(".email1").val();
			if(email1 != 0)
			{
				for (var key in userInformation) {
					if(userInformation[key] == email1 )
					{
						document.getElementById('validEmailFirst').innerHTML = "<i style=\"color: red;\" class=\"fa fa-exclamation-circle\" title=\"Sorry! This email exists!\"></i>";
						valEmailFirst = false;
						break;
					} else {
						document.getElementById('validEmailFirst').innerHTML = "<i style=\"color: green;\" class=\"fa fa-check-circle\"></i>";
						valEmailFirst = true;
					}
				}
			} else {
				$("#validLogin").css({
					"background-image": "none"
				});
			}
		});
		$("#userNick").keyup(function () {
			var userInformation = <?=$array_users;?>;
			var userLogin = $("#userNick").val();
			if(userLogin != 0)
			{
				for (var key in userInformation) {
					if(key == userLogin )
					{
						document.getElementById('validLoginNormal').innerHTML = "<i style=\"color: red;\" class=\"fa fa-exclamation-circle\" title=\"Sorry! This user exists!\"></i>";
						validLoginNormal = false;
						break;
					} else {
						document.getElementById('validLoginNormal').innerHTML = "<i style=\"color: green;\" class=\"fa fa-check-circle\"></i>";
						validLoginNormal = true;
					}
				}
			} else {
				$("#validLoginNormal").css({
					"background-image": "none"
				});
			}
		});
		$("#userEmail").keyup(function () {
			var userInformation = <?=$array_users;?>;
			var email1 = $("#userEmail").val();
			if(email1 != 0)
			{
				for (var key in userInformation) {
					if(userInformation[key] == email1 )
					{
						document.getElementById('validEmailNormal').innerHTML = "<i style=\"color: red;\" class=\"fa fa-exclamation-circle\" title=\"Sorry! This email exists!\"></i>";
						validEmailNormal = false;
						break;
					} else {
						document.getElementById('validEmailNormal').innerHTML = "<i style=\"color: green;\" class=\"fa fa-check-circle\"></i>";
						validEmailNormal = true;
					}
				}
			} else {
				$("#validEmailNormal").css({
					"background-image": "none"
				});
			}
		});

		$(".email2").keyup(function(){
			var email = $(".email2").val();
			var email1 = $(".email1").val();
			if(email != 0)
			{
				if(email == email1)
				{
					document.getElementById('validEmail').innerHTML = "<i style=\"color: green;\" class=\"fa fa-check-circle\"></i>"
					valEmailRepeat = true;
				} else {
					document.getElementById('validEmail').innerHTML = "<i style=\"color: red;\" class=\"fa fa-exclamation-circle\" title=\"Not re-entered the correct email\"></i>"
					valEmailRepeat = false;
				}
			} else {
				$("#validEmail").css({
					"background-image": "none"
				});
			}
		});
		$("#userEmail").keyup(function(){
			var el = $("#userEmail").val();
			document.getElementById('req_userEmail').innerHTML = el;
		});
		$('#submit_form_exp').submit(function() {
			if (valLogin == true && valEmailFirst == true && valEmailRepeat == true) {
				return true;
			} else {
				return false;
			}

		});
	});
</script>
<?php
get_footer();
