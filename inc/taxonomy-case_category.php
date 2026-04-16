<?php

add_action('init', function () {
	register_taxonomy('case_category', ['cases'], [
		'labels' => [
			'name' => 'Категории кейсов',
			'singular_name' => 'Категория кейса',
			'search_items' => 'Искать категории',
			'all_items' => 'Все категории',
			'parent_item' => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'edit_item' => 'Редактировать категорию',
			'update_item' => 'Обновить категорию',
			'add_new_item' => 'Добавить категорию',
			'new_item_name' => 'Новая категория',
			'menu_name' => 'Категории кейсов',
		],
		'public' => true,
		'hierarchical' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'rewrite' => [
			'slug' => 'cases/category',
			'with_front' => false,
			'hierarchical' => true,
		],
	]);
});
