<?php
/*
Plugin Name: Gavii Gallery
Plugin URI: http://gavii.com/downloads.php
Description: Sidebar Widget Displaying Thumbnails Of All Images In A Selected Gavii.com Album.
Version: 1.0.1
Author: Gavii
Author URI: http://gavii.com
License: GPL2
*/

class gavii_gallery extends WP_Widget 
{
	function gavii_gallery()
	{
		parent::WP_Widget(false, $name = __('Gavii Gallery', 'wp_widget_plugin'));
	}
	
	function form($instance)
	{
		if($instance)
		{
			$title = esc_attr($instance['title']);
			$key = esc_attr($instance['key']);
		}
		else
		{
			$title = 'Gavii Gallery';
			$key = '';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('key'); ?>"><?php _e('Gallery Key:', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('key'); ?>" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo $key; ?>" />
		</p>
		<?php
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = htmlentities(strip_tags($new_instance['title']));
		$instance['key'] = htmlentities(strip_tags($new_instance['key']));
		return $instance;
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		$title = apply_filters('Widget Title', $instance['title']);
		$key = $instance['key'];
		
		echo $before_widget;
		
		if($title)
		{
			echo $before_title.$title.$after_title;
		}
		
		if($key)
		{
			$contents = file_get_contents('http://gavii.com/album_api.php?akey='.$key);
			echo $contents;
		}
		
		echo $after_widget;	
	}
}

add_action('widgets_init', create_function('', 'return register_widget("gavii_gallery");'));?>