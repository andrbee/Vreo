<?php
/*
* Redirect in Admin panel and Admin Dashboard
*/

add_filter("login_redirect", "sp_login_redirect", 10, 3);

function sp_login_redirect($redirect_to, $request, $user){
if(is_array($user->roles))
if(in_array('administrator', $user->roles)) {
return home_url('/wp-admin/');
} else {
  foreach ($user->roles as $key) {
    switch ($key) {
      case 'developer':
          return home_url('/edit-campaign/');
        break;
      case 'brand':
            return home_url('/category/marketplace/');
          break;
    }
  }
}
return $request;
}

/*
* Exit session redirect home page
*/
add_action( "wp_logout", "sp_logout_redirect", 5 );

function sp_logout_redirect(){
wp_safe_redirect( site_url() );
exit;
}



/*
* User profile new fields
*/

function custom_user_profile_fields($user) {
global $neu_utility;
$month = esc_attr(get_the_author_meta('user_month', $user->ID));
$date = esc_attr(get_the_author_meta('user_date', $user->ID));
$year = esc_attr(get_the_author_meta('user_year', $user->ID));
$cell = esc_attr(get_the_author_meta('user_cell', $user->ID));
$gender= esc_attr(get_the_author_meta('user_gender', $user->ID));
$companyname = esc_attr(get_the_author_meta('companyname', $user->ID));
$address = esc_attr(get_the_author_meta('address', $user->ID));
$country = esc_attr(get_the_author_meta('country', $user->ID));
$phone = esc_attr(get_the_author_meta('phone', $user->ID));
$zipcode = esc_attr(get_the_author_meta('zipcode', $user->ID));
$paymentSurname = esc_attr(get_the_author_meta('paymentSurname', $user->ID));
$paymentCompanyname = esc_attr(get_the_author_meta('paymentCompanyname', $user->ID));
$paymentAddress = esc_attr(get_the_author_meta('paymentAddress', $user->ID));
$paymentCountry= esc_attr(get_the_author_meta('paymentCountry', $user->ID));
$payment= esc_attr(get_the_author_meta('payment', $user->ID));

?>
<h3><?php _e('Personal informations', 'your_domain'); ?></h3>
<table class="form-table">
    <tr>
        <th>
            <label for="companyname"><?php _e('Company name', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="companyname" id="companyname" value="<?=$companyname ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="address"><?php _e('Address', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="address" id="address" value="<?=$address ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="country"><?php _e('Country', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="country" id="country" value="<?=$country ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="phone"><?php _e('Telephone', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="phone" id="phone" value="<?=$phone ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="zipcode"><?php _e('Zipcode', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="zipcode" id="zipcode" value="<?=$zipcode ?>" class="regular-text">
            <br />
        </td>
    </tr>

</table>
<h3><?php _e('Payment informations', 'your_domain'); ?></h3>
<table class="form-table">
    <tr>
        <th>
            <label for="paymentSurname"><?php _e('Surname', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="paymentSurname" id="paymentSurname" value="<?=$paymentSurname ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="paymentCompanyname"><?php _e('Company name', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="paymentCompanyname" id="paymentCompanyname" value="<?=$paymentCompanyname ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="paymentAddress"><?php _e('Address', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="paymentAddress" id="paymentAddress" value="<?=$paymentAddress ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr>
        <th>
            <label for="paymentCountry"><?php _e('Country', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="text" name="paymentCountry" id="paymentCountry" value="<?=$paymentCountry ?>" class="regular-text">
            <br />
        </td>
    </tr>
    <tr style="clear: both;">
        <th>
            <label for="user_gender"><?php _e('Choose payment method', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="radio" name="payment" value="Visa" <?=($payment=='Visa') ? 'checked="checked"':''?> >Visa
            <input type="radio" name="payment" style="margin-left: 10px;" value="Amex" <?=($payment=='Amex') ? 'checked="checked"':''?> >Amex
            <input type="radio" name="payment" style="margin-left: 10px;" value="Amazon" <?=($payment=='Amazon') ? 'checked="checked"':''?> >Amazon
            <input type="radio" name="payment" style="margin-left: 10px;" value="PayPal" <?=($payment=='PayPal') ? 'checked="checked"':''?> >PayPal
            <input type="radio" name="payment" style="margin-left: 10px;" value="Stripe" <?=($payment=='Stripe') ? 'checked="checked"':''?> >Stripe
            <br />
        </td>

    </tr>


</table>
<h3><?php _e('Additional fields', 'your_domain'); ?></h3>
<table class="form-table">
    <tr>
        <th style="vertical-align: middle;">
            <label for="user_month"><?php _e('Date of birth', 'your_domain'); ?>
            </label></th>
        <td style="width: 110px; text-align: center; float: left;">
            <label> <b>Month</b><br>
                <select name="user_month" id="user_month" >
                    <option value="January" <?=($month=='January') ? 'selected="selected"':''?> >January</option>
                    <option value="February" <?=($month=='February') ? 'selected="selected"':''?> >February</option>
                    <option value="March" <?=($month=='March') ? 'selected="selected"':''?> >March</option>
                    <option value="April" <?=($month=='April') ? 'selected="selected"':''?> >April</option>
                    <option value="May" <?=($month=='May') ? 'selected="selected"':''?> >May</option>
                    <option value="June" <?=($month=='June') ? 'selected="selected"':''?> >June</option>
                    <option value="July" <?=($month=='July') ? 'selected="selected"':''?> >July</option>
                    <option value="August" <?=($month=='August') ? 'selected="selected"':''?> >August</option>
                    <option value="September" <?=($month=='September') ? 'selected="selected"':''?> >September</option>
                    <option value="October" <?=($month=='October') ? 'selected="selected"':''?> >October</option>
                    <option value="November" <?=($month=='November') ? 'selected="selected"':''?> >November</option>
                    <option value="December" <?=($month=='December') ? 'selected="selected"':''?> >December</option>
                </select>
            </label>
        </td>
        <td style="text-align: center; float: left;">
            <label> <b>Date</b><br>
                <input type="text" name="user_date" id="user_date" value="<?=$date ?>" class="regular-date">
            </label>
        </td>
        <td style="text-align: center; float: left;">
            <label> <b>Year</b><br>
                <input type="text" name="user_year" id="user_year" value="<?=$year ?>" class="regular-year">
            </label>
        </td>
    </tr>
    <tr style="clear: both;">
        <th>
            <label for="user_gender"><?php _e('Gender', 'your_domain'); ?>
            </label></th>
        <td>
            <input type="radio" name="user_gender" value="Male" <?=($gender=='Male') ? 'checked="checked"':''?> >Male
            <input type="radio" name="user_gender" style="margin-left: 10px;" value="Female" <?=($gender=='Female') ? 'checked="checked"':''?> >Female
            <input type="radio" name="user_gender" style="margin-left: 10px;" value="Non-binary" <?=($gender=='Non-binary') ? 'checked="checked"':''?> >Non-binary
            <br />
        </td>
    </tr>
</table>
<style>
    #user_month {
        vertical-align: top;
    }
    .regular-date, .regular-year {
        width: 80px;
    }
</style>
<?php }
function save_custom_user_profile_fields($user_id) {
    if(!empty($_POST['visible_brand'])) {
        $visible = $_POST['visible_brand'];
    } else {
        $visible = "visible";
    }
    if (!current_user_can('edit_user', $user_id))
        return FALSE;
    update_user_meta( $user_id, 'visible_brands', $visible );
    update_usermeta($user_id, 'user_month', $_POST['user_month']);
    update_usermeta($user_id, 'user_date', $_POST['user_date']);
    update_usermeta($user_id, 'user_year', $_POST['user_year']);
    update_usermeta($user_id, 'user_gender', $_POST['user_gender']);
    update_usermeta($user_id, 'user_cell', $_POST['user_cell']);
    update_usermeta($user_id, 'companyname', $_POST['companyname']);
    update_usermeta($user_id, 'address', $_POST['address']);
    update_usermeta($user_id, 'country', $_POST['user_country']);
    update_usermeta($user_id, 'phone', $_POST['phone']);
    update_usermeta($user_id, 'zipcode', $_POST['zipcode']);
    update_usermeta($user_id, 'paymentSurname', $_POST['paymentSurname']);
    update_usermeta($user_id, 'paymentCompanyname', $_POST['paymentCompanyname']);
    update_usermeta($user_id, 'paymentAddress', $_POST['paymentAddress']);
    update_usermeta($user_id, 'paymentCountry', $_POST['paymentCountry']);
    update_usermeta($user_id, 'payment', $_POST['payment']);
}
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

/*
 *  Register field new
 */
add_action('register_form','show_fields');
add_action('register_post','check_fields',10,3);
add_action('user_register', 'register_fields');
function show_fields() {
    $month = $_POST['user_month'];
    ?>
    <label> <b>Password</b><br>
        <input type="password" name="pwd2" placeholder="Новый пароль" />
        <input type="password" name="user_pass" id="user_pass" size="16" value="" autocomplete="off">

    </label>
    <select name="user_month" id="user_month" >
        <option value="January" <?=($month=='January') ? 'selected="selected"':''?> >January</option>
        <option value="February" <?=($month=='February') ? 'selected="selected"':''?> >February</option>
        <option value="March" <?=($month=='March') ? 'selected="selected"':''?> >March</option>
        <option value="April" <?=($month=='April') ? 'selected="selected"':''?> >April</option>
        <option value="May" <?=($month=='May') ? 'selected="selected"':''?> >May</option>
        <option value="June" <?=($month=='June') ? 'selected="selected"':''?> >June</option>
        <option value="July" <?=($month=='July') ? 'selected="selected"':''?> >July</option>
        <option value="August" <?=($month=='August') ? 'selected="selected"':''?> >August</option>
        <option value="September" <?=($month=='September') ? 'selected="selected"':''?> >September</option>
        <option value="October" <?=($month=='October') ? 'selected="selected"':''?> >October</option>
        <option value="November" <?=($month=='November') ? 'selected="selected"':''?> >November</option>
        <option value="December" <?=($month=='December') ? 'selected="selected"':''?> >December</option>
    </select>
    <label> <b>Date</b><br>
        <input type="text" name="user_date" id="user_date" value="" class="regular-date">
    </label>
    <label> <b>Year</b><br>
        <input type="text" name="user_year" id="user_year" value="" class="regular-year">
    </label>
    <input type="radio" name="user_gender" value="Male">Male
    <input type="radio" name="user_gender" style="margin-left: 10px;" value="Female">Female
    <input type="radio" name="user_gender" style="margin-left: 10px;" value="Non-binary">Non-binary
    <br>
    <input type="file" name="file">
    <input type="submit" name="upload">

<?php }
function check_fields ( $login, $email, $errors ) {
    global $user_city, $user_month;


}

$pw = $_POST['pwd2'];
$log=$_POST['user_login'];
function register_fields($user_id,$meta=array()){
    if(empty($_POST['pwd2'])){
        $pas = wp_generate_password(20, false);
    } else {
        $pas = $_POST['pwd2'];
    }
    if(!empty($_POST['visible_brand'])) {
        $visible = $_POST['visible_brand'];
    } else {
        $visible = "visible";
    }
    $authkey = hash('sha1',$_POST['user_email']);
    $hashed = time() . ':' . wp_hash_password( $pas );
    wp_set_password($pas, $user_id);
    wp_update_user(array( 'ID' => $user_id, 'first_name' => $_POST['first_name']));
    wp_update_user(array( 'ID' => $user_id, 'last_name' => $_POST['last_name']));
    wp_update_user(array('ID' => $user_id, 'role' => $_POST['wp_rar_user_role']));
    wp_update_user(array('ID' => $user_id, 'user_activation_key' => $hashed));
    update_user_meta( $user_id, 'token_id', $authkey );
    update_user_meta( $user_id, 'user_month', $_POST['user_month'] );
    update_user_meta( $user_id, 'visible_brands', $visible );
    update_user_meta($user_id, 'user_date', $_POST['user_date']);
    update_user_meta($user_id, 'user_year', $_POST['user_year']);
    update_user_meta($user_id, 'user_gender', $_POST['user_gender']);
    update_user_meta($user_id, 'companyname', $_POST['companyname']);
    update_user_meta($user_id, 'address', $_POST['address']);
    update_user_meta($user_id, 'country', $_POST['user_country']);
    update_user_meta($user_id, 'phone', $_POST['phone']);
    update_user_meta($user_id, 'zipcode', $_POST['zipcode']);
    update_user_meta($user_id, 'paymentSurname', $_POST['paymentSurname']);
    update_user_meta($user_id, 'paymentCompanyname', $_POST['paymentCompanyname']);
    update_user_meta($user_id, 'paymentAddress', $_POST['paymentAddress']);
    update_user_meta($user_id, 'paymentCountry', $_POST['paymentCountry']);
    update_user_meta($user_id, 'payment', $_POST['payment']);
    update_user_meta($user_id, 'categories_brands', $_POST['categoriesBrands']);
    $url_profile_header_pic = get_template_directory_uri()."/assets/no-image.jpg";
    update_user_meta($user_id, 'profileHeaderPic', $url_profile_header_pic);
    $url_profile_pic = get_template_directory_uri()."/assets/avatar-4.png";
    update_user_meta($user_id, 'profilePic', $url_profile_pic);

    $admin_email = get_option('admin_email');
    $toUser = $_POST['user_email'];
    $titleMailUser = 'Registration Vreo.io';
    $titleMailAdmin = 'Registration new user Vreo.io';
    $messageUser = '
<style type="text/css">

/* Custom Font */
@font-face{
font-family:"ProximaNW01-AltThinReg";
src:url("http://www.stampready.net/css/Fonts/9de06c9b-e01e-48d4-b864-599e6bf15774.eot?#iefix");
src:url("http://www.stampready.net/css/Fonts/9de06c9b-e01e-48d4-b864-599e6bf15774.eot?#iefix") format("eot"),url("http://www.stampready.net/css/Fonts/2c1b14e1-f9f3-46d2-97d5-69d45cffb5d7.woff") format("woff"),url("http://www.stampready.net/css/Fonts/ee527a2c-7f40-43c1-98fa-095263631aea.ttf") format("truetype"),url("http://www.stampready.net/css/Fonts/51834262-4210-4d01-942f-6ad0dead091f.svg#51834262-4210-4d01-942f-6ad0dead091f") format("svg");
}
@font-face{
font-family:"ProximaNW01-AltLightReg";
src:url("http://www.stampready.net/css/Fonts/dae3ab6e-9824-4d09-be4d-0dd63919caf1.eot?#iefix");
src:url("http://www.stampready.net/css/Fonts/dae3ab6e-9824-4d09-be4d-0dd63919caf1.eot?#iefix") format("eot"),url("http://www.stampready.net/css/Fonts/57e50225-0ba6-4485-99eb-da20ed870c76.woff") format("woff"),url("http://www.stampready.net/css/Fonts/2ed17183-9ebd-4294-a07e-7bd7b1ce07af.ttf") format("truetype"),url("http://www.stampready.net/css/Fonts/b45f178e-8b38-492a-a31e-d8172c0b29e2.svg#b45f178e-8b38-492a-a31e-d8172c0b29e2") format("svg");
}
@font-face{
font-family:"Proxima N W01 At Reg";
src:url("http://www.stampready.net/css/Fonts/96676c88-bae1-468a-acf5-fa74fdb2b736.eot?#iefix");
src:url("http://www.stampready.net/css/Fonts/96676c88-bae1-468a-acf5-fa74fdb2b736.eot?#iefix") format("eot"),url("http://www.stampready.net/css/Fonts/dba0fe51-98c1-4045-b289-c0e6afb10f73.woff") format("woff"),url("http://www.stampready.net/css/Fonts/14c284c3-7a50-4ef0-becf-c01232631f59.ttf") format("truetype"),url("http://www.stampready.net/css/Fonts/c7536b52-8fbc-472d-8d8a-335dae2980df.svg#c7536b52-8fbc-472d-8d8a-335dae2980df") format("svg");
}
@font-face{
font-family:"Proxima N W01 At Smbd";
src:url("http://www.stampready.net/css/Fonts/a9f16204-0ff0-4a9e-8a02-59d15bc5f66b.eot?#iefix");
src:url("http://www.stampready.net/css/Fonts/a9f16204-0ff0-4a9e-8a02-59d15bc5f66b.eot?#iefix") format("eot"),url("http://www.stampready.net/css/Fonts/6e328769-56a5-4de1-957e-575f839df36d.woff") format("woff"),url("http://www.stampready.net/css/Fonts/b5b3aa5a-a6be-4897-a646-09224334b90b.ttf") format("truetype"),url("http://www.stampready.net/css/Fonts/bcade2c9-7691-43e7-9c1b-e6b2ac50ee97.svg#bcade2c9-7691-43e7-9c1b-e6b2ac50ee97") format("svg");
}
			
/* Reset */
* { margin-top: 0px; margin-bottom: 0px; padding: 0px; border: none; line-height: normal; outline: none; list-style: none; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
table { border-collapse: collapse !important; padding: 0px !important; border: none !important; border-bottom-width: 0px !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
table td { border-collapse: collapse; }
body { margin: 0px; padding: 0px; background-color: #FFFFFF;}
.ExternalClass * { line-height: 100%; }

.animateButton { -webkit-animation-name: animateColor; -webkit-animation-duration:8s; -webkit-animation-iteration-count:infinite; -webkit-animation-direction:linear; -moz-animation-name: animateColor; -moz-animation-duration:8s; -moz-animation-iteration-count:infinite; -moz-animation-direction:linear; }

@-webkit-keyframes animateColor{

0%{ background-color: #54c993; }
17% { background-color: #83c954; }
34% { background-color: #c5c954; }
51% { background-color: #c95454; }
68% { background-color: #c554c9; }
85% { background-color: #5496c9; }
100% { background-color: #54c993; }

}

/* Responsive */
@media only screen and (max-width:620px) {

	/* Tables
	parameters: width, alignment, padding */

	table[class=alignCenter] { width: 100%!important; }
	table[class=textAlignCenter] { width: 100%!important; text-align: center!important; }
	table[class=textAlignRight] { width: 100%!important; text-align: right!important; }
	table[class=textAlignCenterResetHeight] { width: 100%!important; text-align: center!important; height: 20px!important;}

	/* Td */	
	td[class=resetHeight] { padding-bottom: 30px;}
	td[class=increasePadding] { padding-top: 30px; padding-bottom: 30px;}
	td[class=increasePadding-Both] { padding-top: 30px!important; padding-bottom: 30px!important; padding-left: 20px!important; padding-right: 20px!important; }
	td[class=increasePadding-BothReset] { text-align: center; padding-top: 30px!important; padding-bottom: 30px!important; padding-left: 20px!important; padding-right: 20px!important; }
	td[class=increasePaddingBottom] { padding-bottom: 30px;}
	td[class=increasePaddingBottom-Both] { padding-bottom: 30px!important; padding-left: 20px!important; padding-right: 20px!important; }
	td[class=paddingBoth] { padding-left: 20px!important; padding-right: 20px!important; }
	td[class=reset] { height: 0px!important; }

	img[class=reset] { display: inline!important; }
	
}

</style>
              <!-- MAIN WRAPPER -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td>
<!-- HEADER -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" data-module="header">
	<tr>
		<td valign="top" align="center" bgcolor="#f5f5f5" style="background-image: url('.get_template_directory_uri().'/assets/mailImage/header_bg.jpg); background-repeat: no-repeat; background-position: center center; background-attachment: scroll; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; color: #FFFFFF; font-size: 18px;" data-bg="Header">
			
			<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter">
				<tr>
					<td height="50" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">
					
						<a href="#"><img src="'.get_template_directory_uri().'/assets/mailImage/vreo_icon_text_light.png" alt="" width="220" height="61" style="display: block;" border="0"></a>
						
					</td>
				</tr>
				<tr>
					<td height="85" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
			</table>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter" style="background-image: url('.get_template_directory_uri().'/assets/mailImage/header_cut.png); background-repeat: repeat-x; background-position: center bottom; font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;">
				<tr>
					
				</tr>
			</table>
			
		</td>
	</tr>
</table>

<!-- INTRO -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter" style="color: #323232;" data-module="intro">
	<tr>
		<td bgcolor="#FFFFFF" style="border-bottom: 1px solid #ededed;">

			<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="alignCenter" style="font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;">
				<tr>
					<td height="70" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" class="paddingBoth" style="font-size: 30px;">

						<p style="color: #323232; padding: 0px 0px 0px 0px;" data-color="Headline Big" data-size="Headline Big" data-min="16">Welcome to vreo.io</p>

					</td>
				</tr>
				<tr>
					<td height="60" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
			</table>

		</td>
	</tr>
</table>

<!-- LAST WORDS -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter" style="font-size: 32px; color: #323232;" data-module="last words">
	<tr>
		<td bgcolor="#FFFFFF" style="border-bottom: 1px solid #ededed;">
		
			<table style="font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;" width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter">
				<tr>
					<td height="60" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" class="paddingBoth">
						
						<p href="#" style="font-size: 22px; color: #323232; padding: 15px 0px 0px 0px;" data-color="Headline Big" data-size="Headline Big" data-min="16">Your registration was successful!</p>
									<p href="#" style="font-size: 22px; color: #323232; padding: 15px 0px 0px 0px;" data-color="Headline Big" data-size="Headline Big" data-min="16">User name: '.$_POST['user_login'].'</p>
									<p href="#" style="font-size: 22px; color: #323232; padding: 15px 0px 0px 0px;" data-color="Headline Big" data-size="Headline Big" data-min="16">Password: '. $pas .'</p>
						<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 15px 0px 0px 0px;" data-color="Paragraphs" data-size="Paragraphs" data-max="24">Get started using vreo now, or check out our helpdesk for common questions and advanced support for our services.</p>
														
						<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 45px 0px 15px 0px;">
							<a href="http://beta.vreo.io" target="_blank" style="padding: 5px 15px 5px 15px; border-radius: 3px; background-color: #4ece3d; text-decoration: none; color: #FFFFFF; font-size: 16px;" data-bgcolor="Buttons" data-size="Buttons" data-color="Buttons" data-max="24">Visit vreo marketplace</a> 
						</p>
						
					</td>
				</tr>
				<tr>
					<td height="60" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
			</table>
							
		</td>
	</tr>
</table>

<!-- 3 COLUMNS -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter" style="font-size: 32px; color: #323232;" data-module="3 columns">
	<tr>
		<td bgcolor="#FFFFFF" style="border-bottom: 1px solid #ededed;">
		
			<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="alignCenter">
				<tr>
					<td height="70" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
				<tr>
					<td>

						<table width="385" border="0" cellspacing="0" cellpadding="0" align="left" class="alignCenter">
							<tr>
								<td>

									<table style="font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;" width="175" border="0" cellspacing="0" cellpadding="0" align="left" class="alignCenter">
										<tr>
											<td align="center" class="increasePaddingBottom-Both">

												<a href="http://docs.vreo.io/en/knowledgebase"><img width="150" src="'.get_template_directory_uri().'/assets/mailImage/circle_1.png" border="0" style="display: block; border-radius: 50%;"></a>

												<p style="font-size: 18px; color: #323232; padding: 30px 0px 15px 0px;" data-color="Headline Small" data-size="Headline Small" data-max="24">Knowledge Base</p>
									
												<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 0px 0px 0px 0px;" data-color="Paragraphs" data-size="Paragraphs" data-max="24">Specific problems get solutions here.</p>
												
												<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 45px 0px 0px 0px;">
													<a href="http://docs.vreo.io/en/knowledgebase" target="_blank" style="padding: 5px 15px 5px 15px; border-radius: 3px; background-color: #4ece3d; text-decoration: none; color: #FFFFFF; font-size: 16px;" data-bgcolor="Buttons" data-size="Buttons" data-color="Buttons" data-max="24">Visit</a>
												</p>

											</td>
										</tr>
									</table>
									<table style="font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;" width="175" border="0" cellspacing="0" cellpadding="0" align="right" class="alignCenter">
										<tr>
											<td align="center" class="increasePaddingBottom-Both">

												<a href="http://docs.vreo.io/en/faq"><img width="150" src="'.get_template_directory_uri().'/assets/mailImage/circle_2.png" border="0" style="display: block; border-radius: 50%;"></a>

												<p style="font-size: 18px; color: #323232; padding: 30px 0px 15px 0px;" data-color="Headline Small" data-size="Headline Small" data-max="24">F.A.Q</p>
									
												<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 0px 0px 0px 0px;" data-color="Paragraphs" data-size="Paragraphs" data-max="24">Common questions regarding our services.</p>
												
												<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 45px 0px 0px 0px;">
													<a href="http://docs.vreo.io/en/faq" target="_blank" style="padding: 5px 15px 5px 15px; border-radius: 3px; background-color: #4ece3d; text-decoration: none; color: #FFFFFF; font-size: 16px;" data-bgcolor="Buttons" data-size="Buttons" data-color="Buttons" data-max="24">Visit</a>
												</p>

											</td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

						<table style="font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;" width="175" border="0" cellspacing="0" cellpadding="0" align="right" class="alignCenter">
							<tr>
								<td align="center" class="paddingBoth">

									<a href="http://docs.vreo.io/en/contact"><img width="150" src="'.get_template_directory_uri().'/assets/mailImage/circle_3.png" border="0" style="display: block; border-radius: 50%;"></a>

									<p style="font-size: 18px; color: #323232; padding: 30px 0px 15px 0px;" data-color="Headline Small" data-size="Headline Small" data-max="24">Contact</p>
									
									<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 0px 0px 0px 0px;" data-color="Paragraphs" data-size="Paragraphs" data-max="24">Get in touch with our support.</p>
									
									<p style="font-size: 16px; color: #6b6b6b; line-height: 28px; padding: 45px 0px 0px 0px;">
										<a href="http://docs.vreo.io/en/contact" target="_blank" style="padding: 5px 15px 5px 15px; border-radius: 3px; background-color: #4ece3d; text-decoration: none; color: #FFFFFF; font-size: 16px;" data-bgcolor="Buttons" data-size="Buttons" data-color="Buttons" data-max="24">Visit</a>
									</p>

								</td>
							</tr>
						</table>
						
					</td>
				</tr>
				<tr>
					<td height="60" style="line-height: 0px; font-size: 1px;">&nbsp;</td>
				</tr>
			</table>
			
		</td>
	</tr>
</table>

<!-- FOOTER -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter" style="color: #323232;" data-module="footer">
	<tr>
		<td height="40" style="line-height: 0px; font-size: 1px;" bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF">
		
			<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="textAlignCenter">
				<tr>
					<td>
						
						<table width="300" border="0" cellspacing="0" cellpadding="0" align="left" class="textAlignCenter" style="font-size: 14px; font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;">
							<tr>
								<td data-color="Footer Paragraphs" data-size="Footer Paragraphs" data-max="24">&nbsp;vreo.io. by <a href="http://project-gateway.de/en/" target="_blank">Project: Gateway VR Studios GmbH</a></td>
							</tr>
						</table>
						
						<table width="300" border="0" cellspacing="0" cellpadding="0" align="right" class="alignCenter" style="font-size: 12px; font-family: \'ProximaNW01-AltLightReg\', Helvetica, Arial, sans-serif;">
							<tr>
								<td align="right" class="increasePadding-BothReset" data-size="Footer Links" data-color="Footer Links" data-max="24"><a href="#" style="text-decoration: none; color: #323232;">Unsubscribe</a>
									
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
			</table>
							
		</td>
	</tr>
	<tr>
		<td height="40" style="line-height: 0px; font-size: 1px;" bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
</table>
            ';
    $messageAdmin =  '
              <table style="font-family: arial ;">
                <tr style="border: 1px solid black;">
                  <td style="padding: 10px; font-weight: bold; font-size: 16px;">Name user: </td>
                  <td style="padding: 10px; font-size: 18px;">'.$_POST['user_login'].'</td>
                </tr>
                <tr style="border: 1px solid black;">
                  <td style="padding: 10px; font-weight: bold; font-size: 16px;">Password: </td>
                  <td style="padding: 10px; font-size: 18px;">'.$pas.'</td>
                </tr>
                <tr style="border: 1px solid black;">
                  <td style="padding: 10px; font-weight: bold; font-size: 16px;">Email: </td>
                  <td style="padding: 10px; font-size: 18px;">'.$_POST['user_email'].'</td>
                </tr>
                <tr style="border: 1px solid black;">
                  <td style="padding: 10px; font-weight: bold; font-size: 16px;">Role: </td>
                  <td style="padding: 10px; font-size: 18px;">'.$_POST['wp_rar_user_role'].'</td>
                </tr>
              </table>
            ';
    $headers[] = 'From: Vreo.io <vreo@vreo.io>';
    $headers[] = 'content-type: text/html; charset=utf-8';

    wp_mail( $toUser, $titleMailUser, $messageUser, $headers );
    wp_mail( $admin_email, $titleMailAdmin, $messageAdmin, $headers );

   // file download in server and write basedate
    if( wp_verify_nonce( $_POST['profilePicUpload'], 'profilePic' ) ){
        if ( ! function_exists( 'wp_handle_upload' ) )
            require_once( ABSPATH . 'wp-admin/includes/file.php' );

        $file = &$_FILES['profilePic'];
        $overrides = array( 'test_form' => false );

        $movefile = wp_handle_upload( $file, $overrides );

        if ( $movefile ) {

            update_user_meta($user_id, 'profilePic', $movefile['url']);

        } else {
            echo "Possible attack when you download the file!\n";
        }
    }
    if( wp_verify_nonce( $_POST['profileHeaderPicUpload'], 'profileHeaderPic' ) ){
        if ( ! function_exists( 'wp_handle_upload' ) )
            require_once( ABSPATH . 'wp-admin/includes/file.php' );

        $file = &$_FILES['profileHeaderPic'];
        $overrides = array( 'test_form' => false );

        $movefile = wp_handle_upload( $file, $overrides );

        if ( $movefile ) {
           update_user_meta($user_id, 'profileHeaderPic', $movefile['url']);

        } else {
            echo "Possible attack when you download the file!\n";
        }
    }
    if( wp_verify_nonce( $_POST['verificationDocUpload'], 'verificationDoc' ) ){
        if ( ! function_exists( 'wp_handle_upload' ) )
            require_once( ABSPATH . 'wp-admin/includes/file.php' );

        $file = &$_FILES['verificationDoc'];
        $overrides = array( 'test_form' => false );

        $movefile = wp_handle_upload( $file, $overrides );

        if ( $movefile ) {
            update_usermeta($user_id, 'verificationDoc', $movefile['url']);
        } else {
            echo "Possible attack when you download the file!\n";
        }
    }

    // write cookie new user
    $ID = $user_id;
    wp_set_auth_cookie( $user_id );
    global $pagenow;
    if( 'wp-login.php' == $pagenow ) {
        if ( isset( $_POST['wp-submit'] ) || ( isset($_GET['action']) && $_GET['action']=='logout') || ( isset($_GET['checkemail']) && $_GET['checkemail']=='confirm')) return;
        else wp_redirect( home_url() ); // or wp_redirect(home_url('/login'));
        if(( isset($_GET['checkemail']) && $_GET['checkemail']=='registered')) {
            if ($_POST['wp_rar_user_role'] == 'developer'){
                wp_redirect( home_url('/edit-campaign/') );
            } elseif ($_POST['wp_rar_user_role'] == "brand") {
              wp_redirect( home_url('/category/marketplace/') );
            } else {
                wp_redirect( home_url('/category/marketplace/') );
            }

        } else {
            if ($_POST['wp_rar_user_role'] == 'developer'){
                wp_redirect( home_url('/edit-campaign/') );
            } elseif ($_POST['wp_rar_user_role'] == "brand") {
                wp_redirect( home_url('/category/marketplace/') );
            } else {
                wp_redirect( home_url('/category/marketplace/') );
            }
        }
        exit();
    }


}
