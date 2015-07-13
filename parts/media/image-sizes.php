<?php
/*
Title: Image Sizes
Post Type: piklist_wp_helpers_post
Priority: normal
Capability: default-none
Order: 1
*/
?>

<?php global $_wp_additional_image_sizes; ?>

<?php $attachment_id = $post->ID; ?>

<?php $has_image = wp_get_attachment_image_src($attachment_id, 'post-thumbnail'); ?>


	  <ul>

	    <li>
	      
	      <input type="text" readonly="readonly" class="large-text" value="<?php echo wp_get_attachment_url($attachment_id);?>">
	    
	    </li>

	  </ul>


	<?php if(!empty($has_image)) : ?>

	  <?php foreach ($_wp_additional_image_sizes as $image_size => $value) : ?>

		  <ul>

		    <?php $image_attributes = wp_get_attachment_image_src($attachment_id, $image_size);?>

		    <li>
		     
		      <?php echo '<strong>' . __('Width', 'wp-helpers') . ': </strong>' . $image_attributes[1] . 'px'; ?>

		      <?php echo '<strong>' . __('Height', 'wp-helpers') . ': </strong>' . $image_attributes[2] . 'px'; ?>

		    </li>

		    <li>

		      <input type="text" readonly="readonly" class="large-text" value="<?php echo $image_attributes[0]; ?>">

		    </li>

		  </ul>

	  <?php endforeach; ?>

	<?php endif;