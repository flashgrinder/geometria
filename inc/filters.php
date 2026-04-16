<?php

/* Убираем тег <p></p> у отрывков */
remove_filter('the_excerpt', 'wpautop');

add_filter('wpcf7_autop_or_not', '__return_false');

// Длина отрывков постов
add_filter('excerpt_length', function ($number) {
	return 30;
});

// Окончание отрывков постов
add_filter('excerpt_more', function ($more_string) {
	return '...';
});

add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
	if (empty($args->theme_location)) {
		return $classes;
	}

	if ($args->theme_location === 'header-menu') {
		$classes[] = 'menu__item';
		$classes[] = 'header__menu-item';
	}

	if ($args->theme_location === 'footer-menu') {
		$classes[] = 'footer__menu-item';
	}

	if (in_array('current-menu-item', $classes, true) || in_array('current-menu-ancestor', $classes, true)) {
		$classes[] = 'is-active';
	}

	return array_values(array_unique($classes));
}, 10, 4);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
	if (empty($args->theme_location)) {
		return $atts;
	}

	$classes = [];

	if (!empty($atts['class'])) {
		$classes[] = $atts['class'];
	}

	if ($args->theme_location === 'header-menu') {
		$classes[] = 'menu__link';
		$classes[] = 'header__menu-link';
		$classes[] = 'js-transition-link';
	}

	if ($args->theme_location === 'footer-menu') {
		$classes[] = 'footer__menu-link';
		$classes[] = 'js-transition-link';
	}

	if ($classes) {
		$atts['class'] = implode(' ', array_unique($classes));
	}

	return $atts;
}, 10, 3);

add_filter('nav_menu_submenu_css_class', function ($classes, $args, $depth) {
	if (!empty($args->theme_location) && $args->theme_location === 'header-menu') {
		$classes[] = 'menu__sub-menu';
	}

	return array_values(array_unique($classes));
}, 10, 3);

// Изменить название Записи
add_filter('post_type_labels_post', function ($labels) {
	$new = [
		'name'                  => 'Новости',
		'singular_name'         => 'Новость',
		'add_new'               => 'Добавить новость',
		'add_new_item'          => 'Добавить новость',
		'edit_item'             => 'Редактировать новость',
		'new_item'              => 'Новая новость',
		'view_item'             => 'Просмотреть новость',
		'search_items'          => 'Поиск новостей',
		'not_found'             => 'Новости не найдены.',
		'not_found_in_trash'    => 'Новости в корзине не найдены.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все новости',
		'archives'              => 'Архивы новостей',
		'insert_into_item'      => 'Вставить в новость',
		'uploaded_to_this_item' => 'Загруженные для этой новости',
		'featured_image'        => 'Миниатюра новости',
		'filter_items_list'     => 'Фильтровать список новостей',
		'items_list_navigation' => 'Навигация по списку новостей',
		'items_list'            => 'Список новостей',
		'menu_name'             => 'Новости',
		'name_admin_bar'        => 'Новость',
	];

	return (object) array_merge((array) $labels, $new);
});
