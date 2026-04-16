<?php
$formFeedback = do_shortcode('[contact-form-7 id="d355a93" title="Форма обратной связи" html_class="form-section__form form js-form-1"]');

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

$heading = $get_acf_value('form_heading', "Начнём строить\nвашу геометрию?");
$subtitle = $get_acf_value('form_subtitle', 'Заполните заявку и мы ответим вам в ближайшее время!');
?>

<section class="form-section" id="contact-form">
	<div class="form-section__container container">
		<div class="form-section__top">
			<h3 class="form-section__heading title title--100 js-anime-title"><?php echo wp_kses_post($render_multiline($heading, true)); ?></h3>
			<p class="form-section__subtitle text text--light"><?php echo esc_html($subtitle); ?></p>
		</div>
		<div class="form-section__wrapper">
            <?php echo $formFeedback; ?>
		</div>
	</div>
</section>

<div class="modal modal--thanks hystmodal js-modal-success" id="thanks" aria-hidden="true">
	<div class="modal__wrap hystmodal__wrap">
		<div class="modal__body hystmodal__window" role="dialog" aria-modal="true">
			<button data-hystclose class="modal__close hystmodal__close">Close</button>
			<div class="modal__header">
				<div class="modal__title">
					<div class="modal__word-wrap">
						<div class="modal__word title title--100">Спасибо</div>
						<div class="modal__subtext text">Вы только что сделали шаг к росту бизнеса!</div>
					</div>
					<div class="modal__word modal__word--second title title--100">
						<span>Заявка отправлена</span>
					</div>
				</div>
				<div class="modal__subtitle modal__subtitle--first title title--32">Мы внимательно изучим вашу заявку и ответим в ближайшее время</div>
				<div class="modal__subtitle modal__subtitle--second title title--32">А пока вы ждете ответа, посмотрите наши кейсы</div>
			</div>
			<a href="" class="modal__thanks-btn btn btn--second">
				<span>Смотреть наши кейсы</span>
			</a>
		</div>
	</div>
</div>
