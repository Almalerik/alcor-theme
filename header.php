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
	<div class="container-fluid">
	
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'alcor' ); ?></a>

		<div id="header-top" class="row">
			<div class="alcor-wrapper">
				<div class="col-xs-12"></div>
			</div>
		</div>

		<div id="header" class="row">
			<div class="alcor-wrapper">
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
		</div>
	</div>
<?php dynamic_sidebar ('sidebar-header');?>
	<div id="page" class="site">
		

		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
			

		</div>
			<!-- .site-branding -->


		</header>
		<!-- #masthead -->

		<div id="content" class="site-content">
		