<?php get_header(); ?>

<?php
$render_heading_lines = static function ($text, $fallback = '') {
	$source = trim((string) $text);
	$source = $source !== '' ? $source : (string) $fallback;
	$lines = preg_split('/\r\n|\r|\n/', $source);
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

$render_case_terms = static function ($post_id) {
	$terms = get_the_terms($post_id, 'case_category');

	if (!is_array($terms) || !$terms) {
		return;
	}

	foreach ($terms as $term) {
		$term_link = get_term_link($term);

		if (is_wp_error($term_link)) {
			continue;
		}
		?>
		<a href="<?php echo esc_url($term_link); ?>" class="case-detail__tag btn"><span><?php echo esc_html($term->name); ?></span></a>
		<?php
	}
};
?>

<main class="main">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php
			$detail_heading = function_exists('get_field') ? get_field('case_detail_heading') : '';
			$case_task_text = function_exists('get_field') ? get_field('case_task_text') : '';
			$case_done_content = function_exists('get_field') ? get_field('case_done_content') : '';
			$case_result_value = function_exists('get_field') ? get_field('case_result_value') : '';
			$case_result_text = function_exists('get_field') ? get_field('case_result_text') : '';
			$case_gallery = function_exists('get_field') ? get_field('case_gallery') : [];
			$archive_url = get_post_type_archive_link('cases');
			?>

			<section class="case-detail">
				<div class="case-detail__container container">
					<div class="breadcrumb">
                        <div class="breadcrumb__container">
                            <div class="breadcrumbs__body">
                                <?php
                                    if ( function_exists('yoast_breadcrumb') ) {
                                        yoast_breadcrumb( '<p id="breadcrumb" class="breadcrumb__inner">','</p>' );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

					<header class="case-detail__header">
						<h1 class="case-detail__heading title title--60">
							<?php echo wp_kses_post($render_heading_lines($detail_heading, get_the_title())); ?>
						</h1>

						<div class="case-detail__tags">
							<?php $render_case_terms(get_the_ID()); ?>
						</div>
					</header>

					<div class="case-detail__grid">
						<div class="case-detail__block case-detail__block--task">
							<h2 class="case-detail__block-title title title--32">→ ЗАДАЧА</h2>
							<p class="case-detail__block-text text">
								<?php echo esc_html($case_task_text); ?>
							</p>
						</div>

						<div class="case-detail__block case-detail__block--done">
							<h2 class="case-detail__block-title title title--32"><span>→ ЧТО СДЕЛАЛИ</span></h2>
							<div class="case-detail__block-text text">
								<?php echo wp_kses_post((string) $case_done_content); ?>
							</div>
						</div>

						<div class="case-detail__block case-detail__block--result">
							<h2 class="case-detail__block-title title title--60">→ РЕЗУЛЬТАТ</h2>
							<?php if ($case_result_value) : ?>
								<div class="case-detail__result-item">
									<span class="case-detail__result-value"><?php echo esc_html($case_result_value); ?></span>
								</div>
							<?php endif; ?>
							<p class="case-detail__block-text">
								<?php echo nl2br(esc_html($case_result_text)); ?>
							</p>
						</div>
					</div>

					<?php if (is_array($case_gallery) && $case_gallery) : ?>
						<section class="photo-gallery">
							<div class="photo-gallery__container">
								<div class="photo-gallery__grid">
									<?php foreach ($case_gallery as $index => $gallery_item) : ?>
										<?php
										$image = isset($gallery_item['image']) && is_array($gallery_item['image']) ? $gallery_item['image'] : [];
										$image_url = $image['url'] ?? '';
										$image_alt = trim((string) ($gallery_item['alt'] ?? ''));
										$image_alt = $image_alt !== '' ? $image_alt : get_the_title();

										if ($image_url === '') {
											continue;
										}

										$item_class = $index === 0 ? 'photo-gallery__item photo-gallery__item--large' : 'photo-gallery__item photo-gallery__item--small';
										?>
										<div class="<?php echo esc_attr($item_class); ?>">
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="photo-gallery__image" data-fancybox="gallery-case">
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</section>
					<?php endif; ?>
				</div>
			</section>
		<?php endwhile; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
