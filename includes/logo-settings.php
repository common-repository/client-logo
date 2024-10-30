<?php

//function add menu in admin Page

function my5tech_ls_add_submenu_page() {

	add_submenu_page( 
		'edit.php?post_type=client-logo', 
		__( 'Logo Settings' ), 
		__( 'Logo Settings' ), 
		'manage_options', 
		'logo_settings', 
		'my5tech_ufls_admin_logo_callback' 
	);

}
add_action( 'admin_menu', 'my5tech_ls_add_submenu_page' );

function my5tech_ufls_admin_logo_callback() {
	?>
	
	
		<div class="wrap">
			<div id="" class=""></div>
			<h2>Logo Settings</h2>
			<h4>Short code :-  [my5tech-shortcode]</h4>
				
				<div class="">
					<div class="">
						<form method="post" action="options.php">
							<?php settings_fields( 'my5tech_settings' ); ?>
							<?php do_settings_sections( "my5tech_settings" ); ?>		
							<?php submit_button(); ?>
						</form>
					</div>				
				</div>
		</div>
	
	<?php
}

//function to create option on Setting Page
function my5tech_ls_create_options() { 
	
	add_settings_section( 'my5tech_slider_section', null, null, 'my5tech_settings' );

    add_settings_field(
        'items', 'Item Count', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'Number of items show ',
			'id' => 'items',
			'type' => 'text',
			'group' => 'my5tech_slider_settings'
		)
    );
    add_settings_field(
        'single_item', 'Show Single Item', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'If checked a single image will be displayed ',
			'id' => 'single_item',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	
	
	
    add_settings_field(
        'slide_margin', 'Slider Margin', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'Margin between two images',
			'id' => 'slide_margin',
			'type' => 'text',
			'group' => 'my5tech_slider_settings'
		)
    );
    add_settings_field(
        'pagination_speed', 'Pagination Speed', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'Pagination speed  in milliseconds',
			'id' => 'pagination_speed',
			'type' => 'text',
			'group' => 'my5tech_slider_settings'
		)
    );
    add_settings_field(
        'mouse_drag', 'Mouse Drag Slider Option', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'Mouse Drag Slider Option',
			'id' => 'mouse_drag',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	add_settings_field(
        'auto_play', 'Auto Play Slider', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'If checked the slider will slide automatically',
			'id' => 'auto_play',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	add_settings_field(
        'stop_on_center', 'Center Image', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'If checked the image on center',
			'id' => 'stop_on_center',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	add_settings_field(
        'navigation', 'Display Navigation', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'If checked, next and previous links will be displayed',
			'id' => 'navigation',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	add_settings_field(
        'pagination', 'Display Pagination', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'If checked the slider will be paginated',
			'id' => 'pagination',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	
	add_settings_field(
        'responsive', 'Responsive', 'my5tech_ufls_settings_field', 'my5tech_settings', 'my5tech_slider_section',
		array(
			'desc' => 'If checked the slider will Responsive.',
			'id' => 'responsive',
			'type' => 'checkbox',
			'group' => 'my5tech_slider_settings'
		)
    );
	
    //register fields
	register_setting('my5tech_settings', 'my5tech_slider_settings', '');
	
}
add_action('admin_init', 'my5tech_ls_create_options');


//Fuction to  create  settings field options
function my5tech_ufls_settings_field($args){
	$option_value = get_option($args['group']);
?>
	<?php if($args['type'] == 'text'): ?>
	
		<input type="text" id="<?php echo $args['id'] ?>" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" value="<?php echo (isset($option_value[$args['id']]))?esc_attr($option_value[$args['id']]):''; ?>">
	
	<?php elseif($args['type'] == 'checkbox'): ?>
	
		<input type="hidden" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" value="0" />
		
		<input type="checkbox" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" id="<?php echo $args['id']; ?>" value="1" <?php if(isset($option_value[$args['id']])) checked($option_value[$args['id']], true); ?> />
	
	<?php elseif($args['type'] == 'textarea'): ?>
		
		
		<textarea name="<?php echo $args['group'].'['.$args['id'].']'; ?>" type="<?php echo $args['type']; ?>" cols="" rows=""><?php echo isset($option_value[$args['id']])?stripslashes(esc_textarea($option_value[$args['id']]) ):''; ?></textarea>
	
	<?php endif; ?>
	
		<p class="description"><?php echo $args['desc'] ?></p>
		
<?php
}


