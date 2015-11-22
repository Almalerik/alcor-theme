<?php
add_action ( 'init', 'alcor_slider_post_type' );
function alcor_slider_post_type() {
	register_post_type ( 'alcor_slide', array (
			'labels' => array (
					'name' => __ ( 'Theme Sliders', 'alcor' ),
					'singular_name' => __ ( 'Theme Slider', 'alcor' ) 
			),
			'rewrite' => array (
					'slug' => 'slide' 
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array (
					'title',
					'editor',
					'thumbnail',
					'revisions' 
			),
			'taxonomies' => array (
					'alcor_slider' 
			),
			'hierarchical' => true,
			'can_export' => true,
			'capability_type' => 'post' 
	) );
	
	register_taxonomy ( 'alcor_slider', 'alcor_slide', array (
			'labels' => array (
					'name' => __ ( 'Sliders', 'alcor' ),
					'singular_name' => __ ( 'Slider', 'alcor' ) 
			),
			'rewrite' => array (
					'slug' => 'slider' 
			),
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true 
	) );
}

add_action ( "admin_init", "alcor_slide_admin_init" );
function admin_init() {
	add_meta_box ( "slide_position", "Year Completed", "year_completed", "portfolio", "side", "low" );
	add_meta_box ( "credits_meta", "Design &amp; Build Credits", "credits_meta", "portfolio", "normal", "low" );
}
function year_completed() {
	global $post;
	$custom = get_post_custom($post-&gt;ID);
	$year_completed = $custom ["year_completed"] [0];
	?>
	<label></label>
	label & gt;
	Year:&lt;/label & gt;
	&lt;input name="year_completed" value="&lt;?php echo $year_completed; ?&gt;" /
}
function credits_meta() {
	global $post;
	$custom = get_post_custom($post-&gt;ID);
	$designers = $custom ["designers"] [0];
	$developers = $custom ["developers"] [0];
	$producers = $custom ["producers"] [0];
	?&gt;
	&lt;
	p & gt;&lt;
	label & gt;Designed By:&lt;/label & gt;&lt;br /&gt;
	&lt;textarea cols="50" rows="5" name="designers" & gt;&lt;?php echo $designers; ?&gt;&lt;/textarea & gt;&lt;/p & gt;
	&lt;
	p & gt;&lt;
	label & gt;Built By:&lt;/label & gt;&lt;br /&gt;
	&lt;textarea cols="50" rows="5" name="developers" & gt;&lt;?php echo $developers; ?&gt;&lt;/textarea & gt;&lt;/p & gt;
	&lt;
	p & gt;&lt;
	label & gt;Produced By:&lt;/label & gt;&lt;br /&gt;
	&lt;textarea cols="50" rows="5" name="producers" & gt;&lt;?php echo $producers; ?&gt;&lt;/textarea & gt;&lt;/p & gt;
	
}