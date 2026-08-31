<?php

/* Подключение стилей и скриптов */
add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('styles', get_stylesheet_directory_uri() . '/docs/style.css', [], time());

	wp_enqueue_script('jquery');
	wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/docs/common.js', [], time(), true);
});

add_action('after_setup_theme', function () {
	add_theme_support('menus');

	register_nav_menus([
		'header-menu' => 'Меню в шапке',
		'footer-menu' => 'Меню в подвале',
	]);

	add_theme_support('custom-logo');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	add_theme_support('html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	]);

	add_theme_support('admin-bar', ['callback' => '__return_false']);
});

add_action('pre_get_posts', function ($query) {
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	if ($query->is_home() || $query->is_category()) {
		$query->set('posts_per_page', 6 * geometria_get_articles_page());
		$query->set('ignore_sticky_posts', true);
	}

	if ($query->is_post_type_archive('cases') || $query->is_tax('case_category')) {
		$query->set('posts_per_page', 7);
	}
});

function geometria_get_articles_page() {
	if (!isset($_GET['page'])) {
		return 1;
	}

	$page = wp_unslash($_GET['page']);

	return is_scalar($page) ? max(1, absint($page)) : 1;
}

add_action('init', function () {
	if (!is_admin()) {
		return;
	}

	$rewrite_version = '2026-04-17-case-category-rewrite';

	if (get_option('geometria_rewrite_version') === $rewrite_version) {
		return;
	}

	flush_rewrite_rules(false);
	update_option('geometria_rewrite_version', $rewrite_version);
}, 20);

add_action('acf/init', function () {
	if (!function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page([
		'page_title' => 'Общие настройки темы',
		'menu_title' => 'Общие настройки темы',
		'menu_slug' => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect' => false,
		'position' => 61,
	]);
});

add_action('wp_enqueue_scripts', function () {
	wp_add_inline_script(
		'scripts',
		'window.geometriaData = ' . wp_json_encode([
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'casesPerPage' => 7,
			'casesNonce' => wp_create_nonce('geometria_cases_load_more'),
			'articlesPerPage' => 6,
			'articlesNonce' => wp_create_nonce('geometria_articles_load_more'),
		]) . ';',
		'before'
	);
}, 20);

// Добавление "Цитаты" для страниц
add_action('init', function () {
	add_post_type_support('page', ['excerpt']);
});

// add_action( 'wp_enqueue_scripts', 'ajax_posts_scripts' );
//
// function ajax_posts_scripts() {
// 	wp_register_script( 'true_ajax_posts', get_stylesheet_directory_uri() . '/inc/ajax-load-more-posts.js', ['jquery'], time(), true );
//
// 	$data = [
// 		'ajax_url' => admin_url( 'admin-ajax.php' )
// 	];
//
// 	wp_add_inline_script( 'true_ajax_posts', 'const blogUrl = ' . wp_json_encode( $data ), 'before' );
//
// 	wp_enqueue_script( 'true_ajax_posts' );
// }

add_action('wp_head', function () {
	?>

	<?php
});

add_action('wp_ajax_geometria_load_cases', 'geometria_load_cases');
add_action('wp_ajax_nopriv_geometria_load_cases', 'geometria_load_cases');

function geometria_load_cases() {
	check_ajax_referer('geometria_cases_load_more', 'nonce');

	$page = isset($_POST['page']) ? max(1, (int) $_POST['page']) : 1;
	$post_type = isset($_POST['post_type']) ? sanitize_key((string) $_POST['post_type']) : 'cases';
	$taxonomy = isset($_POST['taxonomy']) ? sanitize_key((string) $_POST['taxonomy']) : '';
	$term_id = isset($_POST['term_id']) ? (int) $_POST['term_id'] : 0;

	$args = [
		'post_type' => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => 7,
		'paged' => $page,
	];

	if ($taxonomy && $term_id) {
		$args['tax_query'] = [
			[
				'taxonomy' => $taxonomy,
				'field' => 'term_id',
				'terms' => $term_id,
			],
		];
	}

	$query = new WP_Query($args);

	ob_start();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/cases/card', null, ['post_id' => get_the_ID()]);
		}
	}

	wp_reset_postdata();

	wp_send_json_success([
		'html' => ob_get_clean(),
		'currentPage' => $page,
		'maxPages' => (int) $query->max_num_pages,
		'hasMore' => $page < (int) $query->max_num_pages,
	]);
}

add_action('wp_ajax_geometria_load_articles', 'geometria_load_articles');
add_action('wp_ajax_nopriv_geometria_load_articles', 'geometria_load_articles');

function geometria_load_articles() {
	check_ajax_referer('geometria_articles_load_more', 'nonce');

	$page_value = isset($_POST['page']) ? wp_unslash($_POST['page']) : 1;
	$category_value = isset($_POST['category_id']) ? wp_unslash($_POST['category_id']) : 0;
	$page = is_scalar($page_value) ? max(1, absint($page_value)) : 1;
	$category_id = is_scalar($category_value) ? absint($category_value) : 0;

	$args = [
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 6,
		'paged' => $page,
		'ignore_sticky_posts' => true,
	];

	if ($category_id) {
		$args['category__in'] = [$category_id];
	}

	$query = new WP_Query($args);

	ob_start();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/articles/card', null, ['post_id' => get_the_ID()]);
		}
	}

	wp_reset_postdata();

	wp_send_json_success([
		'html' => ob_get_clean(),
		'currentPage' => $page,
		'maxPages' => (int) $query->max_num_pages,
		'hasMore' => $page < (int) $query->max_num_pages,
	]);
}
