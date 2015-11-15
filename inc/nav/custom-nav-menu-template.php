<?php
include 'custom-icons.php';
?>

				<div class="hide-if-no-js alcor-menu-options <?php echo ( !empty($item->alcor_icon) || !empty($item->alcor_image) || !empty($item->alcor_custom_html)) ? 'alcor-hidden' : ''?>">
					<input class="alcor-icon-button button" type="button" value="<?php echo _e('Add font icon', 'alcor');?>" />
					<input class="alcor-image-button button" type="button" value="<?php echo _e('Add image', 'alcor');?>" />
					<input class="alcor-custom-html-button button" type="button" value="<?php echo _e('Add custom html', 'alcor');?>" />
				</div>
				
				<p class="field-custom description description-wide alcor-menu-custom-html <?php echo empty($item->alcor_custom_html) ? 'alcor-hidden' : ''; ?> alcor_menu_custom_html">
					<label for="edit-menu-item-alcor-custom-html-<?php echo $item_id; ?>">
						<?php _e( 'Custom html' ); ?><br />
						<input type="text" id="edit-menu-item-alcor-custom-html-<?php echo $item_id; ?>" class="code edit-menu-item-custom alcor-options-val" name="menu-item-alcor-custom-html[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->alcor_custom_html ); ?>" />
						<a class="button alcor-menu-options-reset" href="#"><i class="fa fa-trash alcor-red"></i></a>
					</label>
				</p>
				
				<p class="field-custom description description-wide alcor-menu-icon <?php echo empty($item->alcor_icon) ? 'alcor-hidden' : ''; ?>">
					<label for="edit-menu-item-alcor-icon-<?php echo $item_id; ?>">
						<?php _e( 'Icon' ); ?><br />
						<select class="alcor-icon-select2 alcor-options-val" style="font-family: 'FontAwesome'; width: 200px;" id="edit-menu-item-alcor-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-alcor-icon[<?php echo $item_id; ?>]">
							<option value=""><?php _e( 'None' ); ?></option>
						<?php foreach ($icon_font as $label => $class): ?>
							<option value="<?php echo $class;?>" <?php echo $class == $item->alcor_icon ? 'selected' : ''; ?>><?php echo $label;?></option>
						<?php endforeach;?>
						</select>
						<a class="button alcor-menu-options-reset" href="#"><i class="fa fa-trash alcor-red"></i></a>
					</label>
				</p>
				
				<p class="field-custom description description-wide alcor-menu-image <?php echo empty($item->alcor_image) ? 'alcor-hidden' : ''; ?> alcor_menu_image">
					<label for="edit-menu-item-alcor-image-<?php echo $item_id; ?>">
						<?php _e( 'Enter a URL or upload an image' ); ?><br />
					    <input id="edit-menu-item-alcor-image-<?php echo $item_id; ?>" type="text" size="30" name="ad_image" value="" class="alcor-options-val"/> 
					    <a id="alcor-image-upload-button" class="button" href="#"><i class="fa fa-upload"></i></a>
					    <a class="button alcor-menu-options-reset" href="#"><i class="fa fa-trash alcor-red"></i></a>
					</label>
				</p>
				
