<?php
	define('STANDART_DIR', get_stylesheet_directory_uri() . '/prod/');
	define('ROOT_DIR', get_stylesheet_directory_uri());
	define('GEOMETRIA_DOCS_DIR', get_stylesheet_directory_uri() . '/docs');

	function geometria_get_post_reading_time($post_id = 0) {
		$post = get_post($post_id ?: get_the_ID());
		$content = $post instanceof WP_Post ? $post->post_content : '';
		$content = strip_shortcodes($content);
		$content = wp_strip_all_tags($content, true);
		$content = html_entity_decode($content, ENT_QUOTES, get_bloginfo('charset'));
		$word_count = preg_match_all('/[\p{L}\p{N}]+(?:[\'’\-][\p{L}\p{N}]+)*/u', $content, $matches);
		$minutes = max(1, (int) ceil((int) $word_count / 180));
		$last_two_digits = $minutes % 100;
		$last_digit = $minutes % 10;

		if ($last_two_digits >= 11 && $last_two_digits <= 14) {
			$unit = 'МИНУТ';
		} elseif ($last_digit === 1) {
			$unit = 'МИНУТА';
		} elseif ($last_digit >= 2 && $last_digit <= 4) {
			$unit = 'МИНУТЫ';
		} else {
			$unit = 'МИНУТ';
		}

		return sprintf('ВРЕМЯ ПРОЧТЕНИЯ: %d %s', $minutes, $unit);
	}

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
