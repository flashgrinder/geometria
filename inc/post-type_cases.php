<?php

add_action('init', function () {
	register_post_type('cases', [
		'labels' => [
			'name' => 'Наши кейсы',
			'singular_name' => 'Кейс',
			'add_new' => 'Добавить кейс',
			'add_new_item' => 'Добавить кейс',
			'edit_item' => 'Редактировать кейс',
			'new_item' => 'Новый кейс',
			'view_item' => 'Открыть кейс',
			'search_items' => 'Искать кейсы',
			'not_found' => 'Кейсы не найдены',
			'not_found_in_trash' => 'В корзине кейсов нет',
			'all_items' => 'Все кейсы',
			'archives' => 'Архив кейсов',
			'attributes' => 'Параметры кейса',
			'insert_into_item' => 'Вставить в кейс',
			'uploaded_to_this_item' => 'Загружено для этого кейса',
			'featured_image' => 'Обложка кейса',
			'set_featured_image' => 'Задать обложку кейса',
			'remove_featured_image' => 'Удалить обложку кейса',
			'use_featured_image' => 'Использовать как обложку кейса',
			'menu_name' => 'Наши кейсы',
			'name_admin_bar' => 'Кейс',
		],
		'public' => true,
		'show_in_rest' => true,
		'menu_position' => 21,
		'menu_icon' => 'dashicons-portfolio',
		'has_archive' => true,
		'rewrite' => [
			'slug' => 'cases',
			'with_front' => false,
		],
		'supports' => ['title', 'thumbnail'],
		'taxonomies' => ['case_category'],
	]);
});
