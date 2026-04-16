<?php
	define('STANDART_DIR', get_stylesheet_directory_uri() . '/prod/');
	define('ROOT_DIR', get_stylesheet_directory_uri());
	define('GEOMETRIA_DOCS_DIR', get_stylesheet_directory_uri() . '/docs');

	/* Actions */
	include_once(__DIR__ . '/inc/actions.php');
	/* Filters */
	include_once(__DIR__ . '/inc/filters.php');
	// /* Post type - Experts */
	// include_once(__DIR__ . '/inc/post-type_experts.php');
	/* Post type - Cases */
	include_once(__DIR__ . '/inc/post-type_cases.php');
	/* Taxonomy - Case category */
	include_once(__DIR__ . '/inc/taxonomy-case_category.php');
	// /* Post type - Nominations-list */
	// include_once(__DIR__ . '/inc/post-type_nominations-list.php');
	// /* Taxonomies */
	// include_once(__DIR__ . '/inc/taxonomies.php');

	function geometria_docs_asset($path) {
		return trailingslashit(GEOMETRIA_DOCS_DIR) . ltrim($path, '/');
	}
