<?php
/**
 * Plugin Name: Faculty/Staff Directory
 * Plugin URI: http://www.jcummings.net
 * Description: A directory for Faculty/Staff of a school, college, university, etc.
 * Version: 1.51
 * Author: John Cummings
 * Author URI: http://www.jcummings.net
 * License: GPL2
 */
 /*  Copyright 2014  John Cummings  (email : john@jcummings.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

//Add necessary JS and CSS
add_action('admin_enqueue_scripts', 'add_fs_js');   
function add_fs_js(){    
  wp_enqueue_style( 'facstaff-style', plugins_url('/css/faculty-staff-styles.css', __FILE__) );
}

//Create custom post type
function facstaff_post_type() {
   // Labels
	$labels = array(
		'name' => _x("Faculty and Staff", "post type general name"),
		'singular_name' => _x("Faculty and Staff", "post type singular name"),
		'menu_name' => 'Faculty and Staff Profiles',
		'add_new' => _x("Add New", "facstaff item"),
		'add_new_item' => __("Faculty/Staff Name"),
		'edit_item' => __("Edit Profile"),
		'new_item' => __("New Profile"),
		'view_item' => __("View Profile"),
		'search_items' => __("Search Profiles"),
		'not_found' =>  __("No Profiles Found"),
		'not_found_in_trash' => __("No Profiles Found in Trash"),
		'parent_item_colon' => ''
	);
	
	// Register custom post type
	register_post_type('facstaff' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-groups',
		'rewrite' => false,
		'supports' => array('title', 'thumbnail', 'page-attributes', 'excerpt', 'editor')
	) );
}
add_action( 'init', 'facstaff_post_type', 0 );

//Add custom taxonomies to support sorting by cateogry
function add_custom_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('profile-category', 'facstaff', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Profile Category', 'taxonomy general name' ),
      'singular_name' => _x( 'Profile Category', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Categories' ),
      'all_items' => __( 'All Categories' ),
      'parent_item' => __( 'Parent Category' ),
      'parent_item_colon' => __( 'Parent Category:' ),
      'edit_item' => __( 'Edit Category' ),
      'update_item' => __( 'Update Category' ),
      'add_new_item' => __( 'Add New Category' ),
      'new_item_name' => __( 'New Category Name' ),
      'menu_name' => __( 'Categories' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'profile-category', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );


add_action( 'template_redirect', 'facstaff_post_template' );
function facstaff_post_template() {
    global $wp, $wp_query;
    if ( isset( $wp->query_vars['post_type'] ) && $wp->query_vars['post_type'] == 'facstaff' ) {
        if ( have_posts() ) {
            add_filter( 'the_content', 'facstaff_post_template_filter' );
        }
        else {
            $wp_query->is_404 = true;
        }
    }
}

function facstaff_post_template_filter( $content ) {
    global $wp_query;
    $facstaffID = $wp_query->post->ID;
    //$facstaff_object = get_post( $facstaffID );

    $output = '<h4>Placeholder</h4>';
    $output = '<div>';
    $output .= '<div style="float:left; padding:10px">';
    $output .= get_the_post_thumbnail( $facstaffID, 'thumbnail');
    $output .= '</div>';
    $output .= '<div><h3>';
    $output .= get_post_meta($facstaffID, 'facstafftitle',true) . '</h3>';
    $output .= $wp_query->post->post_content;
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}


//Add our metaboxes in the WP admin
function add_facstaff_metabox() {
	add_meta_box('facstaff_info', 'Faculty/Staff Profile Info', 'facstaff_info', 'facstaff', 'normal', 'core','post');
}
add_action( 'add_meta_boxes', 'add_facstaff_metabox' );

//Change Text Prompt on post title
add_filter('gettext','custom_enter_title');
function custom_enter_title( $input ) {
    global $post_type;
    if( is_admin() && 'Enter title here' == $input && 'facstaff' == $post_type )
        return 'Enter the full name of the individual here';
    return $input;
}
add_action( 'admin_init',  'change_excerpt_box_title' );
function change_excerpt_box_title() {
	remove_meta_box( 'postexcerpt', 'facstaff', 'side' );
	add_meta_box('postexcerpt', __('Bio Excerpt'), 'post_excerpt_meta_box', 'facstaff', 'normal', 'high');
}

// The Faculty/Staff Info Metabox
function facstaff_info($post) {
	wp_nonce_field( basename( __FILE__ ), 'facstaff_nonce' );
    $facstaff_stored_meta = get_post_meta( $post->ID );	
    ?>
	
	<p>
		<form name="fsprofile" id="fsprofile" method="post">
		<table>
		<tr>
		<td><label for="facstafftitle">Title:</label></td>
		<td><input type="text" name="facstafftitle" value="<?php if ( isset ( $facstaff_stored_meta['facstafftitle'] ) ){echo $facstaff_stored_meta['facstafftitle'][0];}?>" /></td>
		</tr>
		
		<tr>
		<td><label for="facstaffcompany">Company:</label></td>
		<td><input type="text" name="facstaffcompany" value="<?php if ( isset ( $facstaff_stored_meta['facstaffcompany'] ) ){echo $facstaff_stored_meta['facstaffcompany'][0];}?>" /></td>
		</tr>
		
		<tr>
		<td><label for="facstaffemail">Email:</label></td>
		<td><input type="email" name="facstaffemail" value="<?php if ( isset ( $facstaff_stored_meta['facstaffemail'] ) ){echo $facstaff_stored_meta['facstaffemail'][0];}?>" /></td>
		</tr>
		<tr>
		<td><label for="facstafftwitter">Twitter:</label></td>
		<td><input type="text" id="facstafftwitter" name="facstafftwitter"  
		value="<?php if ( isset ( $facstaff_stored_meta['facstafftwitter'] ) ){echo $facstaff_stored_meta['facstafftwitter'][0];}?>" /></td>
		</tr>
		<tr>
		<td><label for="facstafflinkedin">LinkedIn:</label></td>
		<td><input type="text" name="facstafflinkedin" value="<?php if ( isset ( $facstaff_stored_meta['facstafflinkedin'] ) ){echo $facstaff_stored_meta['facstafflinkedin'][0];}?>" /></td>
		</tr>
		<tr>
		<td><label for="facstaffphone">Phone:</label></td>
		<td><input type="text" name="facstaffphone" value="<?php if ( isset ( $facstaff_stored_meta['facstaffphone'] ) ){echo $facstaff_stored_meta['facstaffphone'][0];}?>" /></td>
		</tr>	
		<tr>
		<td><label for="facstaffwebsite">Website:</label></td>
		<td><input type="text" name="facstaffwebsite" id="facstaffwebsite"  value="<?php if ( isset ( $facstaff_stored_meta['facstaffwebsite'] ) ){echo $facstaff_stored_meta['facstaffwebsite'][0];} ?>" /></td>
		</tr>
		<tr>
		<td><label for="facstaffphone">Office Location:</label></td>
		<td><input type="text" name="facstaffofficelocation" value="<?php if ( isset ( $facstaff_stored_meta['facstaffofficelocation'] ) ){echo $facstaff_stored_meta['facstaffofficelocation'][0];}?>" /></td>
		</tr>
		<tr>
		<td><label for="facstaffnotes">Notes:</label></td>
		<td><textarea name="facstaffnotes" rows="4" cols="50" id="meta-textarea"><?php if ( isset ( $facstaff_stored_meta['facstaffnotes'] ) ) echo $facstaff_stored_meta['facstaffnotes'][0]; ?></textarea></td>
		</tr>	
		</table>
		</form>
	</p>
	<?php
}
 
/**
 * Saves the custom meta input
 */
function facstaff_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'facstaff_nonce' ] ) && wp_verify_nonce( $_POST[ 'facstaff_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed 
    if( isset( $_POST[ 'facstafftwitter' ] ) ) {
    	$twtrim = array("http://www.twitter.com/", "https://www.twitter.com/", "http://twitter.com/", "https://twitter.com/", "twitter.com/","@");
		$trimmedtwitter = str_replace($twtrim, "", $_POST['facstafftwitter']);
        update_post_meta( $post_id, 'facstafftwitter', sanitize_text_field( $trimmedtwitter ) );
    }
    
    if( isset( $_POST[ 'facstafftitle' ] ) ) {
     	update_post_meta( $post_id, 'facstafftitle', sanitize_text_field( $_POST[ 'facstafftitle' ] ) );
    }
    
    if( isset( $_POST[ 'facstaffcompany' ] ) ) {
     	update_post_meta( $post_id, 'facstaffcompany', sanitize_text_field( $_POST[ 'facstaffcompany' ] ) );
    }
    

    if( isset( $_POST[ 'facstaffemail' ] ) ) {
     	update_post_meta( $post_id, 'facstaffemail', sanitize_text_field( $_POST[ 'facstaffemail' ] ) );
    }  

    if( isset( $_POST[ 'facstaffphone' ] ) ) {
     	update_post_meta( $post_id, 'facstaffphone', sanitize_text_field( $_POST[ 'facstaffphone' ] ) );
    }       
    
    if( isset( $_POST[ 'facstafflinkedin' ] ) ) {
        $litrim = array("http://www.linkedin.com/", "https://www.linkedin.com/", "http://linkedin.com/", "https://linkedin.com/", "http://www.linkedin.com/in/", "https://www.linkedin.com/in/");
		$linkedintrimmed = str_replace($litrim, "", $_POST['facstafflinkedin']);
     	update_post_meta( $post_id, 'facstafflinkedin', sanitize_text_field( $linkedintrimmed ) );
    }       

    if( isset( $_POST[ 'facstaffwebsite' ] ) ) {
        $webtrim = array("http://", "https://");
		$webtrimmed = str_replace($webtrim, "", $_POST['facstaffwebsite']);
     	update_post_meta( $post_id, 'facstaffwebsite', sanitize_text_field( $webtrimmed ) );
    }   
    
    if( isset( $_POST[ 'facstaffofficelocation' ] ) ) {
     	update_post_meta( $post_id, 'facstaffofficelocation', sanitize_text_field( $_POST[ 'facstaffofficelocation' ] ) );
    }   
    
    if( isset( $_POST[ 'facstaffnotes' ] ) ) {
     	update_post_meta( $post_id, 'facstaffnotes', sanitize_text_field( $_POST[ 'facstaffnotes' ] ) );
    }  
 
}
add_action( 'save_post', 'facstaff_meta_save' );


add_filter('manage_facstaff_posts_columns', 'facstaff_table_head');
function facstaff_table_head( $defaults ) {
	$defaults['menu_order'] = 'Sort Order';
    $defaults['facstafftitle']   = 'Title';
    $defaults['facstaffemail']   = 'Email';
    $defaults['facstaffphone']   = 'Phone';
    return $defaults;
}

add_action( 'manage_facstaff_posts_custom_column', 'facstaff_table_content', 10, 2 );
function facstaff_table_content( $column_name, $post_id ) {
    if ($column_name == 'facstafftitle') {
    $facstafftitle = get_post_meta( $post_id, 'facstafftitle', true );
      echo  $facstafftitle;
    }
    if ($column_name == 'facstaffemail') {
    $email = get_post_meta( $post_id, 'facstaffemail', true );
    echo $email;
    }

    if ($column_name == 'facstaffphone') {
    echo get_post_meta( $post_id, 'facstaffphone', true );
    }
    
    if ($column_name == 'menu_order') {
    $thispost = get_post($id);
	$menu_order = $thispost->menu_order;
    echo $menu_order;
    }   
      
}

include 'admin/facultystaff-admin.php';

function facstaff_directory_shortcode( $atts, $content = null ) {
	$display_option = 'facstaff-template.php';
	if(get_option('fsdirectory_displaystyle')=='One Column'){
		$display_option='/display-templates/facstaff-template.php';
	}

	if(get_option('fsdirectory_displaystyle')=='Two Column'){
		$display_option='/display-templates/facstaff-template-dual.php';
	}

	if(get_option('fsdirectory_displaystyle')=='Three Column'){
		$display_option='/display-templates/facstaff-template-triple.php';
	}

	if(get_option('fsdirectory_displaystyle')=='Simple List'){
		$display_option='/display-templates/facstaff-template-list.php';
	}

	if(get_option('fsdirectory_displaystyle')=='By Category'){
		$display_option='/display-templates/facstaff-category-template.php';
	}

	/*if(get_option('fsdirectory_displaystyle')=='hCard List'){
		$display_option='/display-templates/facstaff-template-vcard-hcard.php';
	}*/	
	
	ob_start();
    include(dirname(__FILE__) . $display_option);
    return ob_get_clean();
}
add_shortcode( 'fsdirectory', 'facstaff_directory_shortcode' );

//Add widget functionality
class fsdirectory_widget extends WP_Widget {

    function fsdirectory_widget() {
        parent::WP_Widget(false, $name = 'Faculty/Staff Widget');	
    }

    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $facstaff_id 	= $instance['facstaffid'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
                        <div id="fswidgetimage" style="float:left; margin: 5px;">
	                       	<?php echo get_the_post_thumbnail( $facstaff_id, 'thumbnail');?>
                        </div>
                        	
                        <div id="fswidgetcontent">
                    	    <strong><?php echo get_the_title( $facstaff_id ) ?></strong><br>
							<em><?php echo get_post_meta($facstaff_id, 'facstafftitle',true) ?></em>
							<br><br>
							<?php echo get_post_field('post_excerpt', $facstaff_id);?>
							<br><br>
							<a href='<?php echo get_permalink( $facstaff_id );?>'>More</a>
                        </div>
              <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['facstaffid'] = strip_tags($new_instance['facstaffid']);
        return $instance;
    }

    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $message	= esc_attr($instance['facstaffid']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('facstaffid'); ?>"><?php _e('ID of Profile to Feature'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('fcstaffid'); ?>" name="<?php echo $this->get_field_name('facstaffid'); ?>" type="text" value="<?php echo $message; ?>" />
        </p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("fsdirectory_widget");'));
?>