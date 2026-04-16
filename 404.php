<?php get_header(); ?>

<?php
$cases_page = get_page_by_path('cases');
$cases_url = $cases_page instanceof WP_Post ? get_permalink($cases_page) : home_url('/#cases');
?>

<main class="main">
	<div class="error404">
        <div class="breadcrumb">
            <div class="breadcrumb__container container">
                <div class="breadcrumbs__body">
                    <?php
                        if ( function_exists('yoast_breadcrumb') ) {
                            yoast_breadcrumb( '<p id="breadcrumb" class="breadcrumb__inner">','</p>' );
                        }
                    ?>
                </div>
            </div>
        </div>
		<div class="error404__container container js-parallax-container">
			<div class="error404__image js-animation-item" data-intensity="2">
				<img src="<?php echo esc_url(geometria_docs_asset('img/error404.svg')); ?>" alt="Ошибка 404">
			</div>
			<div class="error404__text title title--32 js-animation-item" data-intensity="3">
				Мы уже ищем эту страницу...
			</div>
			<div class="error404__text title title--32 js-animation-item" data-intensity="4">
				пока можете посмотреть наши кейсы или перейти на главную
			</div>
			<div class="error404__actions">
				<a href="<?php echo esc_url($cases_url); ?>" class="error404__btn btn btn--second">
					<span>Наши кейсы</span>
				</a>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="error404__btn btn">
					<span>Главная</span>
				</a>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
