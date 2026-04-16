<?php
$get_acf_value = static function ($field_name, $default = '') {
	if (!function_exists('get_field')) {
		return $default;
	}

	$value = get_field($field_name);

	return ($value !== null && $value !== '') ? $value : $default;
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

$default_items = [
	[
		'icon' => geometria_docs_asset('img/services/target.svg'),
		'title' => 'СТРАТЕГИЧЕСКИЙ МАРКЕТИНГ',
		'description' => 'Строим фундамент: аудит, позиционирование, воронки продаж.',
	],
	[
		'icon' => geometria_docs_asset('img/services/branding.svg'),
		'title' => 'БРЕНДИНГ',
		'description' => 'Создаём ДНК бренда: от логотипа до тона общения.',
	],
	[
		'icon' => geometria_docs_asset('img/services/company.svg'),
		'title' => 'РЕКЛАМНЫЕ КАМПАНИИ',
		'description' => 'Точные удары: креативы + медиаплан + запуск.',
	],
	[
		'icon' => geometria_docs_asset('img/services/communication.svg'),
		'title' => 'ЦИФРОВЫЕ КОММУНИКАЦИИ',
		'description' => 'Единая экосистема: сайт, e-mail, чат-боты.',
	],
	[
		'icon' => geometria_docs_asset('img/services/pr.svg'),
		'title' => 'PR И КОНТЕНТ-МАРКЕТИНГ',
		'description' => 'Репутация, которая работает: инфоповоды, статьи, лидеры мнений.',
	],
	[
		'icon' => geometria_docs_asset('img/services/smm.svg'),
		'title' => 'SMM',
		'description' => 'Живые соцсети: контент-план, визуал, вовлечение.',
	],
	[
		'icon' => geometria_docs_asset('img/services/videoprod.svg'),
		'title' => 'ВИДЕОПРОДАКШН',
		'description' => 'Видео, которое цепляет: от Reels до имиджевых роликов.',
	],
];

$services_heading = $get_acf_value('services_heading', "ЧТО МЫ\nУМЕЕМ");
$services_items = $default_items;

if (function_exists('get_field')) {
	$rows = get_field('services_items');

	if (is_array($rows) && $rows) {
		$services_items = array_map(static function ($row, $index) use ($default_items) {
			$default = $default_items[$index] ?? [
				'icon' => '',
				'title' => '',
				'description' => '',
			];

			$icon = $default['icon'];
			if (!empty($row['icon']['url'])) {
				$icon = $row['icon']['url'];
			}

			return [
				'icon' => $icon,
				'title' => !empty($row['title']) ? $row['title'] : $default['title'],
				'description' => !empty($row['description']) ? $row['description'] : $default['description'],
			];
		}, $rows, array_keys($rows));
	}
}
?>

<section class="services" id="services">
	<div class="services__top container">
		<h2 class="services__heading title title--100 js-anime-title"><?php echo wp_kses_post($render_multiline($services_heading, true)); ?></h2>
	</div>
	<div class="services__wrapper container--full">
		<div class="services__list">
			<?php foreach ($services_items as $index => $item) : ?>
				<div class="services__item js-services-item <?php echo 0 === $index ? 'is-active' : ''; ?>">
					<div class="services__icon-box">
						<img class="services__icon" src="<?php echo esc_url($item['icon']); ?>" alt="">
					</div>
					<h3 class="services__title title title--60"><?php echo esc_html($item['title']); ?></h3>
					<p class="services__description"><?php echo esc_html($item['description']); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
