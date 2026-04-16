<?php
$post_id = isset($args['post_id']) ? (int) $args['post_id'] : 0;

if (!$post_id) {
	return;
}

$preview_content = function_exists('get_field') ? get_field('case_preview_content', $post_id) : '';
$card_image = get_the_post_thumbnail_url($post_id, 'full');
$card_image = $card_image ?: geometria_docs_asset('img/cases/cases-img-1.webp');
$terms = get_the_terms($post_id, 'case_category');
?>
<div class="cases__item cases__item--main">
	<div class="cases__item-wrap">
		<div class="cases__item-content">
			<a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="cases__item-title text text--24 text--light">
				<?php echo esc_html(get_the_title($post_id)); ?>
				<span class="cases__item-arrow">&rarr;</span>
			</a>
			<?php if ($preview_content) : ?>
				<div class="cases__item-text text text--light wysiwyg">
					<?php echo wp_kses_post((string) $preview_content); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if (is_array($terms) && $terms) : ?>
			<div class="cases__item-tags">
				<?php foreach ($terms as $term) : ?>
					<?php
					$term_link = get_term_link($term);

					if (is_wp_error($term_link)) {
						continue;
					}
					?>
					<a href="<?php echo esc_url($term_link); ?>" class="cases__item-tag btn"><span><?php echo esc_html($term->name); ?></span></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="cases__item-pic">
		<img class="cases__item-image" src="<?php echo esc_url($card_image); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
	</div>
</div>
