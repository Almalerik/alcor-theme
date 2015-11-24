<?php //get_alcor_slider(45);?>

		<?php if ( $alcor -> show_header_background_image() ): ?>
		<div id="site-header-image" class="<?php echo $alcor -> get_setting ( 'header_image_show' );?>">
			<div class="alcor-site-branding alcor-parallax <?php echo $alcor -> get_setting ( 'header_image_parallax' ) ? 'background-attachment-fixed': '';?>" style="background-image: url('<?php header_image(); ?>');">
				<?php if ($alcor -> get_setting ( 'header_image_text' ) != "" || is_customize_preview ()):?>
				<div class="alcor-site-branding-content">
					<h2><?php echo esc_attr($alcor -> get_setting ( 'header_image_text' ));?></h2>
				</div>
				<?php endif;?>
			</div>
		</div>
		<?php endif;?>