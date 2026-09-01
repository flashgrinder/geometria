<?php get_header(null, ['body_id' => 'article-detail']); ?>

<?php
$get_article_media = static function ($post_id) {
	$media_ids = [];
	$thumbnail_id = get_post_thumbnail_id($post_id);

	if ($thumbnail_id) {
		$media_ids[] = (int) $thumbnail_id;
	}

	$attachments = get_children([
		'post_parent' => $post_id,
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_status' => 'inherit',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'numberposts' => -1,
	]);

	foreach (array_keys($attachments) as $attachment_id) {
		$attachment_id = (int) $attachment_id;

		if (!in_array($attachment_id, $media_ids, true)) {
			$media_ids[] = $attachment_id;
		}
	}

	return array_slice($media_ids, 0, 2);
};
?>

<main class="main">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php
			$post_id = get_the_ID();
			$article_content = apply_filters('the_content', get_the_content(null, false, $post_id));
			$article_toc = function_exists('get_field') ? get_field('article_toc', $post_id) : [];
			$article_toc = is_array($article_toc) ? array_values(array_filter(array_map(
				static function ($toc_item) {
					$title = isset($toc_item['title']) ? sanitize_text_field((string) $toc_item['title']) : '';
					$anchor = isset($toc_item['anchor']) ? ltrim(sanitize_text_field((string) $toc_item['anchor']), '#') : '';

					return ($title !== '' && $anchor !== '') ? [
						'title' => $title,
						'anchor' => $anchor,
					] : null;
				},
				$article_toc
			))) : [];
			$article_categories = get_the_category($post_id);
			$article_media_ids = $get_article_media($post_id);
			$articles_url = add_query_arg('post_type', 'post', home_url('/'));
			?>

			<article class="article-detail">
				<div class="article-detail__container container">
					<div class="breadcrumb article-detail__breadcrumb">
						<div class="breadcrumb__container">
							<div class="breadcrumbs__body">
								<?php if (function_exists('yoast_breadcrumb')) : ?>
									<?php yoast_breadcrumb('<p id="breadcrumb" class="breadcrumb__inner">', '</p>'); ?>
								<?php else : ?>
									<p id="breadcrumb" class="breadcrumb__inner"><span><span><a href="<?php echo esc_url(home_url('/')); ?>">Главная</a></span> — <span><a href="<?php echo esc_url($articles_url); ?>">Статьи</a></span> — <span class="breadcrumb_last"><?php the_title(); ?></span></span></p>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<header class="article-detail__header">
						<h1 class="article-detail__heading title title--60"><?php the_title(); ?></h1>

						<div class="article-detail__meta">
							<time class="article-detail__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d', $post_id)); ?>"><?php echo esc_html(get_the_date('d.m.Y', $post_id)); ?></time>
							<span class="article-detail__reading-time"><?php echo esc_html(geometria_get_post_reading_time($post_id)); ?></span>
						</div>

						<?php if ($article_categories) : ?>
							<div class="article-detail__tags">
								<?php foreach ($article_categories as $article_category) : ?>
									<span class="article-detail__tag btn"><span><?php echo esc_html($article_category->name); ?></span></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</header>

					<div class="article-detail__layout">
						<div class="article-detail__content">
							<div class="article-detail__wysiwyg">
								<?php echo $article_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>

						<?php if ($article_toc) : ?>
							<aside class="article-detail__toc js-article-toc">
								<h2 class="article-detail__toc-title title title--32">Оглавление</h2>
								<ol class="article-detail__toc-list">
									<?php foreach ($article_toc as $toc_item) : ?>
										<li><a class="js-article-toc-link" href="#<?php echo esc_attr($toc_item['anchor']); ?>"><?php echo esc_html($toc_item['title']); ?></a></li>
									<?php endforeach; ?>
								</ol>
							</aside>
						<?php endif; ?>
					</div>

					<?php if ($article_media_ids) : ?>
						<section class="article-detail__media" aria-label="Материалы статьи">
							<?php foreach ($article_media_ids as $media_id) : ?>
								<?php
								$media_url = wp_get_attachment_image_url($media_id, 'full');
								$media_caption = wp_get_attachment_caption($media_id);

								if (!$media_url) {
									continue;
								}
								?>
								<div class="article-detail__media-item">
									<a class="article-detail__media-link" href="<?php echo esc_url($media_url); ?>" data-fancybox="article-media"<?php echo $media_caption ? ' data-caption="' . esc_attr($media_caption) . '"' : ''; ?>><?php echo wp_get_attachment_image($media_id, 'large', false, ['class' => 'article-detail__media-image', 'loading' => 'lazy']); ?></a>
								</div>
							<?php endforeach; ?>
						</section>
					<?php endif; ?>

					<?php
					$related_articles = new WP_Query([
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'post__not_in' => [$post_id],
						'ignore_sticky_posts' => true,
					]);
					?>

					<?php if ($related_articles->have_posts()) : ?>
						<section class="article-detail__more">
							<h2 class="article-detail__more-heading title title--60">Читайте дальше</h2>

							<div class="article-detail__cards">
								<?php while ($related_articles->have_posts()) : $related_articles->the_post(); ?>
									<?php get_template_part('template-parts/articles/card', null, ['post_id' => get_the_ID()]); ?>
								<?php endwhile; ?>
							</div>

							<div class="article-detail__more-actions"><a href="<?php echo esc_url($articles_url); ?>" class="article-detail__more-link btn btn--second"><span>Смотреть все статьи</span></a></div>
						</section>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>

	<?php get_template_part('template-parts/front-page/section', 'form'); ?>
</main>

<?php get_footer(); ?>
