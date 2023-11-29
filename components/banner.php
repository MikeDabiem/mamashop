<?php $promos_link = get_field('promos_page', 'options'); ?>
<section class="banner">
    <h2 class="d-none">Акції</h2>
    <div class="banner__items">
        <?php for ($i = 0; $i < 4; $i++) { ?>
            <a href="<?= $promos_link; ?>" class="banner__item img-wrapper-cover" aria-hidden="true">
                <picture>
                    <source srcset="<?php bloginfo("template_url"); ?>/images/promo-small.jpg" media="(max-width: 480px)" />
                    <img data-lazy="<?php bloginfo("template_url"); ?>/images/promo.jpg" alt="">
                </picture>
            </a>
        <?php } ?>
    </div>
    <button type="button" class="banner__prev slider-arrow transition-default" aria-label="Попередній слайд">
        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
    </button>
    <button type="button" class="banner__next slider-arrow transition-default" aria-label="Наступний слайд">
        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
    </button>
</section>