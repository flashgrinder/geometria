<?php get_header(); ?>

<main class="main">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article class="page-content">
				<div class="page-content__body">
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
					<div class="page-content__content">
						<h1 class="page-content__title title title--60">
							<?php the_title(); ?>
						</h1>
						<div class="page-content__wysiwyg wysiwyg">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
