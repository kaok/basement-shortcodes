<?php return array(
	'dummy' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Dummy',
		'title' => __( 'Dummy shortcode', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/dummy/dummy.php' )
	),
	'breakline' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Breakline',
		'title' => __( 'Break line', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/breakline/breakline.php' )
	),
	'nonbreakablespace' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Nonbreakablespace',
		'title' => __( 'Non-breakable space', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/nonbreakablespace/nonbreakablespace.php' )
	),
	'link' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Link',
		'title' => __( 'Link', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/link/link.php' )
	),
	'contactform7' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Contact_Form7',
		'title' => __( 'Contact form 7', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/contact/form7.php' )
	),
	'separator' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Separator',
		'title' => __( 'Separator', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/separator/separator.php' )
	),
	'button' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Button',
		'title' => __( 'Button', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/button/button.php' )
	),
	'taxonomy_name' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Taxonomy_Name',
		'title' => __( 'Taxonomy name', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/taxonomy/name.php' )
	),
	'author_name' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Author_Name',
		'title' => __( 'Author name', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/author/name.php' )
	),
	'search_request' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Search_Request',
		'title' => __( 'Search request', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/search/request.php' )
	),
	'image_featured' => array(
		'group' => 'default',
		'class' => 'Basement_Shortcode_Image_Featured',
		'title' => __( 'Featured image', BASEMENT_SHORTCODES_TEXTDOMAIN ),
		'path' => realpath( __DIR__ . '/../shortcodes/image/featured.php' )
	)
);