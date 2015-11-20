<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alcor
 */
if (! is_active_sidebar ( 'sidebar-1' )) {
	return;
}
$alcor = new Alcor_Theme();
?>
		<div id="secondary" class="widget-area <?php echo $alcor -> get_col_class()['sidebar'];?>" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
		<!-- #secondary -->

