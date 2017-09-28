<?php

/*
 * Add vue.js router to rest-easy data
 */
	function add_routes_to_json($jsonData){

        // Get the name of the category base. Default to "/categories"
        $category_base = '/' . get_option('category_base');

        // build out router table to be used with Vue
        $jsonData['routes'] = array(

            // Per-site
            // '/path'                              => 'VueComponent',
            // '/path/:var'                         => 'ComponentWithVar'
            // '/path/*/:var'                       => 'WildcardAndVar'
            // '/' . get_page_by_guid('your-guid')->post_name  => 'DefinedByGuid'
			'/' . get_page(5)->post_name            => 'Platform',
			'/' . get_page(6)->post_name            => 'Platform',
			'/' . get_page(7)->post_name            => 'Platform',
			'/' . get_page(8)->post_name            => 'Platform',

            // Probably unchanging
            ''                                      => 'FrontPage',
            '/' . $category_base                    => 'archive',
            '/:slug'                                => 'default'
        );

		return $jsonData;
	}
	add_filter('rez_build_all_data', 'add_routes_to_json');

	function add_page_siblings($related){

		$target = get_post($related['id']);
		$args = array(
			'posts_per_page'   	=> -1,
			'orderby'          	=> 'menu_order',
			'order'            	=> 'ASC',
			'exclude'			=> array( $target->ID ),
			'post_type'        	=> 'page',
			'post_parent'      	=> $target->post_parent
		);
		$siblings = get_posts($args);

		$related['siblings'] = array_map(
			function ($sibling) { return apply_filters('rez_serialize_object', $sibling); },
			$siblings
		);

		return $related;
	}
	add_filter('rez_gather_related', 'add_page_siblings');




/*
 * Require plugins
 */
	require_once get_template_directory() . '/core/class-tgm-plugin-activation.php';

	function vuepress_register_required_plugins() {

		$config = array(
			'id'           => 'vuepress',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		$plugins = array(
			array(
				'name'      => 'Rest-Easy',
				'slug'      => 'rest-easy',
				'source'    => 'https://github.com/funkhaus/Rest-Easy/archive/master.zip'
			),
			array(
				'name'      => 'Nested Pages',
				'slug'      => 'wp-nested-pages',
				'required'	=> false
			)
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'vuepress_register_required_plugins' );

/*
 * Setup WordPress
 */
	function custom_wordpress_setup() {

		// Enable tags for Pages (@see: https://wordpress.org/support/topic/enable-tags-screen-for-pages#post-29500520
		//register_taxonomy_for_object_type('post_tag', 'page');

	    // Enable excerpts for pages
	    add_post_type_support('page', 'excerpt');

	}
	add_action('init', 'custom_wordpress_setup');

/*
 * Setup theme
 */
	function custom_theme_setup() {

		// Enable post thumbnail support
		add_theme_support( 'post-thumbnails' );
		//set_post_thumbnail_size( 600, 400, true ); // Normal post thumbnails
		//add_image_size( 'banner-thumb', 566, 250, true ); // Small thumbnail size
	    add_image_size( 'social-preview', 600, 315, true ); // Square thumbnail used by sharethis and facebook

	    // Turn on menus
		add_theme_support('menus');

		// Enable HTML5 support
		add_theme_support('html5');

	}
	add_action( 'after_setup_theme', 'custom_theme_setup' );

/*
 * Enqueue Custom Scripts
 */
    function custom_scripts() {
		wp_register_script('bundle', get_template_directory_uri() . '/static/bundle.js', array(), custom_latest_timestamp());
		wp_enqueue_script('bundle', null, array(), false, true);
    }
    add_action('wp_enqueue_scripts', 'custom_scripts', 10);


/*
 * Generate timestamp based on latest edits.
 */
    function custom_latest_timestamp() {

		// set base, find top level assets of static dir
        $base =  get_template_directory();
		$assets = array_merge(glob($base . '/static/*.js'), glob($base . '/static/*.css'));

		// get m time of each asset
		$stamps = array_map(function($path){
			return filemtime($path);
		}, $assets);

		// if valid return time of latest change, otherwise current time
        return rsort($stamps) ? reset($stamps) : time();
    }


/*
 * Enqueue Custom Admin Scripts
 */
	function custom_admin_scripts() {
		//wp_register_script('site-admin', get_template_directory_uri() . '/static/js/admin.js', 'jquery', '1.0');
		//wp_enqueue_script('site-admin');
	}
	add_action( 'admin_enqueue_scripts', 'custom_admin_scripts' );

/*
 * Style login page and dashboard
 */
	// Style the login page
	function custom_loginpage_logo_link($url) {
	     // Return a url; in this case the homepage url of wordpress
	     return get_bloginfo('url');
	}
	function custom_loginpage_logo_title($message) {
	     // Return title text for the logo to replace 'wordpress'; in this case, the blog name.
	     return get_bloginfo('name');
	}
	function custom_loginpage_styles() {
        wp_enqueue_style( 'login_css', get_template_directory_uri() . '/static/css/login.css' );
	}
	function custom_admin_styles() {
        wp_enqueue_style('admin-stylesheet', get_template_directory_uri() . '/static/css/admin.css');
	}
	add_filter('login_headerurl','custom_loginpage_logo_link');
	add_filter('login_headertitle','custom_loginpage_logo_title');
	add_action('login_head','custom_loginpage_styles');
    add_action('admin_print_styles', 'custom_admin_styles');



/*
 * Add post thumbnail into RSS feed
 */
    function rss_post_thumbnail($content) {
        global $post;

        if( has_post_thumbnail($post->ID) ) {
            $content = '<p><a href='.get_permalink($post->ID).'>'.get_the_post_thumbnail($post->ID).'</a></p>'.$content;
        }

		return $content;
	}
	add_filter('the_excerpt_rss', 'rss_post_thumbnail');

/*
 * Custom conditional function. Used to get the parent and all it's child.
 */
    function is_tree($tree_id, $target_post = null) {

        // get full post object
        $target_post = get_post($target_post);

        // get all post ancestors
        $ancestors = get_ancestors($target_post->ID, $target_post->post_type);

        // if ID is target post OR in target post tree, return true
        return ( ($target_post->ID == $tree_id) or in_array($tree_id, $ancestors) );
    }

/*
 * Custom conditional function. Used to test if current page has children.
 */
    function has_children($target_post = null) {

        // get full post object
        $target_post = get_post($target_post);

        // Check if the post/page has a child
        $args = array(
        	'post_parent' 		=> $target_post->ID,
        	'post_type'			=> $target_post->post_type,
        	'posts_per_page'	=> 1
        );
        $children = get_posts($args);

        return !empty($children);
    }

/*
 * Allow subscriber to see Private posts/pages
 */
	function add_theme_caps() {
	    // Gets the author role
	    $role = get_role('subscriber');

	    // Add capabilities
	    $role->add_cap('read_private_posts');
		$role->add_cap('read_private_pages');
	}
	//add_action( 'switch_theme', 'add_theme_caps');

/*
 * Disable Rich Editor on certain pages
 */
	function disabled_rich_editor($allow_rich_editor) {
		global $post;

		if($post->post_name == 'contact') {
			return false;
		}
		return $allow_rich_editor;
	}
	//add_filter( 'user_can_richedit', 'disabled_rich_editor');


/*
 * Change the [...] that comes after excerpts
 */
    function custom_excerpt_ellipsis( $more ) {
        return '...';
    }
    //add_filter('excerpt_more', 'custom_excerpt_ellipsis');

/*
 * Allow SVG uploads
 */
    function add_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter('upload_mimes', 'add_mime_types');


/*
 * Enqueue Custom Gallery
 */
	function custom_gallery($atts) {
		if ( !is_admin() ) {
			include('parts/gallery.php');
		}
		return $output;
	}
	//add_shortcode('gallery', 'custom_gallery');

/*
 * Return the URL to a given attachment, while respecting size
 */
    function get_custom_attachment_url($attachment_id = false, $size = 'post-thumbnail') {
        if( !$attachment_id ) {
            global $post;
            $attachment_id = get_post_thumbnail_id($post->ID);
        }
        $attachment_data = wp_get_attachment_image_src( $attachment_id, $size);
        if( isset($attachment_data[0]) ) {
            return $attachment_data[0];
        }
        return '';
    }

/*
 * Return the URL to a given post's featured image, respecting size
 */
    function get_featured_image_url($target_post = null, $size = 'post-thumbnail') {
        $attachment_id = get_post_thumbnail_id($target_post);
        return get_custom_attachment_url($attachment_id, $size);
    }

/*
 * Add custom metabox to the new/edit page
 */
    function custom_add_metaboxes($post_type, $post){

		// add_meta_box('custom_media_meta', 'Media Meta', 'custom_media_meta', 'page', 'normal', 'low');
		// add_meta_box('custom_second_featured_image', 'Second Featured Image', 'custom_second_featured_image', 'page', 'side', 'low');

    }
	add_action('add_meta_boxes', 'custom_add_metaboxes', 10, 2);

	// Build media meta box
	function custom_media_meta($post) {

		?>
        	<div class="custom-meta">
				<label for="video-url">Enter the video URL for this page:</label>
				<input id="video-url" class="short" title="This is needed for all video pages" name="_custom_video_url" type="text" value="<?php echo $post->_custom_video_url; ?>">
				<br/>

        	</div>

		<?php
	}

    // Second featured image uploader (requires changes to admin.js too).
    // @see: https://codex.wordpress.org/Javascript_Reference/wp.media
    function custom_second_featured_image($post){

        // Meta key (need to update the save_metabox function below to reflect this too!)
        $meta_key = '_second_post_thumbnail';

        // Get WordPress' media upload URL
        $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

        // See if there's a media id already saved as post meta
        $image_id = get_post_meta( $post->ID, $meta_key, true );

        // Get the image src
        $image_src = wp_get_attachment_image_src( $image_id, 'post-thumbnail' );

        // For convenience, see if the array is valid
        $has_image = is_array( $image_src );

        ?>

            <div class="custom-meta custom-image-uploader">

                <!-- A hidden input to set and post the chosen image id -->
                <input class="custom-image-id" name="<?php echo $meta_key; ?>" type="hidden" value="<?php echo $image_id; ?>" />

                <!-- Image container, which is manipulated with js -->
                <div class="custom-image-container">
                    <?php if ( $has_image ) : ?>
                        <img src="<?php echo $image_src[0] ?>"/>
                    <?php endif; ?>
                </div>

                <!-- Add & remove image links -->
                <p class="hide-if-no-js">
                    <a class="upload-custom-image <?php if ( $has_image  ) { echo 'hidden'; } ?>" href="<?php echo $upload_link ?>">
                        <?php _e('Set second featured image') ?>
                    </a>
                    <a class="delete-custom-image <?php if ( ! $has_image  ) { echo 'hidden'; } ?>" href="#">
                        <?php _e('Remove image') ?>
                    </a>
                </p>

            </div>

        <?php
    }

/*
 * Get second post thumbnail (mimic functionality of get_the_post_thumbnail)
 */
    function get_the_second_post_thumbnail( $post = null, $size = 'post-thumbnail', $attr = '' ) {
        $post = get_post($post);
        $image = $post->_second_post_thumbnail;
        $classes = 'attachment-second-post-thumbnail size-full wp-second-post-image';
        if ( $attr == '' ) {
            // Create $attr array if none exists yet
            $attr = array('class' => $classes);
        } else if ( !empty($attr['class']) ){
            // Append to $attr['class'] if it exists
            $attr['class'] .= ' ' . $classes;
        } else if ( gettype($attr) == 'array' ) {
            // Append to $attr array if ['class'] doesn't exist yet
            $attr['class'] = $classes;
        }
        return wp_get_attachment_image( $image, $size, false, $attr );
    }


/*
 * Save the metabox vaule
 */
    function custom_save_metabox($post_id){

        // check autosave
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if( isset($_POST['_custom_video_url']) ) {
	        update_post_meta($post_id, '_custom_video_url', $_POST['_custom_video_url']);
        }
        if( isset($_POST['_second_post_thumbnail']) ) {
	        //update_post_meta($post_id, '_second_post_thumbnail', $_POST['_second_post_thumbnail']);
        }

    }
    add_action('save_post', 'custom_save_metabox');
