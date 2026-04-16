<?php
$theme_logo = function_exists('get_field') ? get_field('theme_logo', 'option') : [];
$theme_email = function_exists('get_field') ? get_field('theme_email', 'option') : '';
$theme_phone = function_exists('get_field') ? get_field('theme_phone', 'option') : '';
$theme_footer_cta_text = function_exists('get_field') ? get_field('theme_footer_cta_text', 'option') : '';
$theme_footer_cta_link = function_exists('get_field') ? get_field('theme_footer_cta_link', 'option') : '';
$theme_privacy_policy_url = function_exists('get_field') ? get_field('theme_privacy_policy_url', 'option') : '';
$theme_personal_data_policy_url = function_exists('get_field') ? get_field('theme_personal_data_policy_url', 'option') : '';
$theme_socials = function_exists('get_field') ? get_field('theme_socials', 'option') : [];
$theme_footer_requisites_link = function_exists('get_field') ? get_field('theme_footer_requisites_link', 'option') : [];
$theme_footer_copyright = function_exists('get_field') ? get_field('theme_footer_copyright', 'option') : '';

$footer_logo = !empty($theme_logo['url']) ? $theme_logo['url'] : geometria_docs_asset('img/logo.svg');
$theme_email = $theme_email ?: 'e-mail@mail.ru';
$theme_phone = $theme_phone ?: '+7 (999) 999-99-99';
$theme_phone_href = preg_replace('/[^0-9\+]/', '', $theme_phone);
$theme_footer_cta_text = $theme_footer_cta_text ?: 'Рассчитать проект';
$theme_footer_cta_link = $theme_footer_cta_link ?: home_url('/#contact-form');
$theme_privacy_policy_link = is_array($theme_privacy_policy_url) ? $theme_privacy_policy_url : [];
$theme_personal_data_policy_link = is_array($theme_personal_data_policy_url) ? $theme_personal_data_policy_url : [];
$theme_footer_requisites_link = is_array($theme_footer_requisites_link) ? $theme_footer_requisites_link : [];

$theme_privacy_policy_href = !empty($theme_privacy_policy_link['url']) ? $theme_privacy_policy_link['url'] : '#';
$theme_privacy_policy_title = !empty($theme_privacy_policy_link['title']) ? $theme_privacy_policy_link['title'] : 'Политика конфиденциальности';
$theme_personal_data_policy_href = !empty($theme_personal_data_policy_link['url']) ? $theme_personal_data_policy_link['url'] : '#';
$theme_personal_data_policy_title = !empty($theme_personal_data_policy_link['title']) ? $theme_personal_data_policy_link['title'] : 'Политика обработки персональных данных';
$theme_footer_requisites_href = !empty($theme_footer_requisites_link['url']) ? $theme_footer_requisites_link['url'] : '';
$theme_footer_requisites_title = !empty($theme_footer_requisites_link['title']) ? $theme_footer_requisites_link['title'] : 'Реквизиты';
$theme_footer_copyright = $theme_footer_copyright ?: 'Геометрия Смыслов ©{year}';
$theme_footer_copyright = str_replace('{year}', date('Y'), $theme_footer_copyright);

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

$footer_menu_fallback = static function () {
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

	echo '<ul class="footer__menu-list menu__list">';

	foreach ($items as $item) {
		printf(
			'<li class="footer__menu-item"><a class="footer__menu-link js-transition-link" href="%s">%s</a></li>',
			esc_url($item['url']),
			esc_html($item['label'])
		);
	}

	echo '</ul>';
};

$sprite_path = get_theme_file_path('src/templates/_sprite.svg');
$sprite_markup = file_exists($sprite_path) ? file_get_contents($sprite_path) : '';
?>

<?php if ($sprite_markup) : ?>
	<?php echo $sprite_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php endif; ?>

<footer class="footer">
	<div class="footer__body container">
		<div class="footer__wrap">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo">
				<img src="<?php echo esc_url($footer_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="footer__logo-img logo">
			</a>
			<nav class="footer__menu menu" aria-label="<?php esc_attr_e('Меню в подвале', 'geometria'); ?>">
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu',
					'container' => false,
					'menu_class' => 'footer__menu-list menu__list',
					'depth' => 1,
					'fallback_cb' => $footer_menu_fallback,
				]);
				?>
			</nav>
			<div class="footer__actions">
				<a href="<?php echo esc_url($theme_footer_cta_link); ?>" class="footer__btn btn">
					<span><?php echo esc_html($theme_footer_cta_text); ?></span>
				</a>
			</div>
		</div>
		<div class="footer__bottom">
			<div class="footer__col footer__col--first">
				<?php if ($theme_footer_requisites_href) : ?>
					<a href="<?php echo esc_url($theme_footer_requisites_href); ?>" class="footer__req text text--light">
						<?php echo esc_html($theme_footer_requisites_title); ?>
					</a>
				<?php else : ?>
					<div class="footer__req text text--light">
						<?php echo esc_html($theme_footer_requisites_title); ?>
					</div>
				<?php endif; ?>
				<div class="footer__copyright text text--light">
					<?php echo esc_html($theme_footer_copyright); ?>
				</div>
			</div>
			<div class="footer__col footer__col--center">
				<a href="<?php echo esc_url($theme_privacy_policy_href); ?>" class="footer__policy text text--light">
					<?php echo esc_html($theme_privacy_policy_title); ?>
				</a>
				<a href="<?php echo esc_url($theme_personal_data_policy_href); ?>" class="footer__policy text text--light">
					<?php echo esc_html($theme_personal_data_policy_title); ?>
				</a>
			</div>
			<div class="footer__col footer__col--last">
				<div class="footer__info">
					<div class="footer__socials">
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
					<div class="footer__contacts">
						<a href="mailto:<?php echo esc_attr($theme_email); ?>" class="footer__contact">
							<?php echo esc_html($theme_email); ?>
						</a>
						<a href="tel:<?php echo esc_attr($theme_phone_href); ?>" class="footer__contact">
							<?php echo esc_html($theme_phone); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
