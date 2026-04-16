<?php
$get_acf_value = static function ($field_name, $default = '') {
	if (!function_exists('get_field')) {
		return $default;
	}

	$value = get_field($field_name);

	return ($value !== null && $value !== '') ? $value : $default;
};

$get_acf_group = static function ($field_name) {
	if (!function_exists('get_field')) {
		return [];
	}

	$value = get_field($field_name);

	return is_array($value) ? $value : [];
};

$render_multiline = static function ($text, $highlight_last = false) {
	$lines = preg_split('/\r\n|\r|\n/', (string) $text);
	$lines = array_values(array_filter(array_map('trim', $lines), static fn ($line) => $line !== ''));

	if (!$lines) {
		return '';
	}

	$parts = [];
	$last_index = count($lines) - 1;

	foreach ($lines as $index => $line) {
		$escaped = esc_html($line);

		if ($highlight_last && $index === $last_index) {
			$escaped = '<span>' . $escaped . '</span>';
		}

		$parts[] = $escaped;
	}

	return implode(' <br> ', $parts);
};

$hero_heading = $get_acf_value('hero_heading', "Когда маркетинг\n— это хаос");
$hero_left = $get_acf_group('hero_left_group');
$hero_right = $get_acf_group('hero_right_group');

$hero_left_title = $hero_left['title'] ?? 'ШУМ В КАНАЛАХ';
$hero_left_item_1 = $hero_left['item_1'] ?? 'БЮДЖЕТЫ УТЕКАЮТ';
$hero_left_item_2 = $hero_left['item_2'] ?? 'НЕТ СИСТЕМЫ';

$hero_right_title = $hero_right['title'] ?? "МЫ ПРИВОДИМ ВСЁ К\nПОРЯДКУ";
$hero_formula_left = $hero_right['formula_left'] ?? "ЧЁТКАЯ\nСТРАТЕГИЯ";
$hero_formula_right = $hero_right['formula_right'] ?? "СИЛЬНЫЙ\nКРЕАТИВ";
$hero_formula_result = $hero_right['formula_result'] ?? 'ПОНЯТНЫЕ РЕЗУЛЬТАТЫ';
?>

<section class="hero">
	<div class="hero__top container">
		<h2 class="hero__heading title title--100 js-anime-title"><?php echo wp_kses_post($render_multiline($hero_heading, true)); ?></h2>
	</div>
	<div class="hero__scene">
		<div class="hearo__outer hero__sticky">
			<div class="hero__container">
				<div class="hero__left hero-side hero-side--dark">
					<ul class="hero__problems hero-side__list">
						<li class="hero__title hero-side__title hero-side__title--blurred title">
							<?php echo esc_html($hero_left_title); ?>
						</li>
						<li class="hero__problem-item hero-side__item">
							<span class="hero__problem-text hero-side__text title title--40"><?php echo esc_html($hero_left_item_1); ?></span>
						</li>
						<li class="hero__problem-item hero-side__item">
							<span class="hero__problem-text hero-side__text title title--40"><?php echo esc_html($hero_left_item_2); ?></span>
						</li>
					</ul>
				</div>

				<div class="hero__right hero-side hero-side--light">
					<h3 class="hero__title hero-side__title title title--60">
						<?php echo wp_kses_post($render_multiline($hero_right_title, true)); ?>
					</h3>

					<div class="hero__formula formula">
						<div class="hero__formula-row formula__row--top">
							<div class="hero__formula-item hero__formula-item--left">
								<span class="hero__formula-text title"><?php echo wp_kses_post($render_multiline($hero_formula_left)); ?></span>
							</div>
							<div class="hero__formula-operator hero__formula-operator--plus">
								<span class="hero__formula-symbol">×</span>
							</div>
							<div class="hero__formula-item hero__formula-item--right">
								<span class="hero__formula-text title"><?php echo wp_kses_post($render_multiline($hero_formula_right)); ?></span>
							</div>
						</div>

						<div class="hero__formula-equals">
							<span class="hero__formula-equals-sign">=</span>
						</div>
						<div class="hero__formula-result">
							<span class="hero__formula-result-text title"><?php echo wp_kses_post($render_multiline($hero_formula_result)); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
