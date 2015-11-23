<?php
// -*- coding: utf-8 -*-

// Called directly or at least not in WordPress context.
! defined ( 'ABSPATH' ) and exit ();
class Alcor_Slider {
}

add_action ( 'init', 'alcor_slider_post_type' );
function alcor_slider_post_type() {
	register_post_type ( 'alcor_slide', array (
			'labels' => array (
					'name' => __ ( 'Theme Sliders', 'alcor' ),
					'singular_name' => __ ( 'Theme Slider', 'alcor' ) 
			),
			'rewrite' => array (
					'slug' => 'slider' 
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array (
					'title' 
			),
			'hierarchical' => false,
			'can_export' => true 
	) );
}

add_action ( 'after_setup_theme', array (
		'Alcor_Slider_Meta_Box',
		'init' 
) );
class Alcor_Slider_Meta_Box {
	/**
	 * Global accessible instance (per init()).
	 * A singleton is not enforced tough.
	 *
	 * @type object
	 */
	protected static $instance = NULL;
	/**
	 * Internal identifier for the meta box.
	 * Must be unique in WordPress.
	 *
	 * @type string
	 */
	protected $handle = 'alcor_slider_meta_box';
	/**
	 * Box Title.
	 * In a real application make sure the title is translatable.
	 *
	 * You may use markup here, an icon for example.
	 *
	 * @type string
	 */
	protected $box_title = 'Slide';
	/**
	 * May be 'normal' or 'side'
	 *
	 * @type string
	 */
	protected $priority = 'normal';
	/**
	 * Where to show the meta box.
	 * Any post type or link.
	 *
	 * @type array
	 */
	protected $post_types = array (
			'alcor_slide' 
	);
	/**
	 * nonce = number used once, unique identifier for request validation.
	 *
	 * @type string
	 */
	protected $nonce_name = 'alcor_slider_meta_box_nonce';
	/**
	 * Post meta fields handled by this class.
	 * Must be unique in WordPress.
	 *
	 * Never combine multiple fields in an array! They are stored as serialized
	 * data then, and it will be almost impossible to sort a query per API.
	 *
	 * The leading underscore prevents those fields from showing up in the
	 * generic 'custom fields' box.
	 *
	 * The key is the fields name. You may extend the values to get more
	 * flexibility.
	 *
	 * In your application make the labels translatable.
	 *
	 * @type array
	 */
	protected $fields = array (
			'_alcor_slider_slide_image_id' => array (
					'label' => 'Select image',
					'type' => 'image' 
			),
			'_alcor_slider_position' => array (
					'label' => 'Position',
					'type' => 'number' 
			),
			'_alcor_slider_basic_meta_box_text' => array (
					'label' => 'Text',
					'type' => 'wp_editor' 
			),
			'_alcor_slider_basic_meta_box_checkbox' => array (
					'label' => 'This is boring',
					'type' => 'checkbox' 
			) 
	);
	/**
	 * Creates a new instance.
	 * Called on 'plugins_loaded'.
	 *
	 * @see __construct()
	 * @return void
	 */
	public static function init() {
		NULL == self::$instance and self::$instance = new self ();
		return self::$instance;
	}
	/**
	 * Called by 'init()'.
	 * Registers the action handlers.
	 *
	 * @see save()
	 * @see register_meta_box()
	 * @see front_box()
	 * @return void
	 */
	public function __construct() {
		add_action ( 'save_post', array (
				$this,
				'save' 
		) );
		add_action ( 'add_meta_boxes', array (
				$this,
				'register_meta_box' 
		) );
		$this->extra_actions ();
	}
	/**
	 * More actions.
	 * May be overridden in a child class.
	 *
	 * @return void
	 */
	protected function extra_actions() {
		add_action ( 'basic_meta_box', array (
				$this,
				'front_box' 
		), 10, 1 );
	}
	/**
	 * Handler to get the content of the meta box.
	 *
	 * Usage:
	 * do_action( 'basic_meta_box' ); or
	 * do_action( 'basic_meta_box', array ( 'post_id' => 15 ) );
	 *
	 * You could also use:
	 * alcor_slider_Basic_Meta_Box::init()->front_box();
	 *
	 * But do_action() is better: It doesn’t require a theme update after
	 * disabling them meta box script.
	 *
	 * @param array $options
	 *        	See $defaults for possible options.
	 * @return string
	 */
	public function front_box($options = array ()) {
		global $post;
		$defaults = array (
				'post_id' => isset ( $post->ID ) ? $post->ID : FALSE,
				'template' => '<div class="alcor_slider_basic_meta_box"><h2>%1$s</h2>%2$s</div>',
				'print' => TRUE 
		);
		$options = array_merge ( $defaults, $options );
		extract ( $options );
		// We are not on a single page, and no post id was set. Nothing to do.
		if (FALSE == $post_id) {
			return;
		}
		// Prepare the variables.
		$title = get_post_meta ( $post_id, '_alcor_slider_basic_meta_box_title', TRUE );
		$text = get_post_meta ( $post_id, '_alcor_slider_basic_meta_box_text', TRUE );
		$text = wpautop ( $text );
		$output = sprintf ( $template, $title, $text );
		$print and print $output;
		return $output;
	}
	/**
	 * Called on 'add_meta_boxes'.
	 *
	 * @see __construct()()
	 * @see show()
	 * @return void
	 */
	public function register_meta_box() {
		foreach ( $this->post_types as $post_type ) {
			add_meta_box ( $this->handle, $this->box_title, array (
					$this,
					'show' 
			), $post_type, $this->priority );
			$this->add_help ( $post_type );
		}
	}
	/**
	 * Set help tab content.
	 *
	 * @param string $post_type        	
	 * @return void
	 */
	protected function add_help($post_type) {
		if (get_current_screen ()->post_type == $post_type) {
			get_current_screen ()->add_help_tab ( array (
					'id' => $this->handle,
					'title' => strip_tags ( $this->box_title ),
					'content' => '<p>Detailed instructions for your meta box.</p>' 
			) );
		}
	}
	/**
	 * Print the meta box in the editor page.
	 *
	 * @return void
	 */
	public function show($post) {
		// Our secret key for validation.
		$nonce = wp_create_nonce ( __FILE__ );
		echo "<input type='hidden' name='$this->nonce_name' value='$nonce' />";
		$this->print_markup ( $post );
	}
	/**
	 * The visible meta box markup for the post editor.
	 *
	 * @param object $post        	
	 * @return void
	 */
	protected function print_markup($post) {
		$slides = get_post_meta ( $post->ID, '_alcor_slides', true );
		?>
<div id="alcor-edit-slide-wrapper" class="hide-if-no-js">
	<a href="javascript:void(0);" id="alcor-edit-slide-add-row" class="button"><?php _e('Add slide', 'alcor')?></a>
	<input type="hidden" id="alcor-remove-slide-thumbnail-msg" value="<?php esc_attr_e("Are you sure?", "alcor")?>" />
	<table class="form-table widefat">
		<tbody class="sortable">
			<?php
		// set a variable so we can append it to each row
		$default = array (
				"image_id" => "",
				"title" => "",
				"link" => "",
				"subtitle" => "" 
		);
		if (empty ( $slides ) || ! is_array ( $slides )) {
			$slides [] = $default;
		} else {
			array_unshift ( $slides, $default );
		}
		$i = 0;
		foreach ( $slides as $slide ) {
			?>
			<tr <?php echo $i== 0 ? 'id="alcor-edit-slide-template"': '';?>>
				<td class="alcor-slide-command-move">
					<i class="fa fa-arrows-v"></i>
				</td>
				<td class="alcor-slide-thumbnail">
					<p>
						<a title="<?php _e('Select image', 'alcor')?>" href="javascript:void(0);" class="alcor-set-slide-thumbnail"
							<?php echo !empty($slide['image_id']) ? 'style="display: none;"' : ''?>><?php _e('Select image', 'alcor')?></a>
						<a title="<?php _e('Remove image', 'alcor')?>" href="javascript:void(0);" class="alcor-remove-slide-thumbnail"
							<?php echo empty($slide['image_id']) ? 'style="display: none;"' : ''?>><?php _e('Remove image', 'alcor')?></a>
					</p>
					<input type="hidden" name="_alcor_slides[<?php echo $i;?>][image_id]" class="alcor_slides_image_id" value="<?php echo $slide['image_id'];?>" />
					<?php echo wp_get_attachment_image( $slide['image_id'], 'thumbnail' ); ?>
				</td>
				<td class="alcor-slide-meta">
					<i class="fa fa-trash"></i>
					<label for="_alcor_slides[<?php echo $i;?>][title]"><?php _e('Title', 'alcor')?></label>
					<input type="text" class="large-text" id="_alcor_slides[<?php echo $i;?>][title]" name="_alcor_slides[<?php echo $i;?>][title]"
						value="<?php echo esc_attr( $slide['title'] );?>" />
					<label for="_alcor_slides[<?php echo $i;?>][subtitle]"><?php _e('Subtitle', 'alcor')?></label>
					<input type="text" class="large-text" id="_alcor_slides[<?php echo $i;?>][subtitle]" name="_alcor_slides[<?php echo $i;?>][subtitle]"
						value="<?php echo esc_attr( $slide['subtitle'] );?>" />
					<label for="_alcor_slides[<?php echo $i;?>][link]"><?php _e('Link', 'alcor')?></label>
					<input type="text" class="large-text" id="_alcor_slides[<?php echo $i;?>][link]" name="_alcor_slides[<?php echo $i;?>][link]"
						value="<?php echo esc_attr( $slide['link'] );?>" />
					<div class="accordion">
						<h3>Fist button</h3>

						<div>
							<label for="_alcor_slides[<?php echo $i;?>][first_button_text]"><?php _e('First button text', 'alcor')?></label>
							<input type="text" class="large-text" id="_alcor_slides[<?php echo $i;?>][first_button_text]" name="_alcor_slides[<?php echo $i;?>][first_button_text]"
								value="<?php echo esc_attr( $slide['first_button_text'] );?>" />
							<label for="_alcor_slides[<?php echo $i;?>][first_button_url]"><?php _e('First button url', 'alcor')?></label>
							<input type="text" class="large-text" id="_alcor_slides[<?php echo $i;?>][first_button_url]" name="_alcor_slides[<?php echo $i;?>][first_button_url]"
								value="<?php echo esc_attr( $slide['first_button_url'] );?>" />
						</div>

						<h3>Section 2</h3>

						<div>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
							velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna.</div>
					</div>


				</td>
			</tr>
			<?php $i++;}?>
			
			
		</tbody>
	</table>
</div>

<?php
		/*
		 * foreach ( $this->fields as $key => $properties ) {
		 * $content = get_post_meta ( $post->ID, $key, TRUE );
		 * $arr_content = get_post_meta ( $post->ID, $key );
		 * // print '<pre>' . htmlspecialchars ( print_r ( $arr_content, TRUE ) ) . '</pre>';
		 * $label = "<label for='$key'>" . $properties ['label'] . "</label>";
		 * // You may extend the following to handle more types.
		 * if ('text' == $properties ['type']) {
		 * $content = htmlspecialchars ( $content, ENT_QUOTES, 'utf-8', FALSE );
		 * print "<p>$label<input style='padding:2px 0' name='$key' id='$key' value='$content' class='large-text' /></p>";
		 * } elseif ('wp_editor' == $properties ['type']) {
		 * print $label;
		 * $editor_settings = array (
		 * 'textarea_rows' => 8,
		 * 'media_buttons' => FALSE,
		 * 'teeny' => TRUE,
		 * 'tinymce' => FALSE,
		 * // a very minimal setup
		 * 'quicktags' => array (
		 * 'buttons' => 'strong,em,link'
		 * )
		 * );
		 * wp_editor ( $content, $key, $editor_settings );
		 * } elseif ('checkbox' == $properties ['type']) {
		 * $checked = checked ( $content, 'on', FALSE );
		 * print "<p><input type='checkbox' name='$key' id='$key' $checked /> $label</p>";
		 * } elseif ('number' == $properties ['type']) {
		 * $content = htmlspecialchars ( $content, ENT_QUOTES, 'utf-8', FALSE );
		 * print "<p>$label: <input type='number' name='$key' id='$key' value='$content' class='small-text' /></p>";
		 * } else {
		 * // Again, make it translatable.
		 * print "Unrecognized type for $key.";
		 * }
		 * print '</p>';
		 * }
		 */
	}
	/**
	 * Save the POSTed values on 'save_post'.
	 *
	 * @param int $post_id        	
	 * @return void
	 */
	public function save($post_id) {
		if (! $this->save_allowed ( $post_id )) {
			return;
		}
		$slides = array ();
		
		if (isset ( $_POST ['_alcor_slides'] ) && is_array ( $_POST ['_alcor_slides'] )) {
			foreach ( $_POST ['_alcor_slides'] as $sn => $slide ) {
				// skip the hidden "to copy" row for jQuery
				if ($sn == '0' || ! isset ( $slide ['image_id'] ) || empty ( $slide ['image_id'] )) {
					continue;
				}
				
				$slides [] = array (
						'image_id' => isset ( $slide ['image_id'] ) ? sanitize_text_field ( $slide ['image_id'] ) : null,
						'subtitle' => isset ( $slide ['subtitle'] ) ? sanitize_text_field ( $slide ['subtitle'] ) : null,
						'title' => isset ( $slide ['title'] ) ? sanitize_text_field ( $slide ['title'] ) : null,
						'link' => isset ( $slide ['link'] ) ? sanitize_text_field ( $slide ['link'] ) : null,
						'first_button_text' => isset ( $slide ['first_button_text'] ) ? sanitize_text_field ( $slide ['first_button_text'] ) : null,
						'first_button_url' => isset ( $slide ['first_button_url'] ) ? sanitize_text_field ( $slide ['first_button_url'] ) : null 
				);
			}
		}
		
		// save data
		if (! empty ( $slides )) {
			update_post_meta ( $post_id, '_alcor_slides', $slides );
		} else {
			delete_post_meta ( $post_id, '_alcor_slides' );
		}
	}
	/**
	 * Check permission to save the POSTed data.
	 *
	 * @param int $post_id        	
	 * @return bool
	 */
	protected function save_allowed($post_id) {
		// AJAX autosave
		if (defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) {
			return FALSE;
		}
		// Some other POST request
		if (! isset ( $_POST ['post_type'] )) {
			return FALSE;
		}
		// Wrong post type.
		if (! in_array ( $_POST ['post_type'], $this->post_types )) {
			return FALSE;
		}
		// Missing capability
		if (! current_user_can ( 'edit_post', $post_id )) {
			return FALSE;
		}
		// Wrong or missing nonce
		return wp_verify_nonce ( $_POST [$this->nonce_name], __FILE__ );
	}
}