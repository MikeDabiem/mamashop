<?php $promos = new WP_Query(['post_type' => 'promo', 'posts_per_page' => 3]);
if ($promos->have_posts()): ?>
    <section class="banner">
        <h2 class="d-none">Акції</h2>
        <div class="banner__items">
            <?php while ($promos->have_posts()): $promos->the_post();
                $big_banner = get_field('banner_big');
                $small_banner = get_field('banner_small');
                $link = get_field('promo_url'); ?>
                <a href="<?= $link ?>" class="banner__item img-wrapper-cover" aria-hidden="true">
                    <picture>
                        <source srcset="<?= $small_banner ?>" media="(max-width: 480px)" />
                        <img src="<?= $big_banner ?>" alt="<?= get_the_title() ?>" loading="lazy">
                    </picture>
                </a>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
        <button type="button" class="banner__prev slider-arrow transition-default" aria-label="Попередній слайд">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
        </button>
        <button type="button" class="banner__next slider-arrow transition-default" aria-label="Наступний слайд">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
        </button>
    </section>
<?php endif; ?>
