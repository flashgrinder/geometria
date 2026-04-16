<?php /* Template Name: Главная страница */?>
<?php get_header(); ?>

<main class="main">
	<?php get_template_part('template-parts/front-page/section', 'top'); ?>
	<?php get_template_part('template-parts/front-page/section', 'hero'); ?>
	<?php get_template_part('template-parts/front-page/section', 'services'); ?>
	<?php get_template_part('template-parts/front-page/section', 'cases'); ?>
	<?php get_template_part('template-parts/front-page/section', 'team'); ?>
	<?php get_template_part('template-parts/front-page/section', 'process'); ?>
	<?php get_template_part('template-parts/front-page/section', 'form'); ?>
</main>

<?php get_footer(); ?>
