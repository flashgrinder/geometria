<?php

	/* Подключение стилей и скриптов */
	add_action( 'wp_enqueue_scripts', function() {

		wp_enqueue_style( 'styles', get_stylesheet_directory_uri() . '/docs/style.css', [], time() );

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/docs/common.js', [], time(), true );

	} );

	add_action( 'after_setup_theme', function(){

		// Регистрируем главное меню
		register_nav_menu('header-menu', 'Меню в шапке');

		// Регистрируем меню в подвале
		register_nav_menu('footer-menu', 'Меню в подвале');

		// Смена логотипа
		add_theme_support('custom-logo');

		/* Добавляем возможность ставить постам миниатюры */
		add_theme_support('post-thumbnails');

		/* Тайтлы старницы ставятся автоматом */
		add_theme_support('title-tag');

		/* Включаем поддержку html5 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		/* Отключаем админбар */
		add_theme_support( 'admin-bar', ['callback' => '__return_false'] );

	});

	//Добавление "Цитаты" для страниц
	add_action('init', function() {
		add_post_type_support('page', array('excerpt'));
	});


//	add_action( 'wp_enqueue_scripts', 'ajax_posts_scripts' );
//
//	function ajax_posts_scripts() {
//		wp_register_script( 'true_ajax_posts', get_stylesheet_directory_uri() . '/inc/ajax-load-more-posts.js', ['jquery'], time(), true );
//
//		$data = [
//			'ajax_url' => admin_url( 'admin-ajax.php' )
//		];
//
//		wp_add_inline_script( 'true_ajax_posts', 'const blogUrl = ' . wp_json_encode( $data ), 'before' );
//
//		wp_enqueue_script( 'true_ajax_posts' );
//
//	}

	add_action( 'wp_head', function() {

		?>

		<?php
	});