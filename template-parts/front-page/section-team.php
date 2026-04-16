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

$default_members = [
	[
		'image' => geometria_docs_asset('img/team/ppl-1.webp'),
		'name' => 'Юлия Агальцова',
		'role' => 'Директор OOO "Геометрия смыслов"',
		'description' => 'Маркетолог, стаж 17 лет в маркетинге, работа CMO в крупных российских и международных компаниях',
		'is_large' => true,
	],
	[
		'image' => geometria_docs_asset('img/team/ppl-2.webp'),
		'name' => 'Наталья Тен',
		'role' => '',
		'description' => 'Заместитель директора по связям с общественностью, режиссер, рилсмейкер',
		'is_large' => false,
	],
	[
		'image' => geometria_docs_asset('img/team/ppl-4.webp'),
		'name' => 'Ольга Деушева',
		'role' => '',
		'description' => 'Заместитель директора по контент-маркетингу, выпускающий редактор',
		'is_large' => false,
	],
	[
		'image' => geometria_docs_asset('img/team/ppl-3.webp'),
		'name' => 'Елизавета Сычева',
		'role' => '',
		'description' => 'Руководитель образовательных программ и проектов',
		'is_large' => false,
	],
	[
		'image' => geometria_docs_asset('img/team/ppl-6.webp'),
		'name' => 'Андрей Ковалев',
		'role' => '',
		'description' => 'Графический дизайнер',
		'is_large' => false,
	],
	[
		'image' => geometria_docs_asset('img/team/ppl-5.webp'),
		'name' => 'Ксения Климакова',
		'role' => '',
		'description' => 'СММ-специалист',
		'is_large' => false,
	],
];

$team_heading = $get_acf_value('team_heading', "Наша\nкоманда");
$team_members = $default_members;

if (function_exists('get_field')) {
	$rows = get_field('team_members');

	if (is_array($rows) && $rows) {
		$team_members = array_map(static function ($row, $index) use ($default_members) {
			$default = $default_members[$index] ?? [
				'image' => '',
				'name' => '',
				'role' => '',
				'description' => '',
				'is_large' => false,
			];

			return [
				'image' => !empty($row['image']['url']) ? $row['image']['url'] : $default['image'],
				'name' => !empty($row['name']) ? $row['name'] : $default['name'],
				'role' => !empty($row['role']) ? $row['role'] : $default['role'],
				'description' => !empty($row['description']) ? $row['description'] : $default['description'],
				'is_large' => isset($row['is_large']) ? (bool) $row['is_large'] : $default['is_large'],
			];
		}, $rows, array_keys($rows));
	}
}
?>

<section class="team" id="team">
	<div class="team__container container">
		<h2 class="team__heading title title--100 js-anime-title"><?php echo wp_kses_post($render_multiline($team_heading, true)); ?></h2>
		<div class="team__grid" id="teamGrid">
			<?php foreach ($team_members as $member) : ?>
				<article class="team-card <?php echo $member['is_large'] ? 'team-card--large' : ''; ?>">
					<img src="<?php echo esc_url($member['image']); ?>" class="team-card__image" alt="">
					<div class="team-card__content">
						<?php if ($member['role']) : ?>
							<div class="team-card__badge title"><?php echo esc_html($member['role']); ?></div>
						<?php endif; ?>
						<div class="team-card__text-line title title--32"><?php echo esc_html($member['name']); ?></div>
						<div class="team-card__text-line text text--light"><?php echo esc_html($member['description']); ?></div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
