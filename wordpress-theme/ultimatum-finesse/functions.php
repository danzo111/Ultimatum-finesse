<?php
/**
 * Ultimatum Finesse theme setup.
 */

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
