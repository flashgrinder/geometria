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
		'name'                     => 'Статьи',
		'singular_name'            => 'Статья',
		'add_new'                  => 'Добавить статью',
		'add_new_item'             => 'Добавить статью',
		'edit_item'                => 'Редактировать статью',
		'new_item'                 => 'Новая статья',
		'view_item'                => 'Просмотреть статью',
		'view_items'               => 'Просмотреть статьи',
		'search_items'             => 'Поиск статей',
		'not_found'                => 'Статьи не найдены.',
		'not_found_in_trash'       => 'Статьи в корзине не найдены.',
		'parent_item_colon'        => '',
		'all_items'                => 'Все статьи',
		'archives'                 => 'Архивы статей',
		'attributes'               => 'Атрибуты статьи',
		'insert_into_item'         => 'Вставить в статью',
		'uploaded_to_this_item'    => 'Загруженные для этой статьи',
		'featured_image'           => 'Миниатюра статьи',
		'set_featured_image'       => 'Установить миниатюру статьи',
		'remove_featured_image'    => 'Удалить миниатюру статьи',
		'use_featured_image'       => 'Использовать как миниатюру статьи',
		'filter_items_list'        => 'Фильтровать список статей',
		'filter_by_date'           => 'Фильтровать статьи по дате',
		'items_list_navigation'    => 'Навигация по списку статей',
		'items_list'               => 'Список статей',
		'item_published'           => 'Статья опубликована.',
		'item_published_privately' => 'Статья опубликована как личная.',
		'item_reverted_to_draft'   => 'Статья возвращена в черновики.',
		'item_scheduled'           => 'Публикация статьи запланирована.',
		'item_updated'             => 'Статья обновлена.',
		'item_link'                => 'Ссылка на статью',
		'item_link_description'    => 'Ссылка на статью.',
		'menu_name'                => 'Статьи',
		'name_admin_bar'           => 'Статья',
	];

	return (object) array_merge((array) $labels, $new);
});
