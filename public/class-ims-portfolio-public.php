<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://inmicrosol.com
 * @since      1.0.0
 * @package    ims-portfolio
 * @subpackage ims-portfolio/includes
 */
class Ims_Portfolio_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ims-portfolio-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'elastic_grid', plugin_dir_url( __FILE__ ) . 'css/elastic_grid.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ims-portfolio-public.js', array( 'jquery' ), $this->version, true );
		



	}


	/**
	 * Register shortcodes for the pluing frontend.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes(){

		  function shortcode($atts){
		  	// WP_Query arguments
			$args = array(
				'post_type'              => array( 'ims_portfolio' ),
				'posts_per_page'         => -1,
			);
			// The Query
			$query = new WP_Query( $args );
			// The Loop
			if ( $query->have_posts() ) {
				$items = array();
				while ( $query->have_posts() ) {
					$query->the_post();
					$portfolio_id 		=  get_the_ID();
					$button_name 		= get_post_meta( $portfolio_id, 'ims_button_name', true ); 
					$button_url 		= get_post_meta( $portfolio_id, 'ims_button_url', true ); 
					$thumb_img 			= get_post_meta( $portfolio_id, 'ims_thumb_img', true ); 
					$large_img 			= get_post_meta( $portfolio_id, 'ims_large_img', true );
					$portfolio_terms    = wp_get_post_terms(
							$portfolio_id, 'ims_portfoliotag', 
							array("fields" => "names")
							);
					$items[] = array(
				        'title' 		=> get_the_title(),
				        'description'   => get_the_content(),
				        'tags'      	=> $portfolio_terms,
				        'img_title' 	=> array( get_the_title() ),
				        'button_list'   => array(array(
				            'title' => $button_name,
				            'url'   => $button_url,
				            'new_window' => true
				        )),
				        'thumbnail' 	=> array($thumb_img),
				        'large' 		=> array($large_img)
					    );
					}
				}
				if( !empty( $items ) )
				{

					wp_enqueue_script( 'modernizr-script', 
						plugin_dir_url( __FILE__ ) .'/js/modernizr.custom.js', array(), null, true);
					wp_enqueue_script( 'classie-script', 
						plugin_dir_url( __FILE__ ) .'/js/classie.js', array(), null, true);
					wp_enqueue_script( 'elastislide-script', 
						plugin_dir_url( __FILE__ ) .'/js/jquery.elastislide.js', array(), null, true);
					wp_enqueue_script( 'hoverdir-script', 
						plugin_dir_url( __FILE__ ) .'/js/jquery.hoverdir.js', array(), null, true);
					wp_enqueue_script( 'elastic_grid-script', 
						plugin_dir_url( __FILE__ ) .'/js/elastic_grid.js', array(), null, true);
					
	
					// Restore original Post Data
					wp_reset_postdata();
					$json = json_encode($items);
					$custom_script = "jQuery(document).ready(function() {
						jQuery.noConflict();
						jQuery('#ims-portfolio').elastic_grid({
					            'showAllText' : 'All',
					            'filterEffect': 'scaleup', // moveup, scaleup, fallperspective, fly, flip, helix , popup
					            'hoverDirection': true,
					            'hoverDelay': 0,
					            'hoverInverse': false,
					            'expandingSpeed': 500,
					            'expandingHeight': 500,
					            'items' : ".$json."
					        });
						});";
					wp_add_inline_script('elastic_grid-script', $custom_script );
				}		    
		    //do your plugin stuff
		    echo "<div id='ims-portfolio'></div>";
		}
		    add_shortcode("ims-portfolio", "shortcode");
		
	}

}
