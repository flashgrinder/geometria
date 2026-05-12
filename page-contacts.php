<?php
/*
Template Name: Контакты
*/
?>
<?php get_header(); ?>

<?php
$formFeedbackContacts = do_shortcode('[contact-form-7 id="d355a93" title="Форма обратной связи" html_class="contacts__form form form--white js-form-1"]');


$get_field_value = static function ($field_name, $default = '', $post_id = false) {
	if (!function_exists('get_field')) {
		return $default;
	}

	$value = get_field($field_name, $post_id);

	return ($value !== null && $value !== '') ? $value : $default;
};

$render_heading_lines = static function ($text) {
	$lines = preg_split('/\r\n|\r|\n/', (string) $text);
	$lines = array_values(array_filter(array_map('trim', $lines), static fn ($line) => $line !== ''));

	if (!$lines) {
		return '';
	}

	$output = [];

	foreach ($lines as $line) {
		$output[] = '<span>' . esc_html($line) . '</span>';
	}

	return implode("\n", $output);
};

$render_multiline_with_highlight = static function ($text) {
	$lines = preg_split('/\r\n|\r|\n/', (string) $text);
	$lines = array_values(array_filter(array_map('trim', $lines), static fn ($line) => $line !== ''));

	if (!$lines) {
		return '';
	}

	$last_index = count($lines) - 1;
	$output = [];

	foreach ($lines as $index => $line) {
		$escaped = esc_html($line);

		if ($index === $last_index) {
			$escaped = '<span>' . $escaped . '</span>';
		}

		$output[] = $escaped;
	}

	return implode('<br>', $output);
};

$contacts_heading = $get_field_value('contacts_heading', "Наши\nконтакты");
$contacts_form_heading = $get_field_value('contacts_form_heading', "Начнём строить\nвашу геометрию?");
$contacts_form_subtitle = $get_field_value('contacts_form_subtitle', 'Заполните заявку и мы ответим вам в ближайшее время!');

$theme_phone = $get_field_value('theme_phone', '+7 (999) 999-99-99', 'option');
$theme_email = $get_field_value('theme_email', 'info@geometriasmislov.com', 'option');
$theme_contact_telegram = $get_field_value('theme_contact_telegram', [], 'option');
$theme_personal_data_policy = $get_field_value('theme_personal_data_policy_url', [], 'option');
$theme_privacy_policy = $get_field_value('theme_privacy_policy_url', [], 'option');
$theme_user_agreement = $get_field_value('theme_user_agreement_url', [], 'option');

$theme_phone_href = preg_replace('/[^0-9\+]/', '', $theme_phone);
$telegram_url = !empty($theme_contact_telegram['url']) ? $theme_contact_telegram['url'] : '#';
$telegram_title = !empty($theme_contact_telegram['title']) ? $theme_contact_telegram['title'] : '@geometriasmislov';
$personal_data_policy_url = !empty($theme_personal_data_policy['url']) ? $theme_personal_data_policy['url'] : '#';
$privacy_policy_url = !empty($theme_privacy_policy['url']) ? $theme_privacy_policy['url'] : '#';
$user_agreement_url = !empty($theme_user_agreement['url']) ? $theme_user_agreement['url'] : '#';
?>

<main class="main">
	<section class="contacts">
		<div class="contacts__container container">
			<h1 class="contacts__heading title title--100">
				<?php echo wp_kses_post($render_heading_lines($contacts_heading)); ?>
			</h1>
			<div class="contacts__columns">
				<div class="contacts__col contacts__col--left">
					<div class="contacts__items">
						<a href="tel:<?php echo esc_attr($theme_phone_href); ?>" class="contacts__item">
							<img src="<?php echo esc_url(geometria_docs_asset('img/contacts/phone.svg')); ?>" alt="" class="contacts__item-icon">
							<span><?php echo esc_html($theme_phone); ?></span>
						</a>
						<a href="mailto:<?php echo esc_attr($theme_email); ?>" class="contacts__item">
							<img src="<?php echo esc_url(geometria_docs_asset('img/contacts/mail.svg')); ?>" alt="" class="contacts__item-icon">
							<span><?php echo esc_html($theme_email); ?></span>
						</a>
						<a href="<?php echo esc_url($telegram_url); ?>" class="contacts__item">
							<img src="<?php echo esc_url(geometria_docs_asset('img/contacts/tg.svg')); ?>" alt="" class="contacts__item-icon">
							<span><?php echo esc_html($telegram_title); ?></span>
						</a>
					</div>
				</div>
				<div class="contacts__col contacts__col--right">
					<h3 class="contacts__col-title title title--32">
						<?php echo wp_kses_post($render_multiline_with_highlight($contacts_form_heading)); ?>
					</h3>
					<p class="contacts__col-subtitle text text--light">
						<?php echo esc_html($contacts_form_subtitle); ?>
					</p>
                    <?php echo $formFeedbackContacts; ?>
				</div>
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
                <a href="/cases/" class="modal__thanks-btn btn btn--second">
                    <span>Смотреть наши кейсы</span>
                </a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
