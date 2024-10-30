<?php 
/*************creating post for plugin**************/

function my5tech_ls_client_logo() {
	
		// Set UI labels for Custom Post Type
	
		$labels = array(			
        'name' => _x( 'Client Logo', 'client_logo' ),
        'singular_name' => _x( 'Client Logo', 'client_logo' ),
        'add_new' => _x( 'Add New', 'client_logo' ),
        'add_new_item' => _x( 'Add New Client Logo', 'client_logo' ),
        'edit_item' => _x( 'Edit Client Logo', 'client_logo' ),
        'new_item' => _x( 'New Client Logo', 'client_logo' ),
        'view_item' => _x( 'View Client Logo', 'client_logo' ),
        'search_items' => _x( 'Search Client Logo', 'client_logo' ),
        'not_found' => _x( 'No Client Logo found', 'client_logo' ),
        'not_found_in_trash' => _x( 'No Client Logo found in Trash', 'client_logo' ),
        'parent_item_colon' => _x( 'Parent Music Review:', 'client_logo' ),
        'menu_name' => _x( 'Logo Slider', 'client_logo' ),
    );
	
	// Set other options for Custom Post Type
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => 'dashicons-format-image',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'thumbnail' )
	  ); 

	register_post_type( 'client-logo' , $args );
} 

// Post type of add images
add_action('init', 'my5tech_ls_client_logo');	


function my5tech_ls_logo_category_taxonomy() {
    register_taxonomy(
        'logo_cat',
        'client-logo',
        array(
            'hierarchical' => true,
            'label' => 'Logo Category',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'logo-category',
                'with_front' => false
            )
        )
    );
}
add_action( 'init', 'my5tech_ls_logo_category_taxonomy');

	
add_filter('manage_posts_columns', 'my5tech_post_column', 2);

// Add columns
function my5tech_post_column($cols){
	
	$pst_type=$post->post_type;
		if( $pst_type == 'client-logo'){ 
		$cols['my5tech_logo_thumbnail'] = _('Logo Image');
		$cols['my5tech_client_url'] = _('Client Website Url');
		}
	return $cols;
}
	
add_action('manage_posts_custom_column', 'my5tech_display_post_thumbnail_column', 10, 2);
	

function my5tech_display_post_thumbnail_column($col, $id){
  switch($col){
	case 'my5tech_logo_thumbnail':
	  if( function_exists('the_post_thumbnail') ){
	
		$post_thumbnail_id = get_post_thumbnail_id($id);
		$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
		$post_thumbnail_img= $post_thumbnail_img[0];
		if($post_thumbnail_img !='')
		  echo '<img width="120" height="120" src="' . $post_thumbnail_img . '" />';
		else
		  echo 'No logo added.';	
	  }
	  else{
		echo 'No logo added.';
	  }	
	case 'my5tech_client_url':
		if($col == 'my5tech_client_url'){
			echo get_post_meta( $id, 'my5tech_logo_meta_url', true );;
		} 		   
	  break;
 
  }
}

// client logo Meta Box 
function my5tech_logo_add_meta_box(){
// add meta Box
 remove_meta_box( 'postimagediv', 'client-logo', 'side' );
 add_meta_box('postimagediv', __('Client Logo'), 'post_thumbnail_meta_box', 'client-logo', 'normal', 'high');
 add_meta_box('my5tech_clientlogo_meta_id', __('Client Website Url'), 'my5tech_logo_meta_callback', 'client-logo', 'normal', 'high');
}
add_action('add_meta_boxes' , 'my5tech_logo_add_meta_box');

//  Call Back Funtion
function my5tech_logo_meta_callback($post){

    wp_nonce_field( basename( __FILE__ ), 'aft_nonce' );
    $aft_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <label for="my5tech_logo_meta_url" class="my5tech_logo_meta_url"><?php _e( 'Client Website Url', '' )?></label>
        <input class="widefat" type="text" name="my5tech_logo_meta_url" id="my5tech_logo_meta_url" value="<?php if ( isset ( $aft_stored_meta['my5tech_logo_meta_url'] ) ) echo $aft_stored_meta['my5tech_logo_meta_url'][0]; ?>" /> <br>
		
    </p>

<?php

}

// Save Meta Box 
function my5tech_client_logo_meta_save( $post_id ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'my5tech_nonce' ] ) && wp_verify_nonce( $_POST[ 'my5tech_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
	
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
	
    if( isset( $_POST[ 'my5tech_logo_meta_url' ] ) ) {
        update_post_meta( $post_id, 'my5tech_logo_meta_url', sanitize_text_field( $_POST[ 'my5tech_logo_meta_url' ] ) );
    }
}
add_action( 'save_post', 'my5tech_client_logo_meta_save' );


function my5tech_shortcode_function() { 
				
?>
	<script>
		jQuery(document).ready(function(){
		jQuery('.owl-carousel').owlCarousel({
			
		loop:true,
		items:<?php $item_value = get_option('my5tech_slider_settings')['items'];
					
			if($item_value == ""){
				
				echo 4;
			}
			else{
				
				echo $item_value;
				
			}	
		?>,
		
		autoplay:<?php $auto_value_play =  get_option('my5tech_slider_settings')['auto_play'];

				echo $auto_value_play ? 'true' : 'false';
				
		?>,
		center:<?php $stop_center_option = get_option('my5tech_slider_settings')['stop_on_center']; 
		
			echo $stop_center_option ? 'true' : 'false';
		
		?>,
	
		smartSpeed: <?php $pag_value = get_option('my5tech_slider_settings')['pagination_speed']; 
		
					if($pag_value == ""){
				echo 500;
				}
				else{
					
					echo $pag_value;			
				}	
		
		?>,
	
		autoWidth:<?php echo get_option('my5tech_slider_settings')['single_item'];	?>,
		
		mouseDrag:<?php $auto_value_mouse =  get_option('my5tech_slider_settings')['mouse_drag'];

				echo $auto_value_mouse ? 'true' : 'false';
					
		?>,
		
		autoHeight:<?php $auto_value_responsive =  get_option('my5tech_slider_settings')['responsive'];

				echo $auto_value_responsive ? 'true' : 'false';
					
				
		?>,
		
		nav:<?php $auto_value_navigation =  get_option('my5tech_slider_settings')['navigation'];

				echo $auto_value_navigation ? 'true' : 'false';
				
		?>,

		margin:<?php $slider_margin_value = get_option('my5tech_slider_settings')['slide_margin']; 
		
					if($slider_margin_value == ""){
				echo 10;
				}
				else{
					
					echo $slider_margin_value;			
				}	
		
		?>,	
		
		dots: <?php $auto_value_pgination = get_option('my5tech_slider_settings')['pagination']; 
		
			echo $auto_value_pgination;
		?>,
		
		})
			});
	</script>
	<div class="row">
		<div class="owl-carousel owl-theme">
		<?php
		$query = new WP_Query( array('post_type' => 'client-logo') );

		while ( $query->have_posts() ) : $query->the_post(); ?>
		  
		<a href=""><?php the_post_thumbnail();?></a>

		<?php wp_reset_postdata(); ?>
		<?php endwhile; ?>
		
</div>
</div>	

	
<?php
} 
add_shortcode('my5tech-shortcode', 'my5tech_shortcode_function');