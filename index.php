<?php get_header(); ?>

<?php
global $wp_query;

$article_categories = get_categories([
	'taxonomy' => 'category',
	'hide_empty' => true,
]);
$all_articles_url = add_query_arg('post_type', 'post', home_url('/'));
$all_articles_active = !is_category();
$articles_current_page = geometria_get_articles_page();
$articles_max_pages = max(1, (int) ceil((int) $wp_query->found_posts / 6));
$articles_category_id = is_category() ? get_queried_object_id() : 0;
?>

<main class="main">
	<section class="articles">
		<div class="articles__container container">
			<div class="breadcrumb articles__breadcrumb">
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

			<h1 class="articles__heading title title--100"><span>Полезные</span><span>материалы</span></h1>

			<div class="articles__filters" aria-label="Категории статей">
				<a href="<?php echo esc_url($all_articles_url); ?>" class="articles__filter btn<?php echo $all_articles_active ? ' articles__filter--active' : ''; ?>"<?php echo $all_articles_active ? ' aria-current="page"' : ''; ?>><span>Все</span></a>
				<?php foreach ($article_categories as $article_category) : ?>
					<?php
					$category_url = get_category_link($article_category->term_id);
					$category_active = is_category($article_category->term_id);

					if (is_wp_error($category_url)) {
						continue;
					}
					?>
					<a href="<?php echo esc_url($category_url); ?>" class="articles__filter btn<?php echo $category_active ? ' articles__filter--active' : ''; ?>"<?php echo $category_active ? ' aria-current="page"' : ''; ?>><span><?php echo esc_html($article_category->name); ?></span></a>
				<?php endforeach; ?>
			</div>

			<div
				class="articles__grid js-articles-feed"
				id="articles-list"
				data-current-page="<?php echo esc_attr($articles_current_page); ?>"
				data-max-pages="<?php echo esc_attr($articles_max_pages); ?>"
				data-category-id="<?php echo esc_attr($articles_category_id); ?>"
			>
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<?php get_template_part('template-parts/articles/card', null, ['post_id' => get_the_ID()]); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<?php if ($articles_current_page < $articles_max_pages) : ?>
				<div class="articles__actions js-articles-actions">
					<button type="button" class="articles__more btn btn--second js-articles-load-more"><span>Показать еще статьи</span></button>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
