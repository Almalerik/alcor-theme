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

	<?php include(locate_template('template-parts/header-full-width.php'));?>

	<div class="alcor-container <?php echo $alcor -> get_setting('container_class');?>"> <!-- alcor-container -->

	
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'alcor' ); ?></a>

		<div id="header-top" class="row">
				<div class="col-xs-12"></div>
		</div>

		<div id="header" class="row">

				<nav class="navbar navbar-default <?php echo $alcor -> get_setting("header_fixed_top") ? 'navbar-fixed-top' : '';?>  navbar-fade">
					<div class="container-fluid">
	        			<div class="navbar-header">
					
							<?php if ( has_nav_menu( "primary" ) ) :?>
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<?php endif;?>
	            			
	            			<div class="brand-container">
	            				<a href="<?php echo esc_url( home_url( '/' ) )?>" class="navbar-brand"  rel="home">
	            					<img src="<?php echo $alcor->get_logo()?>" alt="<?php echo get_bloginfo('title')?>" class="site-logo image-responsive">
								</a>
								<div class="navbar-brand-name">
								<?php if ( is_front_page() && is_home() ) : ?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php else : ?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php endif;?>

								<?php $description = get_bloginfo( 'description', 'display' );
									  if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo $description; ?></p>
								<?php endif;?>
									
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<?php if ( has_nav_menu( "primary" ) ) :?>
						<div id="navbar" class="navbar-collapse collapse">
				            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'walker' => new Alcor_Walker(), 'menu_class' => 'nav navbar-nav navbar-right alcor-menu'  ) ); ?>
						</div>
						<?php endif; ?>
        			</div>
      			</nav>
		</div>

	
	<?php dynamic_sidebar ('sidebar-header-widget');?>
	
	<div id="page" class="site row">
	
		<?php if ( is_customize_preview() ): ?>
		<div id="site-header-image" class="<?php echo $alcor -> get_setting("header_image_show") && ( ( is_home() && $alcor -> get_setting("header_image_show_only_homepage" ) ) || !$alcor -> get_setting("header_image_show_only_homepage" ) )  ? '' : 'hidden';?>">
			<div class="alcor-site-branding parallax" style="background-image: url('<?php header_image(); ?>');">
			</div>
		</div>
		<?php elseif ($alcor -> get_setting("header_image_show") && ( ( is_home() && $alcor -> get_setting("header_image_show_only_homepage" ) ) || !$alcor -> get_setting("header_image_show_only_homepage" ) ) ):?>
		<div id="site-header-image">
			<div class="alcor-site-branding parallax" style="background-image: url('<?php header_image(); ?>');">
			</div>
		</div>
		<?php endif;?>

		<div id="content" class="site-content">
		