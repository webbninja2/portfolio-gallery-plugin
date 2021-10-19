<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    ims-portfolio
 * @subpackage ims-portfolio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, 
 *
 * @package    ims-portfolio
 * @subpackage ims-portfolio/admin
 */
class Ims_Portfolio_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ims-portfolio-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the custom meta fields for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_meta_boxes() {
		add_meta_box(
            'ims_portfolio_meta_box',
            'IMS PORTFOLIO FIELDS',
            array( $this, 'show_ims_portfolio_meta_box'),
            'ims_portfolio',
            'normal',
            'high'
        );
	}

	/**
	 * Show the custom meta fields for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function show_ims_portfolio_meta_box()
	{ 
		require plugin_dir_path( __FILE__ ) . 'partials/ims-portfolio-admin-display.php';
	}


	/**
	 * show media ifram on edit image hack
	 *
	 * @since    1.0.0
	 */
	function meta_box_scripts() {
	    global $post;
	    /*wp_enqueue_media( array( 
	        'post' => $post->ID, 
	    ) );*/
	}

	/**
	 * Save the custom meta fields for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function save_meta_boxes( $post_id ){
	
		// check permissions
		if('ims_portfolio' === $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}  
		}
        $ims_button_name 	= sanitize_title( $_POST['ims_button_name'] );
		$ims_button_url 	= sanitize_title($_POST['ims_button_url']);
		$ims_thumb_img 		= htmlentities( $_POST['ims_thumb_img'] );
		$ims_large_img 		= htmlentities( $_POST['ims_large_img'] );
		update_post_meta( $post_id, 'ims_button_name', $ims_button_name );
		update_post_meta( $post_id, 'ims_button_url', $ims_button_url );
		update_post_meta( $post_id, 'ims_thumb_img', $ims_thumb_img );
		update_post_meta( $post_id, 'ims_large_img', $ims_large_img );

		

	}


	/**
   * Show row meta on the plugin screen.
   *
   * @param mixed $links Plugin Row Meta
   * @param mixed $file  Plugin Base file
   * @return  array
   */

	public function plugin_row_meta( $links, $file ){
	    if( strpos( $file, 'portfolio-gallery-by-ims' ) !== false ){
	        $new_links = array(
	            'ims_portfolio_support' => '<a target="_blank" href="http://acewebx.com/ims-portfolio-gallery">Support</a>',
	    );
	    
	    $links = array_merge( $links, $new_links );
	  }
	  
	  return $links;
		

	}

/**
	 * Register custom post type and taxonomy of the plugin.
	 *
	 * @since     1.0.0
	 * @return    nothing
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
