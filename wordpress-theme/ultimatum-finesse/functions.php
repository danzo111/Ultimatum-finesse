<?php
/**
 * Ultimatum Finesse theme setup.
 */

/**
 * Where the contact form delivers. Change this one line to reroute enquiries.
 */
define( 'UF_CONTACT_EMAIL', 'info@ultimatumfinesse.co.bw' );

function uf_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menu( 'primary', __( 'Primary Menu', 'ultimatum-finesse' ) );
}
add_action( 'after_setup_theme', 'uf_theme_setup' );

/**
 * Pages that need the Leaflet map (hero preview map, the full project map,
 * and the office location map on Contact). Checked with is_page_template()
 * plus is_front_page() so Leaflet never loads on pages that don't use it.
 */
function uf_page_uses_leaflet() {
	return is_front_page()
		|| is_page_template( 'page-projects.php' )
		|| is_page_template( 'page-contact.php' );
}

function uf_enqueue_assets() {
	wp_enqueue_style(
		'uf-style',
		get_template_directory_uri() . '/css/style-main.css',
		array(),
		filemtime( get_theme_file_path( 'css/style-main.css' ) )
	);

	wp_enqueue_script(
		'uf-main',
		get_template_directory_uri() . '/js/main.js',
		array(),
		filemtime( get_theme_file_path( 'js/main.js' ) ),
		true
	);

	// Contact form endpoint + REST nonce for the fetch() handler in main.js.
	wp_localize_script( 'uf-main', 'UF_CONTACT', array(
		'url'   => esc_url_raw( rest_url( 'uf/v1/contact' ) ),
		'nonce' => wp_create_nonce( 'wp_rest' ),
	) );

	if ( uf_page_uses_leaflet() ) {
		wp_enqueue_style(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
			array(),
			'1.9.4'
		);
		wp_enqueue_script(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
			array(),
			'1.9.4',
			true
		);
		wp_enqueue_script(
			'uf-map',
			get_template_directory_uri() . '/js/map.js',
			array( 'leaflet' ),
			filemtime( get_theme_file_path( 'js/map.js' ) ),
			true
		);

		// Project pin data lives in the theme as JSON (not the media library)
		// and map.js fetches it at runtime, so the URL has to come from PHP.
		wp_localize_script( 'uf-map', 'ufMapData', array(
			'projectsUrl' => get_template_directory_uri() . '/assets/data/projects.json',
		) );
	}

	// Animated 3D terrain backdrop -- homepage hero only.
	if ( is_front_page() ) {
		wp_enqueue_script(
			'uf-hero-terrain',
			get_template_directory_uri() . '/js/hero-terrain.js',
			array(),
			filemtime( get_theme_file_path( 'js/hero-terrain.js' ) ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'uf_enqueue_assets' );

/**
 * hero-terrain.js is an ES module (it imports Three.js from a CDN);
 * wp_enqueue_script() has no type="module" option before WP 6.5, so add
 * it via this filter instead of assuming a WP version.
 */
function uf_add_module_type( $tag, $handle ) {
	if ( 'uf-hero-terrain' === $handle ) {
		$tag = str_replace( ' src=', ' type="module" src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'uf_add_module_type', 10, 2 );

/**
 * The theme ships its own <title>/meta description handling per template
 * (add_theme_support('title-tag') covers <title>), but the original static
 * site also set a per-page meta description. Reproduce that here without a
 * dependency on an SEO plugin, in case one isn't installed.
 */
function uf_meta_description() {
	if ( is_front_page() ) {
		$desc = 'Ultimatum Finesse delivers GIS applications, aerial & mobile LiDAR, 3D laser scanning, BIM, photogrammetry and precision surveying across Botswana.';
	} elseif ( is_page( 'about' ) ) {
		$desc = "Over a decade of geospatial expertise in Botswana. Learn about Ultimatum Finesse's mission, values and milestones.";
	} elseif ( is_page( 'services' ) ) {
		$desc = 'GIS applications, aerial & mobile LiDAR, 3D laser scanning, BIM, aerial photography and surveying & mapping services from Ultimatum Finesse.';
	} elseif ( is_page( 'projects' ) ) {
		$desc = 'Explore Ultimatum Finesse project sites across Botswana on an interactive map, filterable by service discipline.';
	} elseif ( is_page( 'insights' ) ) {
		$desc = 'A curated reading list on GIS, LiDAR, 3D laser scanning, BIM and drone surveying, picked by Ultimatum Finesse.';
	} elseif ( is_page( 'contact' ) ) {
		$desc = 'Get in touch with Ultimatum Finesse for GIS, LiDAR, 3D scanning, BIM, photogrammetry and survey services in Botswana.';
	} else {
		return;
	}
	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
}
add_action( 'wp_head', 'uf_meta_description', 1 );

/**
 * Contact form delivery.
 *
 * The theme keeps its own custom contact form (no form plugin). The form POSTs
 * JSON to the uf/v1/contact REST route below, which verifies the WP REST nonce,
 * rejects honeypot hits, sanitises + validates the fields, and sends the message
 * with wp_mail().
 *
 * IMPORTANT: for reliable delivery on Bluehost, configure an SMTP plugin such as
 * "WP Mail SMTP". PHP's default mail() is frequently rejected or spam-filtered by
 * recipients; without SMTP the form still submits but messages may not arrive.
 */
function uf_register_contact_route() {
	register_rest_route( 'uf/v1', '/contact', array(
		'methods'             => 'POST',
		'callback'            => 'uf_handle_contact',
		'permission_callback' => '__return_true',
	) );
}
add_action( 'rest_api_init', 'uf_register_contact_route' );

function uf_handle_contact( WP_REST_Request $request ) {
	// 1. Verify the WP REST nonce (sent by main.js as the X-WP-Nonce header).
	$nonce = $request->get_header( 'X-WP-Nonce' );
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Your session expired. Please refresh the page and try again.' ), 403 );
	}

	$params = $request->get_json_params();
	if ( ! is_array( $params ) ) {
		$params = $request->get_params();
	}

	// 2. Honeypot: real users never fill the hidden company_url field. If it's
	//    set, silently pretend success so bots don't learn they were blocked.
	if ( ! empty( $params['company_url'] ) ) {
		return new WP_REST_Response( array( 'ok' => true, 'message' => 'Thank you. Your message has been sent.' ), 200 );
	}

	// 3. Light per-IP rate limit: max 5 submissions per 10 minutes.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'uf_contact_' . md5( $ip );
	$hits = (int) get_transient( $key );
	if ( $hits >= 5 ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Too many messages from this connection. Please try again in a few minutes.' ), 429 );
	}

	// 4. Sanitise every field.
	$name    = isset( $params['name'] )    ? sanitize_text_field( $params['name'] )        : '';
	$email   = isset( $params['email'] )   ? sanitize_email( $params['email'] )            : '';
	$phone   = isset( $params['phone'] )   ? sanitize_text_field( $params['phone'] )       : '';
	$service = isset( $params['service'] ) ? sanitize_text_field( $params['service'] )     : '';
	$message = isset( $params['message'] ) ? sanitize_textarea_field( $params['message'] ) : '';

	// 5. Validate.
	if ( '' === $name || '' === $message ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Please enter your name and a short message.' ), 400 );
	}
	if ( ! is_email( $email ) ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Please enter a valid email address so we can reply.' ), 400 );
	}

	// 6. Compose a plain-text email; Reply-To is the visitor so replies reach them.
	$subject = sprintf( '[Website enquiry] %s%s', $name, ( '' !== $service ? ' - ' . $service : '' ) );
	$body    = "New enquiry from the Ultimatum Finesse website\n\n"
		. 'Name:    ' . $name . "\n"
		. 'Email:   ' . $email . "\n"
		. 'Phone:   ' . ( '' !== $phone ? $phone : '(not provided)' ) . "\n"
		. 'Service: ' . ( '' !== $service ? $service : '(not specified)' ) . "\n\n"
		. "Message:\n" . $message . "\n";

	$domain = wp_parse_url( home_url(), PHP_URL_HOST );
	$domain = $domain ? preg_replace( '/^www\./', '', $domain ) : 'ultimatumfinesse.co.bw';
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: Ultimatum Finesse Website <no-reply@' . $domain . '>',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail( UF_CONTACT_EMAIL, $subject, $body, $headers );
	if ( ! $sent ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Sorry - the message could not be sent right now. Please email us directly at ' . UF_CONTACT_EMAIL . '.' ), 500 );
	}

	set_transient( $key, $hits + 1, 10 * MINUTE_IN_SECONDS );
	return new WP_REST_Response( array( 'ok' => true, 'message' => 'Thank you. Your message has been sent - we will be in touch shortly.' ), 200 );
}
