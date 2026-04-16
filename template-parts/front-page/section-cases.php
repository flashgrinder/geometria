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

$build_case_card_from_post = static function ($post_id) {
	if (!$post_id || get_post_type($post_id) !== 'cases') {
		return null;
	}

	$terms = get_the_terms($post_id, 'case_category');
	$normalized_terms = [];

	if (is_array($terms)) {
		foreach ($terms as $term) {
			$term_link = get_term_link($term);

			if (is_wp_error($term_link)) {
				continue;
			}

			$normalized_terms[] = [
				'name' => $term->name,
				'link' => $term_link,
			];
		}
	}

	return [
		'title' => get_the_title($post_id),
		'content' => function_exists('get_field') ? (string) get_field('case_preview_content', $post_id) : '',
		'terms' => $normalized_terms,
		'link' => get_permalink($post_id),
		'image' => get_the_post_thumbnail_url($post_id, 'full') ?: geometria_docs_asset('img/cases/cases-img-1.webp'),
	];
};

$show_block = !function_exists('get_field') || (bool) get_field('cases_show_block');

if (!$show_block) {
	return;
}

$render_case_card = static function ($card) {
	if (!is_array($card)) {
		return;
	}

	$title = $card['title'] ?? '';
	$content = $card['content'] ?? '';
	$terms = $card['terms'] ?? [];
	$link = $card['link'] ?? '#';
	$image = $card['image'] ?? geometria_docs_asset('img/cases/cases-img-1.webp');
	?>
	<div class="cases__item cases__item--main">
		<div class="cases__item-wrap">
			<div class="cases__item-content">
				<a href="<?php echo esc_url($link); ?>" class="cases__item-title text text--24 text--light">
					<?php echo esc_html($title); ?>
					<span class="cases__item-arrow">&rarr;</span>
				</a>
				<?php if ($content) : ?>
					<div class="cases__item-text text text--light wysiwyg">
						<?php echo wp_kses_post((string) $content); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="cases__item-tags">
				<?php foreach ($terms as $term) : ?>
					<a href="<?php echo esc_url($term['link'] ?? '#'); ?>" class="cases__item-tag btn"><span><?php echo esc_html($term['name'] ?? ''); ?></span></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="cases__item-pic">
			<img class="cases__item-image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
		</div>
	</div>
	<?php
};

$heading = $get_acf_value('cases_heading', "РќР°С€Рё\nРєРµР№СЃС‹");
$selected_case_left = function_exists('get_field') ? (int) get_field('cases_selected_case_1') : 0;
$selected_case_right = function_exists('get_field') ? (int) get_field('cases_selected_case_2') : 0;
$stats_card = $get_acf_group('cases_stats_card');
$cta_card = $get_acf_group('cases_cta_card');
$left_card = $build_case_card_from_post($selected_case_left);
$right_card = $build_case_card_from_post($selected_case_right);

if (!$left_card && !$right_card) {
	return;
}

$stats_value = $stats_card['value'] ?? '>30';
$stats_text = $stats_card['text'] ?? 'СѓСЃРїРµС€РЅС‹С… РєРµР№СЃРѕРІ, РєРѕС‚РѕСЂС‹Рµ РїСЂРёРЅРµСЃР»Рё РєР»РёРµРЅС‚Р°Рј СЂРµР·СѓР»СЊС‚Р°С‚';
$stats_button_text = $stats_card['button_text'] ?? 'Р‘РћР›Р¬РЁР• РљР•Р™РЎРћР’';
$stats_button_link = $stats_card['button_link'] ?? (get_post_type_archive_link('cases') ?: '#');

$cta_title = $cta_card['title'] ?? "РҐРѕС‚РёС‚Рµ\nС‚Р°РєР¶Рµ?";
$cta_button_text = $cta_card['button_text'] ?? 'Р Р°СЃСЃС‡РёС‚Р°С‚СЊ РїСЂРѕРµРєС‚';
$cta_button_link = $cta_card['button_link'] ?? home_url('/#contact-form');
?>

<section class="cases cases--home" id="cases">
	<div class="cases__container container">
		<h2 class="cases__heading title title--100 js-anime-title"><?php echo wp_kses_post($render_multiline($heading, true)); ?></h2>

		<div class="cases__layout">
			<?php $render_case_card($left_card); ?>

			<div class="cases__item cases__item--stats">
				<div class="cases__item-wrap">
					<div class="cases__item-content">
						<h3 class="cases__item-title title title--100"><?php echo esc_html($stats_value); ?></h3>
						<p class="cases__item-text text text--light"><?php echo esc_html($stats_text); ?></p>
					</div>
					<a href="<?php echo esc_url($stats_button_link); ?>" class="cases__item-link-stats btn">
						<span class="cases__item-link-text"><?php echo esc_html($stats_button_text); ?></span>
						<span class="cases__item-link-arrow">
							<svg class="cases__link-svg-icon">
								<use xlink:href="#arrow-right"></use>
							</svg>
						</span>
					</a>
				</div>
			</div>

			<div class="cases__item cases__item--cta">
				<div class="cases__item-wrap">
					<div class="cases__item-content">
						<h3 class="cases__item-title title title--60"><?php echo wp_kses_post($render_multiline($cta_title)); ?></h3>
					</div>
					<a href="<?php echo esc_url($cta_button_link); ?>" class="cases__item-link-stats btn btn--second">
						<span class="cases__item-link-text"><?php echo esc_html($cta_button_text); ?></span>
					</a>
				</div>
			</div>

			<?php $render_case_card($right_card); ?>
		</div>
	</div>
</section>
