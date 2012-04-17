<?php

/*
Plugin Name: Media RSS Image Links
Description: Adds media RSS elements to your RSS2 feed for images attached to posts.
Version: 1.0
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

function cf_media_rss_links() {
	global $post;
	$items = get_children(
		array(
			'post_parent' => $post->ID,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
		)
	);
	if (is_array($items)) {
		foreach ($items as $item) {
			$info = wp_get_attachment_metadata($item->ID);
			$thumb = wp_get_attachment_image_src($item->ID);
			echo '
	<media:content 
		url="'.wp_get_attachment_url($item->ID).'"
		type="'.$item->post_mime_type.'"
		width="'.$info['width'].'"
		height="'.$info['height'].'"
	/>
	<media:thumbnail 
		url="'.$thumb[0].'" 
		width="'.$thumb[1].'" 
		height="'.$thumb[2].'" 
	/>
			';
		}
	}
}
add_action('rss2_item', 'cf_media_rss_links');

?>