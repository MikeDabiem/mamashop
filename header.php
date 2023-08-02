<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?></title>
  <?php wp_head(); ?>
</head>
<body>
<?php wp_body_open(); ?>
<header class="header transition-default">
    <div class="wrapper d-flex align-items-center">
        <button class="burger header__btn std-btn transition-default">
            <div class="burger-line transition-default"></div>
        </button>
        <a href="<?= home_url(); ?>" class="header-logo d-block">
            <img src="<?php bloginfo("template_url"); ?>/images/logo.png" alt="logo" class="contain-img">
        </a>
        <button class="header__catalog std-btn font-15-24 fw-600 transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width="2" d="M3.53 7.458c0-1.22 0-1.83.2-2.31A2.617 2.617 0 0 1 5.146 3.73c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.265 1.15.775 1.417 1.416.199.481.199 1.09.199 2.31s0 1.83-.2 2.311a2.618 2.618 0 0 1-1.416 1.416c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2A2.617 2.617 0 0 1 3.73 9.768c-.2-.481-.2-1.09-.2-2.31ZM16.618 7.458c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.416c.2.481.2 1.09.2 2.31s0 1.83-.2 2.311a2.617 2.617 0 0 1-1.416 1.416c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.481-.2-1.09-.2-2.31ZM3.53 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.266 1.15.775 1.417 1.417.199.48.199 1.09.199 2.31s0 1.83-.2 2.31a2.618 2.618 0 0 1-1.416 1.417c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2a2.618 2.618 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31ZM16.618 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.417c.2.48.2 1.09.2 2.31s0 1.83-.2 2.31a2.617 2.617 0 0 1-1.416 1.417c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31Z"/></svg>
            Каталог
        </button>
        <?php get_search_form(); ?>
        <div class="header__cab d-flex">
            <a href="#" class="header__fav header__btn std-btn d-flex justify-content-center align-items-center transition-default">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/></svg>
            </a>
            <a href="#" class="header__profile header__btn std-btn d-flex justify-content-center align-items-center transition-default">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width=".1" d="M17.802 6.818c0 2.1-1.702 3.802-3.802 3.802v2a5.802 5.802 0 0 0 5.802-5.802h-2ZM14 10.62a3.802 3.802 0 0 1-3.802-3.802h-2A5.802 5.802 0 0 0 14 12.62v-2Zm-3.802-3.802c0-2.1 1.702-3.802 3.802-3.802v-2a5.802 5.802 0 0 0-5.802 5.802h2ZM14 3.016c2.1 0 3.802 1.702 3.802 3.802h2A5.802 5.802 0 0 0 14 1.016v2ZM10.4 16.22h7.203v-2h-7.203v2Zm7.203 7.605h-7.203v2h7.203v-2Zm-7.203 0a3.802 3.802 0 0 1-3.802-3.803h-2a5.802 5.802 0 0 0 5.802 5.803v-2Zm11.005-3.803c0 2.1-1.702 3.803-3.802 3.803v2a5.802 5.802 0 0 0 5.802-5.803h-2Zm-3.802-3.802c2.1 0 3.802 1.703 3.802 3.802h2a5.802 5.802 0 0 0-5.802-5.802v2Zm-7.203-2a5.802 5.802 0 0 0-5.802 5.802h2c0-2.1 1.702-3.802 3.802-3.802v-2Z"/></svg>
            </a>
            <button type="button" class="header__cart header__btn std-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width=".1" d="m24.882 17.302 1.263-7.685a3.466 3.466 0 0 0-.75-2.85l-.036.03.037-.03a3.47 3.47 0 0 0-2.671-1.249H6.665l-.109-.753a3.494 3.494 0 0 0-3.442-2.986h-.332a.985.985 0 0 0 0 1.97h.33c.746 0 1.387.556 1.493 1.294l1.882 13.168a3.494 3.494 0 0 0 3.442 2.986h10.303c1.74 0 2.822-.517 3.51-1.267.687-.75.975-1.724 1.14-2.628Zm-.677-8.022-.816 4.962h-8.143a.985.985 0 0 0 0 1.97h7.819l-.124.754c-.141.779-.331 1.34-.724 1.708-.391.368-.994.553-1.985.553H9.929a1.515 1.515 0 0 1-1.492-1.294L6.944 7.487h15.78a1.507 1.507 0 0 1 1.481 1.793Zm-13.92 17.526a1.609 1.609 0 0 0 0-3.216h-.012c-.888 0-1.601.72-1.601 1.608 0 .888.728 1.608 1.614 1.608Zm9.972-3.216h-.013c-.887 0-1.601.72-1.601 1.608 0 .887.727 1.608 1.614 1.608a1.609 1.609 0 0 0 0-3.216Z"/></svg>
            </button>
        </div>
    </div>
</header>
<div class="header-menu-bg blur-bg transition-default">
    <div class="main-menu header-menu transition-default">
        <div class="main-menu__head d-flex justify-content-between align-items-center">
            <a href="<?= home_url(); ?>" class="main-menu-logo d-block">
                <img src="<?php bloginfo("template_url"); ?>/images/logo.png" alt="logo" class="contain-img">
            </a>
            <button class="main-menu__close close-menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
            </button>
        </div>
        <section class="main-menu__customers">
            <h5 class="main-menu__section-title font-16-22 fw-600">Інформація для покупців</h5>
            <div class="main-menu__section__links">
                <a href="#" class="main-menu__section__links-item d-flex align-items-center">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo("template_url"); ?>/images/eye-slash.svg" alt="logo" class="contain-img">
                    </div>
                    <p class="font-14-20 fw-500">Питання та відповіді</p>
                </a>
            </div>
        </section>
        <section class="main-menu__company">
            <h5 class="main-menu__section__title font-16-22 fw-600">Інформація для покупців</h5>
            <div class="main-menu__section__links">
                <a href="#" class="main-menu__section__links-item d-flex align-items-center">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo("template_url"); ?>/images/eye-slash.svg" alt="logo" class="contain-img">
                    </div>
                    <p class="font-14-20 fw-500">Питання та відповіді</p>
                </a>
            </div>
        </section>
    </div>
</div>
<div class="header-menu-bg blur-bg transition-default">
    <?php require 'components/catalog-menu.php'; ?>
</div>
<div class="header-menu-bg blur-bg transition-default">
    <div class="cart-menu header-menu transition-default">
        <div class="cart-menu__head d-flex justify-content-between">
            <h4 class="cart-menu__title">Ваш кошик</h4>
            <button class="cart-menu__close close-menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
            </button>
        </div>
        <p class="cart-menu__value">4 товари</p>
        <div class="cart-menu__products">
            <div class="cart-menu__products__item d-flex">
                <div class="cart-menu__products__item__image"></div>
                <div class="cart-menu__products__item__info">
                    <div class="cart-menu__products__item__info__top d-flex justify-content-between">
                        <div class="cart-menu__products__item__name">
                            <div class="cart-menu__products__item__title">Плин для посуду Ultra nature</div>
                            <div class="cart-menu__products__item__subtitle">Denkmit</div>
                        </div>
                        <div class="cart-menu__products__item__info__top__menu">
                            <div class="dots"></div>
                        </div>
                    </div>
                    <div class="cart-menu__products__item__info__bottom d-flex justify-content-between">
                        <div class="cart-menu__products__item__value d-flex">
                            <button class="cart-menu__products__item__value-minus">-</button>
                            <p class="cart-menu__products__item__value-num">1</p>
                            <button class="cart-menu__products__item__value-plus">+</button>
                        </div>
                        <div class="cart-menu__products__item__price">
                            <div class="cart-menu__products__item__price__discount">
                                <span class="cart-menu__products__item__price__discount-value">180 грн</span>
                                <span class="cart-menu__products__item__price__discount-percent">-25%</span>
                            </div>
                            <p class="cart-menu__products__item__price__value">105 грн</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>