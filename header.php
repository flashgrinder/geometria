<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
	<script>
		(function () {
			document.documentElement.classList.add('js');

			try {
				if (!sessionStorage.getItem('geometria-preloader-shown')) {
					document.documentElement.classList.add('has-first-visit-preloader');
				}
			} catch (error) {
				document.documentElement.classList.add('has-first-visit-preloader');
			}
		})();
	</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class('is-page-loading'); ?>>
<?php wp_body_open(); ?>
<div class="site-preloader" aria-hidden="true">
	<div class="site-preloader__logo"></div>
</div>

<?php
$theme_logo = function_exists('get_field') ? get_field('theme_logo', 'option') : [];
$theme_email = function_exists('get_field') ? get_field('theme_email', 'option') : '';
$theme_phone = function_exists('get_field') ? get_field('theme_phone', 'option') : '';
$theme_header_cta_text = function_exists('get_field') ? get_field('theme_header_cta_text', 'option') : '';
$theme_header_cta_link = function_exists('get_field') ? get_field('theme_header_cta_link', 'option') : '';
$theme_socials = function_exists('get_field') ? get_field('theme_socials', 'option') : [];

$header_logo = !empty($theme_logo['url']) ? $theme_logo['url'] : geometria_docs_asset('img/logo.svg');
$theme_email = $theme_email ?: 'e-mail@mail.ru';
$theme_phone = $theme_phone ?: '+7 (999) 999-99-99';
$theme_phone_href = preg_replace('/[^0-9\+]/', '', $theme_phone);
$theme_header_cta_text = $theme_header_cta_text ?: 'Рассчитать проект';
$theme_header_cta_link = $theme_header_cta_link ?: home_url('/#contact-form');

$default_socials = [
	[
		'link' => [
			'url' => '#',
			'title' => 'VK',
		],
		'icon' => [
			'url' => geometria_docs_asset('img/vk.svg'),
		],
	],
	[
		'link' => [
			'url' => '#',
			'title' => 'Instagram',
		],
		'icon' => [
			'url' => geometria_docs_asset('img/insta.svg'),
		],
	],
	[
		'link' => [
			'url' => '#',
			'title' => 'Telegram',
		],
		'icon' => [
			'url' => geometria_docs_asset('img/tg.svg'),
		],
	],
];

$theme_socials = is_array($theme_socials) && $theme_socials ? $theme_socials : $default_socials;

$header_menu_fallback = static function () {
	$items = [
		[
			'label' => 'Услуги',
			'url' => home_url('/#services'),
		],
		[
			'label' => 'Кейсы',
			'url' => home_url('/#cases'),
		],
		[
			'label' => 'Команда',
			'url' => home_url('/#team'),
		],
		[
			'label' => 'Контакты',
			'url' => home_url('/#contact-form'),
		],
	];

	echo '<ul class="header__menu-list menu__list">';

	foreach ($items as $item) {
		printf(
			'<li class="menu__item header__menu-item"><a class="menu__link header__menu-link js-transition-link" href="%s">%s</a></li>',
			esc_url($item['url']),
			esc_html($item['label'])
		);
	}

	echo '</ul>';
};
?>

<header class="header js-mobile-main-menu">
	<div class="header__body container">
		<div class="header__inner">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
				<img src="<?php echo esc_url($header_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
			</a>
			<div class="header__wrap-menu">
				<nav class="header__menu menu" aria-label="<?php esc_attr_e('Основное меню', 'geometria'); ?>">
					<?php
					wp_nav_menu([
						'theme_location' => 'header-menu',
						'container' => false,
						'menu_class' => 'header__menu-list menu__list',
						'depth' => 1,
						'fallback_cb' => $header_menu_fallback,
					]);
					?>
				</nav>
				<a href="<?php echo esc_url($theme_header_cta_link); ?>" class="header__button-mobile btn">
					<span><?php echo esc_html($theme_header_cta_text); ?></span>
				</a>
				<div class="header__contacts">
					<a href="mailto:<?php echo esc_attr($theme_email); ?>" class="header__contact">
						<?php echo esc_html($theme_email); ?>
					</a>
					<a href="tel:<?php echo esc_attr($theme_phone_href); ?>" class="header__contact">
						<?php echo esc_html($theme_phone); ?>
					</a>
				</div>
				<div class="header__socials">
					<?php foreach ($theme_socials as $social) : ?>
						<?php
						$social_url = !empty($social['link']['url']) ? $social['link']['url'] : '#';
						$social_title = !empty($social['link']['title']) ? $social['link']['title'] : '';
						$social_icon = !empty($social['icon']['url']) ? $social['icon']['url'] : '';
						if (!$social_icon) {
							continue;
						}
						?>
						<a href="<?php echo esc_url($social_url); ?>" class="social" aria-label="<?php echo esc_attr($social_title); ?>">
							<img src="<?php echo esc_url($social_icon); ?>" alt="" class="social__icon">
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<a href="<?php echo esc_url($theme_header_cta_link); ?>" class="header__button-desktop btn btn">
				<span><?php echo esc_html($theme_header_cta_text); ?></span>
			</a>
			<button class="mobile-nav-btn burger js-mobile-nav-burger" type="button" aria-label="<?php esc_attr_e('Открыть меню', 'geometria'); ?>">
				<span class="nav-icon burger__icon"></span>
			</button>
		</div>
	</div>
</header>
