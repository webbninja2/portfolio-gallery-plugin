<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://inmicrosol.com
 * @since      1.0.0
 *
 * @package    Ims Portfolio
 * @subpackage ims-portfolio/admin/partials
 */
?>
<?php
global $post;  
$ims_button_name 	= get_post_meta( $post->ID, 'ims_button_name', true ); 
$ims_button_url 	= get_post_meta( $post->ID, 'ims_button_url', true ); 
$ims_thumb_img 		= get_post_meta( $post->ID, 'ims_thumb_img', true ); 
$ims_large_img 		= get_post_meta( $post->ID, 'ims_large_img', true ); 
?>
<div>
  <p class="imsShortcode">Use this  <strong> <code> [ims-portfolio] </code></strong>  shortcode for Portfolio Gallary </p>
</div>
<input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
<p>
<label for="ims_button_name">Add Button Label (Portfolio link lable name)</label>
<br/>
<input type="text" name="ims_button_name" value="<?php echo $ims_button_name; ?>">
</p>
<p>
<label for="ims_button_url">Add Button Label (Portfolio link)</label>
<br/>
<input type="text" name="ims_button_url" value="<?php echo $ims_button_url; ?>">
</p>
<div class="ims-thumbnail">
	<p class="ims-image-preview">
	<?php 
		if( empty( $ims_thumb_img ) ){
			$ims_thumb_img = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		}
	?>
	<img src="<?php echo $ims_thumb_img; ?>" style="max-width: 250px;">	
	</p>
	<label for="ims_thumb_img">For best view use 250x250 image size</label><br>
	<input type="hidden" name="ims_thumb_img" id="ims_thumb_img" class="meta-image regular-text" value="<?php echo $ims_thumb_img; ?>">
	<input type="button" class="button image-upload-thumb" value="Upload Portfolio Thumbnial">
</div>
<div class="ims-fullImage">
	<p class="ims-image-preview">
	
	<?php 
		if( empty( $ims_large_img ) ){
			$ims_large_img = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		}
	?>
	<img src="<?php echo $ims_large_img; ?>" style="max-width: 250px;">
	</p>
	<label for="ims_large_img">For best view use same width of every image</label><br>
	<input type="hidden" name="ims_large_img" id="ims_large_img" class="meta-image regular-text" value="<?php echo $ims_large_img; ?>">
	<input type="button" class="button image-upload-full" value="Upload Portfolio Large Image">
</div>
