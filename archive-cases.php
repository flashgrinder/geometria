<?php get_header(); ?>

<?php
global $wp_query;

$archive_heading = ['Наши', 'кейсы'];
$current_page = max(1, (int) get_query_var('paged'));
$max_pages = max(1, (int) $wp_query->max_num_pages);
?>

<main class="main">
	<section class="cases cases--index">
		<div class="cases__container container">
			<div class="breadcrumb">
				<div class="breadcrumb__container">
					<div class="breadcrumbs__body">
						<?php
						if (function_exists('yoast_breadcrumb')) {
							yoast_breadcrumb('<p id="breadcrumb" class="breadcrumb__inner">', '</p>');
						}
						?>
					</div>
				</div>
			</div>
			<h1 class="cases__heading title title--100">
				<span><?php echo esc_html($archive_heading[0]); ?></span>
				<span><?php echo esc_html($archive_heading[1]); ?></span>
			</h1>

			<div
				class="cases__layout js-cases-feed"
				data-post-type="cases"
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
								<div class="cases__item-title text text--24 text--light">Кейсы скоро появятся</div>
								<p class="cases__item-text text text--light">Раздел уже готов, осталось наполнить его кейсами из админки.</p>
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
