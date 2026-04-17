<?php get_header(); ?>

<?php
global $wp_query;

$term = get_queried_object();
$current_page = max(1, (int) get_query_var('paged'));
$max_pages = max(1, (int) $wp_query->max_num_pages);
?>

<main class="main">
	<section class="cases cases--index cases--category">
		<div class="cases__container container">
			<h1 class="cases__heading title title--100">
				<span>Кейсы</span>
				<span><?php echo esc_html($term && !empty($term->name) ? $term->name : 'категории'); ?></span>
			</h1>

			<div
				class="cases__layout js-cases-feed"
				data-post-type="cases"
				data-taxonomy="case_category"
				data-term-id="<?php echo esc_attr($term instanceof WP_Term ? $term->term_id : 0); ?>"
				data-current-page="<?php echo esc_attr($current_page); ?>"
				data-max-pages="<?php echo esc_attr($max_pages); ?>"
			>
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<?php get_template_part('template-parts/cases/card', null, ['post_id' => get_the_ID()]); ?>
					<?php endwhile; ?>
				<?php else : ?>
					<div class="cases__item cases__item--main">
						<div class="cases__item-wrap">
							<div class="cases__item-content">
								<div class="cases__item-title text text--24 text--light">Кейсы не найдены</div>
								<p class="cases__item-text text text--light">В этой категории пока нет опубликованных кейсов.</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ($max_pages > $current_page) : ?>
				<div class="cases__load-trigger js-cases-load-trigger" aria-hidden="true"></div>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part('template-parts/front-page/section', 'form'); ?>
</main>

<?php get_footer(); ?>
