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

$default_steps = [
	[
		'number' => '1',
		'title' => "ПОГРУЖЕНИЕ\nИ ДИАГНОСТИКА",
		'time' => '3-7 дней',
		'is_active' => true,
	],
	[
		'number' => '2',
		'title' => "СТРАТЕГИЯ\nИ ПЛАН",
		'time' => '3-7 дней',
		'is_active' => false,
	],
	[
		'number' => '3',
		'title' => "КРЕАТИВ\nИ ПРОИЗВОДСТВО",
		'time' => '3-7 дней',
		'is_active' => false,
	],
	[
		'number' => '4',
		'title' => "ЗАПУСК\nИ ТЕСТИРОВАНИЕ",
		'time' => '3-7 дней',
		'is_active' => false,
	],
	[
		'number' => '5',
		'title' => "АНАЛИТИКА\nИ МАСШТАБИРОВАНИЕ",
		'time' => '3-7 дней',
		'is_active' => false,
	],
];

$process_heading = $get_acf_value('process_heading', "ПРОЦЕСС\nРАБОТЫ");
$process_steps = $default_steps;

if (function_exists('get_field')) {
	$rows = get_field('process_steps');

	if (is_array($rows) && $rows) {
		$process_steps = array_map(static function ($row, $index) use ($default_steps) {
			$default = $default_steps[$index] ?? [
				'number' => (string) ($index + 1),
				'title' => '',
				'time' => '',
				'is_active' => false,
			];

			return [
				'number' => !empty($row['number']) ? $row['number'] : $default['number'],
				'title' => !empty($row['title']) ? $row['title'] : $default['title'],
				'time' => !empty($row['time']) ? $row['time'] : $default['time'],
				'is_active' => isset($row['is_active']) ? (bool) $row['is_active'] : $default['is_active'],
			];
		}, $rows, array_keys($rows));
	}
}
?>

<section class="process">
	<div class="process__container container">
		<div class="process__head">
			<h2 class="process__heading title title--100 js-anime-title"><?php echo wp_kses_post($render_multiline($process_heading, true)); ?></h2>
		</div>

		<div class="process__timeline">
			<?php foreach ($process_steps as $step) : ?>
				<article class="process-step <?php echo $step['is_active'] ? 'is-active' : ''; ?>">
					<div class="process-step__top">
						<div class="process-step__number title"><?php echo esc_html($step['number']); ?></div>
					</div>
					<div class="process-step__line"></div>
					<div class="process-step__body">
						<h3 class="process-step__title title title--32"><?php echo wp_kses_post($render_multiline($step['title'])); ?></h3>
						<p class="process-step__time text"><?php echo esc_html($step['time']); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
