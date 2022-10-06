<?php 

function ll_add_general_setting_page() {
	add_menu_page( 
		$page_title = 'E-learning manager setting', 
		$menu_title = 'E-learning file manager',
		$capability = 'manage_options',
		$menu_slug = 'e-learing-manager-setting',
		$function = 'll_create_general_setting_page',
		$icon_url = 'dashicons-admin-generic', 
		$position = 81 
	);
	/* 1. Vytvoření podstránky v menu */
	add_submenu_page( 
		$parent_slug = "e-learing-manager-setting",
		$page_title = "E-learning manager setting", 
		$menu_title = "General", 
		$capability = "manage_options", 
		$menu_slug = "e-learing-manager-setting", 
		$function = 'll_create_general_setting_page' 
	);

	add_submenu_page(
		$parent_slug = "e-learing-manager-setting",
		$page_title = "E-learning manager color setting", 
		$menu_title = "Colors", 
		$capability = "manage_options", 
		$menu_slug = "e-learing-manager-color-setting", 
		$function = 'll_create_colors_setting_page' 
	);

	add_submenu_page(
		$parent_slug = "e-learing-manager-setting",
		$page_title = "E-learning manager reCaptcha integration", 
		$menu_title = "reCaptcha integration", 
		$capability = "manage_options", 
		$menu_slug = "e-learing-manager-recaptcha-integration", 
		$function = 'll_create_recaptha_integration_page' 
	);

	/* Vytvoření nastavení */
	add_action('admin_init', 'll_manager_custom_setting');
}
add_action('admin_menu', 'll_add_general_setting_page');

/* Vytvoření nastavení 
	1. add_action
	2. funkce pro registristraci - register setting
	3. vytvoření sekce - v sekci jsou nastavení, které se týkají společného prvku
	4. funkce pro vygenerování políček do sekce - ll_create_main_page_options_page
	5. funkce pro vytvoření políčka - ll_material_page_field
*/
function ll_manager_custom_setting() {
	/* Hlavní nastevení */
	register_setting( 
		$option_group = "ll-general-setting-group", //skupina nastavení
		$option_name = "ll_main_page_id" //jednotlivé nastavení
	);

	add_settings_section( 
		$id = "ll-main-page-options",
		$title = "Main page for showing materials", 
		$callback = "ll_create_main_page_options_section", 
		$page = "e-learing-manager-setting"
	);

	add_settings_field( 
		$id = 'material-page',
	 	$title = 'Page with materials', 
	 	$callback = 'll_material_page_field',
	 	$page = "e-learing-manager-setting", 
	 	$section = 'll-main-page-options'
	);

	register_setting( 
		$option_group = "ll-general-setting-group", //skupina nastavení
		$option_name = "ll_is_top_materials_allow" //jednotlivé nastavení
	);

	register_setting( 
		$option_group = "ll-general-setting-group", //skupina nastavení
		$option_name = "ll_is_newest_materials_allow" //jednotlivé nastavení
	);

	register_setting( 
		$option_group = "ll-general-setting-group", //skupina nastavení
		$option_name = "ll_top_materials_count" //jednotlivé nastavení
	);

	register_setting( 
		$option_group = "ll-general-setting-group", //skupina nastavení
		$option_name = "ll_new_materials_count" //jednotlivé nastavení
	);

	add_settings_section( 
		$id = "ll-top-new-materials-allow-options",
		$title = "Showing top and new materials", 
		$callback = "ll_create_top_new_materials_allow_options_section", 
		$page = "e-learing-manager-setting"
	);

	add_settings_field( 
		$id = 'allow-top-materials',
	 	$title = 'Show "Top materials" on page with materials?', 
	 	$callback = 'll_top_materials_allow_field',
	 	$page = "e-learing-manager-setting", 
	 	$section = 'll-top-new-materials-allow-options'
	);

	add_settings_field( 
		$id = 'top-count',
	 	$title = 'Number of top materials: ', 
	 	$callback = 'll_top_materials_count',
	 	$page = "e-learing-manager-setting", 
	 	$section = 'll-top-new-materials-allow-options'
	);

	add_settings_field( 
		$id = 'allow-new-materials',
	 	$title = 'Show "Newest materials" on page with materials?', 
	 	$callback = 'll_new_materials_allow_field',
	 	$page = "e-learing-manager-setting", 
	 	$section = 'll-top-new-materials-allow-options'
	);

	add_settings_field( 
		$id = 'new-count',
	 	$title = 'Number of new materials: ', 
	 	$callback = 'll_new_materials_count',
	 	$page = "e-learing-manager-setting", 
	 	$section = 'll-top-new-materials-allow-options'
	);
	/* // HLavní nastavení */

	/* Nastavení barev */
	register_setting( 
		$option_group = "ll-color-setting-group", 
		$option_name = "ll_primary_color"
	);

	register_setting( 
		$option_group = "ll-color-setting-group", 
		$option_name = "ll_secondary_color"
	);

	add_settings_section( 
		$id = "ll-primary-color-options", 
		$title = "",
		$callback = "ll_primary_color_section",
		$page = "e-learing-manager-color-setting"
	);

	add_settings_field( 
		$id = "primary-color", 
		$title = "Primary color: ", 
		$callback = "ll_primary_color_field", 
		$page = "e-learing-manager-color-setting", 
		$section = 'll-primary-color-options'
	);

	add_settings_field( 
		$id = "secondary-color", 
		$title = "Secondary color: ", 
		$callback = "ll_secondary_color_field", 
		$page = "e-learing-manager-color-setting", 
		$section = 'll-primary-color-options'
	);

	register_setting( 
		$option_group = "ll-recaptcha-setting-group", 
		$option_name = "ll_recaptcha_allow"
	);

	register_setting( 
		$option_group = "ll-recaptcha-setting-group", 
		$option_name = "ll_recaptcha_sitekey"
	);

	register_setting( 
		$option_group = "ll-recaptcha-setting-group", 
		$option_name = "ll_recaptcha_secretkey"
	);

	add_settings_section( 
		$id = "ll-recapthca-integration-options", 
		$title = "",
		$callback = "ll_recaptcha_integration_options_section",
		$page = "e-learing-manager-recaptcha-integration"
	);

	add_settings_field( 
		$id = "recaptcha-allow", 
		$title = "Allow reCaptcha in comments: ", 
		$callback = "ll_recaptcha_allow_field", 
		$page = "e-learing-manager-recaptcha-integration", 
		$section = 'll-recapthca-integration-options'
	);

	add_settings_field( 
		$id = "recaptcha-sitekey", 
		$title = "reCaptcha Site Key: ", 
		$callback = "ll_recaptcha_sitekey_field", 
		$page = "e-learing-manager-recaptcha-integration", 
		$section = 'll-recapthca-integration-options'
	);

	add_settings_field( 
		$id = "recaptcha-secretkey", 
		$title = "reCaptcha Secret Key: ", 
		$callback = "ll_recaptcha_secretkey_field", 
		$page = "e-learing-manager-recaptcha-integration", 
		$section = 'll-recapthca-integration-options'
	);
}

function ll_recaptcha_integration_options_section() {
}

function ll_create_main_page_options_section() {
}

function ll_create_top_new_materials_allow_options_section() {
	echo 'Settings for showing top a new materials on main page with materials.';
}

function ll_material_page_field() {
	$args = array(
		'sort_order' => 'asc',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	); 
	$pages = get_pages($args); 
	$main_page_ID = esc_attr(get_option('ll_main_page_id'));
	echo '<select name="ll_main_page_id" required="required">';
		if ($main_page_ID == '00') {
			echo '<option value="00" selected>Default</option>';
		}else {
			echo '<option value="00">Default</option>';
		}
		
		foreach ($pages as $page) {
			if ($page->ID == $main_page_ID) {
				echo '<option value="'.$page->ID.'" selected>'.$page->post_title.'</option>';
			}else {
				echo '<option value="'.$page->ID.'">'.$page->post_title.'</option>';
			}			
		}
	echo '</select>';
	echo '<p class="description">';
		echo 'If "Default" option is selected materials will be show on the following 
		<a href="'.get_post_type_archive_link( $post_type = 'materials' ).'" target="_blank">link</a>.';
	echo '</p>';
}

function ll_top_materials_allow_field() {
	if (get_option('ll_is_top_materials_allow')) {
		echo '<p><label for="allow-top-yes"><input type="radio" id="allow-top-yes" name="ll_is_top_materials_allow" value="1" checked>Yes</label></p>';
		echo '<p><label for="allow-top-no"><input type="radio" id="allow-top-no" name="ll_is_top_materials_allow" value="0">No</label></p>';
	}else {
		echo '<p><label for="allow-top-yes"><input type="radio" id="allow-top-yes" name="ll_is_top_materials_allow" value="1">Yes</label></p>';
		echo '<p><label for="allow-top-no"><input type="radio" id="allow-top-no" name="ll_is_top_materials_allow" value="0" checked>No</label></p>';
	}
}

function ll_top_materials_count() {
	if (get_option('ll_is_top_materials_allow')) {
	echo '<p><input type="number" name="ll_top_materials_count" value="'.get_option('ll_top_materials_count','5').'" class="small-text"> materials</p>';
	}else {
		echo '<p><input type="number" name="ll_top_materials_count" value="'.get_option('ll_top_materials_count','5').'" class="small-text" disabled> materials</p>';
	}
}

function ll_recaptcha_allow_field() {
	if (get_option('ll_recaptcha_allow')) {
		echo '<p><label for="allow-recaptcha-yes"><input type="radio" id="allow-recaptcha-yes" name="ll_recaptcha_allow" value="1" checked>Yes</label></p>';
		echo '<p class="description">You must fill all keys, before you start using google <a href="https://developers.google.com/recaptcha/" target="_blank">reCaptcha</a>.</p>';
		echo '<p><label for="allow-recaptcha-no"><input type="radio" id="allow-recaptcha-no" name="ll_recaptcha_allow" value="0">No</label></p>';
	}else {
		echo '<p><label for="allow-recaptcha-yes"><input type="radio" id="allow-recaptcha-yes" name="ll_recaptcha_allow" value="1">Yes</label></p>';
		echo '<p><label for="allow-recaptcha-no"><input type="radio" id="allow-recaptcha-no" name="ll_recaptcha_allow" value="0" checked>No</label></p>';
	}
}

function ll_recaptcha_sitekey_field() {
	echo '<input type="text" name="ll_recaptcha_sitekey" value="'.get_option('ll_recaptcha_sitekey','').'" />';
	echo '<p class="description">Fill site key.</p>';	
}

function ll_recaptcha_secretkey_field() {	
	echo '<input type="text" name="ll_recaptcha_secretkey" value="'.get_option('ll_recaptcha_secretkey','').'" />';
	echo '<p class="description">Fill secret key.</p>';	
}

function ll_new_materials_allow_field() {
	if (get_option('ll_is_newest_materials_allow')) {
		echo '<p><label for="allow-new-yes"><input type="radio" id="allow-new-yes" name="ll_is_newest_materials_allow" value="1" checked>Yes</label></p>';
		echo '<p><label for="allow-new-no"><input type="radio" id="allow-new-no" name="ll_is_newest_materials_allow" value="0">No</label></p>';
	}else {
		echo '<p><label for="allow-new-yes"><input type="radio" id="allow-new-yes" name="ll_is_newest_materials_allow" value="1">Yes</label></p>';
		echo '<p><label for="allow-new-no"><input type="radio" id="allow-new-no" name="ll_is_newest_materials_allow" value="0" checked>No</label></p>';
	}
}

function ll_new_materials_count() {
	if (get_option('ll_is_newest_materials_allow')) {
		echo '<p><input type="number" name="ll_new_materials_count" value="'.get_option('ll_new_materials_count','5').'" class="small-text"> materials</p>';
	}else {
		echo '<p><input type="number" name="ll_new_materials_count" value="'.get_option('ll_new_materials_count','5').'" class="small-text" disabled> materials</p>';
	}
	
}

function ll_primary_color_section() {}

function ll_primary_color_field() {
	echo '<input type="text" name="ll_primary_color" value="'.get_option('ll_primary_color','#01579b').'" class="ll-color-picker-class" />';
	echo '<p class="description">This color will be use for icons, buttons and links.</p>';
}

function ll_secondary_color_field() {
	echo '<input type="text" name="ll_secondary_color" value="'.get_option('ll_secondary_color','#4f83cc').'" class="ll-color-picker-class" />';
	echo '<p class="description">This color will be use primary for hover effects.</p>';
}

/*  ŠABLONA HLAVNÍ STRÁNKY NASTAVENÍ */
function ll_create_general_setting_page() {
	echo '<h1>E-learning manager general setting</h1>';
	settings_errors();
	echo '<form method="post" action="options.php">';
		settings_fields( $option_group = "ll-general-setting-group" );
		do_settings_sections( $page = "e-learing-manager-setting");	

		submit_button( 
			$text = 'Save', 
			$type = 'primary', 
			$name = 'submit', 
			$wrap = true, 
			$other_attributes = null 
		);
	echo '</form>';
}
/*==========*/

/* Šablona stránky s nastavením barev */
function ll_create_colors_setting_page() {
	echo '<h1>E-learning manager colors setting</h1>';

	settings_errors();
	echo '<form method="post" action="options.php">';
		settings_fields($option_group = "ll-color-setting-group");
		do_settings_sections( $page = 'e-learing-manager-color-setting' );

		submit_button( 
			$text = 'Save', 
			$type = 'primary', 
			$name = 'submit', 
			$wrap = true, 
			$other_attributes = null 
		);
	echo '</form>';
}

/* Šablona stránky s nastavením rechapchi */
function ll_create_recaptha_integration_page() {
	echo '<h1>E-learning manager reCaptcha integration setting</h1>';

	settings_errors();
	echo '<form method="post" action="options.php">';
		settings_fields($option_group = "ll-recaptcha-setting-group");
		do_settings_sections( $page = 'e-learing-manager-recaptcha-integration' );

		submit_button( 
			$text = 'Save', 
			$type = 'primary', 
			$name = 'submit', 
			$wrap = true, 
			$other_attributes = null 
		);
	echo '</form>';	
}
?>