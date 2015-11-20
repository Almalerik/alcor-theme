<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package alcor
 */

get_header(); 
$alcor = new Alcor_Theme();?>

	<div class="row">
	
		<?php
		if ($alcor->get_setting ( 'page_layout' ) == 'left'):
				if (!is_home() || (is_home() && !$alcor->get_setting ( 'hide_homepage_sidebar' ))) :
					get_sidebar ('sidebar.php');
				endif;
		endif;
		?>


	<div id="primary" class="content-area <?php echo $alcor -> get_col_class()["content"];?>">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	


<?php
		if ($alcor->get_setting ( 'page_layout' ) == 'right'):
				if (!is_home() || (is_home() && !$alcor->get_setting ( 'hide_homepage_sidebar' ))) :
					get_sidebar ('sidebar.php');
				endif;
		endif;
?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
