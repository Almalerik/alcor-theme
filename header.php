<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alcor
 */

$alcor = new Alcor_Theme();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>

<!-- Alcor custom style -->
<style type="text/css">
	<?php echo $alcor -> get_custom_style();?>
</style>

</head>

<body <?php body_class(); ?>>



	<div class="alcor-container <?php echo $alcor -> get_setting('container_class');?>"> <!-- alcor-container -->

	
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'alcor' ); ?></a>

		<?php include(locate_template('template-parts/header-top.php'));?>

		<div id="header" class="row">
		
			<?php include(locate_template('template-parts/header-nav.php'));?>
			
			<?php include(locate_template('template-parts/header-background.php'));?>
			
		</div>

	
	<?php dynamic_sidebar ('sidebar-header-widget');?>
	
	<div id="page" class="site row">
	

		

		<div id="content" class="site-content">
		