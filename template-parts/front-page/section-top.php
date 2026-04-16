<?php
$formula_decor = geometria_docs_asset('img/formula-decor.webp');
$top_decor = geometria_docs_asset('img/top/top-decoration.webp');

$get_acf_value = static function ($field_name, $default = '') {
	if (!function_exists('get_field')) {
		return $default;
	}

	$value = get_field($field_name);

	return ($value !== null && $value !== '') ? $value : $default;
};

$subtitle = $get_acf_value('top_subtitle', 'Мы строим маркетинг, который работает как точная формула');
$term_1 = $get_acf_value('top_formula_term_1', 'СТРАТЕГИЯ');
$term_2 = $get_acf_value('top_formula_term_2', 'КРЕАТИВ');
$result = $get_acf_value('top_formula_result', 'РОСТ');
$button_text = $get_acf_value('top_button_text', 'РАССЧИТАТЬ ПРОЕКТ');

$get_acf_group = static function ($field_name) {
	if (!function_exists('get_field')) {
		return [];
	}

	$value = get_field($field_name);

	return is_array($value) ? $value : [];
};

$build_top_card = static function ($field_name, $default_title, $default_icon, $icon_class, $card_class = '') use ($get_acf_group) {
	$card = $get_acf_group($field_name);

	return [
		'icon' => !empty($card['icon']['url']) ? $card['icon']['url'] : $default_icon,
		'icon_class' => $icon_class,
		'title' => !empty($card['title']) ? $card['title'] : $default_title,
		'card_class' => $card_class,
	];
};

$top_cards = [
	$build_top_card('top_card_1', 'СТРАТЕГИЯ', geometria_docs_asset('img/top/icon-strategy.svg'), 'top__card-icon-placeholder--strategy'),
	$build_top_card('top_card_2', 'БРЕНДИНГ', geometria_docs_asset('img/top/icon-branding.svg'), 'top__card-icon-placeholder--branding'),
	$build_top_card('top_card_3', 'SMM', geometria_docs_asset('img/top/icon-smm.svg'), 'top__card-icon-placeholder--smm'),
	$build_top_card('top_card_4', 'PR', geometria_docs_asset('img/top/icon-pr.svg'), 'top__card-icon-placeholder--pr'),
	$build_top_card('top_card_5', 'ЗАПУСК РК', geometria_docs_asset('img/top/icon-rk.svg'), 'top__card-icon-placeholder--rk'),
	$build_top_card('top_card_6', 'GR', geometria_docs_asset('img/top/icon-gr.svg'), 'top__card-icon-placeholder--gr'),
	$build_top_card('top_card_7', 'ОРГАНИЗАЦИЯ<br>МЕРОПРИЯТИЙ', geometria_docs_asset('img/top/icon-events.svg'), 'top__card-icon-placeholder--events', 'top__card--large'),
];
?>

<section class="top">
	<div class="top__container container js-parallax-container">
		<div class="formula">
			<div class="formula__container">
				<div class="formula__decoration">
					<img class="formula__svg" src="<?php echo esc_url($formula_decor); ?>" alt="">
				</div>

				<div class="formula__content">
					<p class="formula__subtitle text js-animation-item top-animation-item" data-intensity="3"><?php echo esc_html($subtitle); ?></p>

					<div class="formula__equation js-animation-item top-animation-item" data-intensity="2">
						<div class="formula__row-wrap">
							<div class="formula__row formula__row--first">
								<span class="formula__term title title--100"><?php echo esc_html($term_1); ?></span>
								<span class="formula__term title title--100"><?php echo esc_html($term_2); ?></span>
							</div>
							<div class="formula__operator formula__operator--multiply">
								<span>×</span>
							</div>
						</div>

						<div class="formula__row formula__row--result js-animation-item top-animation-item" data-intensity="2">
							<div class="formula__operator formula__operator--equals">
								<span>=</span>
							</div>
							<div class="formula__wrap-result">
								<span class="formula__result title"><?php echo esc_html($result); ?></span>
								<a href="#contact-form" class="formula__btn formula__btn--desktop btn btn--second" type="button">
									<span class="btn__text"><?php echo esc_html($button_text); ?></span>
								</a>
							</div>
						</div>
						<a href="#contact-form" class="formula__btn formula__btn--mobile btn btn--second" type="button">
							<span class="btn__text"><?php echo esc_html($button_text); ?></span>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="top__grid">
			<?php foreach ($top_cards as $card) : ?>
				<div class="top__card <?php echo esc_attr($card['card_class'] ?? ''); ?>">
					<img src="<?php echo esc_url($card['icon']); ?>" class="top__card-icon-placeholder <?php echo esc_attr($card['icon_class']); ?>" alt="">
					<h3 class="top__card-title title title--32"><?php echo wp_kses_post($card['title']); ?></h3>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="top__decoration">
		<img src="<?php echo esc_url($top_decor); ?>" alt="">
	</div>
</section>
