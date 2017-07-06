<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package metronic
 */

?><!DOCTYPE html>
		<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
		<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
		<!--[if !IE]><!-->
		<html lang="<?php language_attributes(); ?>">
		    <!--<![endif]-->
		    <!-- BEGIN HEAD -->

		    <head>
		        <meta charset="<?php bloginfo( 'charset' ); ?>" />
		        <title>Vreo.io</title>
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta content="width=device-width, initial-scale=1" name="viewport" />
		        <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
		        <meta content="" name="author" />
		        <!-- BEGIN GLOBAL MANDATORY STYLES -->
		        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		        <link href="<?=get_template_directory_uri()?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		        <link href="<?=get_template_directory_uri()?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		        <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		        <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		        <!-- END GLOBAL MANDATORY STYLES -->
		        <!-- BEGIN PAGE LEVEL PLUGINS -->
					<link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
					<link href="<?=get_template_directory_uri()?>/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		        <link href="<?=get_template_directory_uri()?>/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
		        <!-- END PAGE LEVEL PLUGINS -->
		        <!-- BEGIN THEME GLOBAL STYLES -->

		        <link href="<?=get_template_directory_uri()?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
		        <link href="<?=get_template_directory_uri()?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		        <!-- END THEME GLOBAL STYLES -->
		        <!-- BEGIN PAGE LEVEL STYLES -->
		        <link href="<?=get_template_directory_uri()?>/assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
				<link href="<?=get_template_directory_uri()?>/assets/global/plugins/socicon/socicon.css" rel="stylesheet" type="text/css">
				<link href="<?=get_template_directory_uri()?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
				<link href="<?=get_template_directory_uri()?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
					<link href="<?=get_template_directory_uri()?>/assets/css/main.css" rel="stylesheet" type="text/css" />
				<!-- END THEME LAYOUT STYLES -->
		        <!-- END PAGE LEVEL STYLES -->
		        <!-- BEGIN THEME LAYOUT STYLES -->
		        <!-- END THEME LAYOUT STYLES -->
		        <link rel="shortcut icon" href="favicon.ico" /> </head>
				<script src="<?=get_template_directory_uri()?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
			
		    <!-- END HEAD -->
