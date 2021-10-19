<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       http://inmicrosol.com
 * @since      1.0.0
 * @package    ims-portfolio
 * @subpackage ims-portfolio/includes
 */
class Ims_Portfolio_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 * @return    nothing
	 */
	public static function activate() {

	}

	/**
	 * Register custom post type and taxonomy of the plugin.
	 */

	public function admin_init(){

		$labels=array(  
			'name' 			=> 'IMS Portfolio',
			'singular_name' => 'IMS Portfolio',
			'add_new' 		=> 'Add New',
			'all_items' 	=> 'All Portfolios',
			'add_new_item' 	=> 'Add New',
			'edit_item' 	=> 'Edit Portfolio',
			'new_item' 		=> 'New Portfolio',
			'view_item' 	=> 'View Portfolio',
			'search_items' 	=> 'Search Portfolios',
			'not_found' 	=> 'No Portfolio found',
			'not_found_in_trash' => 'No Portfolio found in trash',
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false, // it's not public, it shouldn't have it's own permalink, and so on
			'show_ui' 				=> true,  // you should be able to edit it in wp-admin
			'exclude_from_search' 	=> true,  // you should exclude it from search results
			'show_in_nav_menus' 	=> false,  // you shouldn't be able to add it to menus
			'has_archive' 			=> false,  // it shouldn't have archive page
			'publicly_queryable' 	=> true,
			'rewrite' 				=> false,  // it shouldn't have rewrite rules
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_icon'  			=> 'dashicons-images-alt2',
			'supports' 				=> array('title','editor'),
		);

		register_post_type('ims_portfolio',$args);

		// Add new taxonomy, make it hierarchical like categories
		//first do the translations part for GUI
	  	$labels = array(
		    'name' 				=> __( 'Portfolio Tags', 'taxonomy general name' ),
		    'singular_name' 	=> __( 'Portfolio Tag', 'taxonomy singular name' ),
		    'search_items' 		=> __( 'Search Portfolio Tags' ),
		    'all_items' 		=> __( 'All Portfolio Tags' ),
		    'parent_item' 		=> __( 'Parent Portfolio Tag' ),
		    'parent_item_colon' => __( 'Parent Portfolio Tag:' ),
		    'edit_item' 		=> __( 'Edit Portfolio Tag' ), 
		    'update_item' 		=> __( 'Update Portfolio Tag' ),
		    'add_new_item' 		=> __( 'Add New Portfolio Tag' ),
		    'new_item_name' 	=> __( 'New Portfolio Tag Name' ),
		    'menu_name' 		=> __( 'Portfolio Tags' ),
		);    
		// Now register the taxonomy
	  	register_taxonomy('ims_portfoliotag',array('ims_portfolio'), array(
		    'hierarchical' 		=> true,
		    'labels' 			=> $labels,
		    'show_ui' 			=> true,
		    'show_admin_column' => true,
		    'query_var' 		=> true,
		    'rewrite' 			=> array( 'slug' => 'ims_portfoliotag' )
	  	));

	  	/* Add dummy data for Ims Portfolio */


      if( get_option('ims_portfolio_dummy_data') != 1 )
      {
	  	
	  	$tag_obj1 = (array)wp_insert_term('Web Development', 'ims_portfoliotag' );
	  	$tag_obj2 = (array)wp_insert_term('Graphic Design', 'ims_portfoliotag' );
	  	$tag_obj3 = (array)wp_insert_term('Web Design', 'ims_portfoliotag' );
	  	if( isset($tag_obj1['error_data']['term_exists']) 
	  		&& !empty( $tag_obj1['error_data']['term_exists'] ) ){
	  		$tag_id1 = $tag_obj1['error_data']['term_exists'];
	  	}
	  	else{	  		
	  		$tag_id1  = $tag_obj1['term_id'];
	  	}

	  	if( isset($tag_obj2['error_data']['term_exists']) 
	  		&& !empty( $tag_obj2['error_data']['term_exists'] ) ){
	  		$tag_id2 = $tag_obj2['error_data']['term_exists'];
	  	}
	  	else{	  		
	  		$tag_id2  = $tag_obj2['term_id'];
	  	}

	  	if( isset($tag_obj3['error_data']['term_exists']) 
	  		&& !empty( $tag_obj3['error_data']['term_exists'] ) ){
	  		$tag_id3 = $tag_obj3['error_data']['term_exists'];
	  	}
	  	else{	  		
	  		$tag_id3  = $tag_obj3['term_id'];
	  	}
	  	
	  	//Creating a post array
		$post = array(
		    'post_title'      => 'Indian Micro Solution',
		    'post_content'    => 'INDIAN MICRO SOLUTIONS is a software development firm with delivery center in India. We create and implement global software development and web development outsourcing solutions. We offer premium software development and strategy expertise to hundreds of companies worldwide. we deliver high quality services worldwide to our clients.',
		    'post_status'     => 'publish',
		    'post_type'       => 'ims_portfolio',
		);
		$the_post_id = wp_insert_post( $post );
		wp_set_post_terms( $the_post_id, array($tag_id3), 'ims_portfoliotag' );
		update_post_meta( $the_post_id, 'ims_button_name', 'Demo' );
		update_post_meta( $the_post_id, 'ims_button_url', 'http://acewebx.com' );
		update_post_meta( $the_post_id, 'ims_thumb_img', 'http://localhost/wordpress/wp-content/plugins/portfolio-gallery-by-ims/admin/images/ims.jpg)');
		update_post_meta( $the_post_id, 'ims_large_img', 'http://localhost/wordpress/wp-content/plugins/portfolio-gallery-by-ims/admin/images/IMS.jpg)' );



		$post = array(
		    'post_title'      => 'Just Discover',
		    'post_content'    => 'IFSC codes of all the banks, states, district and branch here at JustDiscover.in, JustDiscover.in is a portal of information. Along with IFSC code JustDiscover also includes important Pincodes and address of registered company. Browse the website for all the details.',
		    'post_status'     => 'publish',
		    'post_type'       => 'ims_portfolio',
		);
		$the_post_id = wp_insert_post( $post );
		wp_set_post_terms( $the_post_id, array($tag_id2), 'ims_portfoliotag' );
		update_post_meta( $the_post_id, 'ims_button_name', 'Demo' );
		update_post_meta( $the_post_id, 'ims_button_url', 'http://justdiscover.in' );
		update_post_meta( $the_post_id, 'ims_thumb_img', 'http://localhost/wordpress/wp-content/plugins/portfolio-gallery-by-ims/admin/images/justdiscover.jpg' );
		update_post_meta( $the_post_id, 'ims_large_img', 'http://localhost/wordpress/wp-content/plugins/portfolio-gallery-by-ims/admin/images/JustDiscover.jpg' );



		$post = array(
		    'post_title'      => 'Offerground',
		    'post_content'    => 'OfferGround will help you to find best deals for online shopping like amazone, flipkart, snapdeals, Myntra etc.',
		    'post_status'     => 'publish',
		    'post_type'       => 'ims_portfolio',
		);
		$the_post_id = wp_insert_post( $post );
		wp_set_post_terms( $the_post_id, array($tag_id1), 'ims_portfoliotag' );
		update_post_meta( $the_post_id, 'ims_button_name', 'Demo' );
		update_post_meta( $the_post_id, 'ims_button_url', 'http://offerground.com' );
		update_post_meta( $the_post_id, 'ims_thumb_img', 'http://localhost/wordpress/wp-content/plugins/portfolio-gallery-by-ims/admin/images/offerground.jpg' );
		update_post_meta( $the_post_id, 'ims_large_img', 'http://localhost/wordpress/wp-content/plugins/portfolio-gallery-by-ims/admin/images/OfferGround.jpg' );

      }
      

      /* End dummy data for Ims Portfolio */

	  update_option('ims_portfolio_dummy_data', 1); 
	}
}


