<?php
$post_id = isset($args['post_id']) ? (int) $args['post_id'] : 0;

if (!$post_id) {
	return;
}

$categories = get_the_category($post_id);
?>
<article class="article-card">
	<div class="article-card__meta">
		<time class="article-card__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d', $post_id)); ?>"><?php echo esc_html(get_the_date('d.m.Y', $post_id)); ?></time>
		<span class="article-card__reading-time"><?php echo esc_html(geometria_get_post_reading_time($post_id)); ?></span>
	</div>
	<div class="article-card__content">
		<h2 class="article-card__title text text--24 text--light">
			<a href="<?php echo esc_url(get_permalink($post_id)); ?>">
				<span><?php echo esc_html(get_the_title($post_id)); ?></span>
				<span class="article-card__arrow">&rarr;</span>
			</a>
		</h2>
		<p class="article-card__excerpt text text--light"><?php echo esc_html(get_the_excerpt($post_id)); ?></p>
	</div>
	<?php if ($categories) : ?>
		<div class="article-card__footer">
			<div class="article-card__categories">
				<?php foreach ($categories as $category) : ?>
					<span class="article-card__category btn"><span><?php echo esc_html($category->name); ?></span></span>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</article>
