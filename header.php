<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>
<?php wp_body_open(); ?>
<noscript class="d-flex justify-content-center align-items-center">
    <style>
        body {
            opacity: 1;
            overflow: hidden;
        }
    </style>
    <h1>Вам потрібно дозволити використання JavaScript в браузері для перегляду цього сайту</h1>
</noscript>
<?php if (is_page('checkout') || is_page('lost-password')) { ?>
    <header class="checkout-header wrapper">
        <a href="<?= home_url(); ?>" class="header-logo checkout-header-logo">
            <img src="<?php bloginfo("template_url"); ?>/images/logo.svg" alt="logo" class="logo-img">
        </a>
    </header>
<?php } else { ?>
    <header class="header transition-default">
        <div class="wrapper d-flex align-items-center">
            <button class="burger header__btn std-btn transition-default" aria-label="Меню інформації">
                <div class="burger-line transition-default"></div>
            </button>
            <a href="<?= home_url(); ?>" class="header-logo">
                <picture>
                    <source srcset="<?php bloginfo("template_url"); ?>/images/logo-min.svg" media="(max-width: 360px)" />
                    <source srcset="<?php bloginfo("template_url"); ?>/images/logo.svg" media="(max-width: 768px)" />
                    <source srcset="<?php bloginfo("template_url"); ?>/images/logo-min.svg" media="(max-width: 900px)" />
                    <img src="<?php bloginfo("template_url"); ?>/images/logo.svg" alt="logo" class="logo-img">
                </picture>
            </a>
            <button class="header__catalog header__catalog--header std-btn blue-btn font-15-24 fw-600 transition-default">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width="2" d="M3.53 7.458c0-1.22 0-1.83.2-2.31A2.617 2.617 0 0 1 5.146 3.73c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.265 1.15.775 1.417 1.416.199.481.199 1.09.199 2.31s0 1.83-.2 2.311a2.618 2.618 0 0 1-1.416 1.416c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2A2.617 2.617 0 0 1 3.73 9.768c-.2-.481-.2-1.09-.2-2.31ZM16.618 7.458c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.416c.2.481.2 1.09.2 2.31s0 1.83-.2 2.311a2.617 2.617 0 0 1-1.416 1.416c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.481-.2-1.09-.2-2.31ZM3.53 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.266 1.15.775 1.417 1.417.199.48.199 1.09.199 2.31s0 1.83-.2 2.31a2.618 2.618 0 0 1-1.416 1.417c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2a2.618 2.618 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31ZM16.618 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.417c.2.48.2 1.09.2 2.31s0 1.83-.2 2.31a2.617 2.617 0 0 1-1.416 1.417c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31Z"/></svg>
                Каталог
            </button>
            <?php get_search_form(); ?>
            <div class="header__cab d-flex">
                <?php $favorites_url = is_user_logged_in() ? wc_get_page_permalink('myaccount') . '/favorites/' : '#';
                $profile_url = is_user_logged_in() ? wc_get_page_permalink('myaccount') : '#'; ?>
                <a href="<?= home_url('/search/') ?>" class="header-search--button header__btn std-btn transition-default" aria-label="Пошук">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 20 18" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.4526 3.71816C9.06429 1.751 5.53346 2.09246 3.5663 4.48081C1.59915 6.86916 1.9406 10.4 4.32895 12.3672C6.71731 14.3343 10.2481 13.9929 12.2153 11.6045C14.1825 9.21615 13.841 5.68531 11.4526 3.71816ZM2.40658 3.52561C4.90127 0.496758 9.37899 0.0637388 12.4078 2.55843C15.2407 4.89172 15.8028 8.95973 13.8226 11.9545L18.9405 16.1699C19.2607 16.4336 19.3065 16.9071 19.0427 17.2273C18.779 17.5476 18.3055 17.5934 17.9853 17.3296L12.8674 13.1143C10.3076 15.6323 6.20686 15.8603 3.37375 13.5269C0.344903 11.0322 -0.0881168 6.55446 2.40658 3.52561Z" stroke="none"/></svg>
                </a>
                <a href="<?= $favorites_url; ?>" class="header__fav header__btn std-btn d-flex justify-content-center align-items-center transition-default" aria-label="Улюблене">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/></svg>
                </a>
                <a href="<?= $profile_url; ?>" class="header__profile header__btn std-btn d-flex justify-content-center align-items-center transition-default" aria-label="Особистий кабінет">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width=".1" d="M17.802 6.818c0 2.1-1.702 3.802-3.802 3.802v2a5.802 5.802 0 0 0 5.802-5.802h-2ZM14 10.62a3.802 3.802 0 0 1-3.802-3.802h-2A5.802 5.802 0 0 0 14 12.62v-2Zm-3.802-3.802c0-2.1 1.702-3.802 3.802-3.802v-2a5.802 5.802 0 0 0-5.802 5.802h2ZM14 3.016c2.1 0 3.802 1.702 3.802 3.802h2A5.802 5.802 0 0 0 14 1.016v2ZM10.4 16.22h7.203v-2h-7.203v2Zm7.203 7.605h-7.203v2h7.203v-2Zm-7.203 0a3.802 3.802 0 0 1-3.802-3.803h-2a5.802 5.802 0 0 0 5.802 5.803v-2Zm11.005-3.803c0 2.1-1.702 3.803-3.802 3.803v2a5.802 5.802 0 0 0 5.802-5.803h-2Zm-3.802-3.802c2.1 0 3.802 1.703 3.802 3.802h2a5.802 5.802 0 0 0-5.802-5.802v2Zm-7.203-2a5.802 5.802 0 0 0-5.802 5.802h2c0-2.1 1.702-3.802 3.802-3.802v-2Z"/></svg>
                </a>
                <button type="button" class="header__cart header__btn std-btn transition-default" aria-label="Корзина покупок">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width=".1" d="m24.882 17.302 1.263-7.685a3.466 3.466 0 0 0-.75-2.85l-.036.03.037-.03a3.47 3.47 0 0 0-2.671-1.249H6.665l-.109-.753a3.494 3.494 0 0 0-3.442-2.986h-.332a.985.985 0 0 0 0 1.97h.33c.746 0 1.387.556 1.493 1.294l1.882 13.168a3.494 3.494 0 0 0 3.442 2.986h10.303c1.74 0 2.822-.517 3.51-1.267.687-.75.975-1.724 1.14-2.628Zm-.677-8.022-.816 4.962h-8.143a.985.985 0 0 0 0 1.97h7.819l-.124.754c-.141.779-.331 1.34-.724 1.708-.391.368-.994.553-1.985.553H9.929a1.515 1.515 0 0 1-1.492-1.294L6.944 7.487h15.78a1.507 1.507 0 0 1 1.481 1.793Zm-13.92 17.526a1.609 1.609 0 0 0 0-3.216h-.012c-.888 0-1.601.72-1.601 1.608 0 .888.728 1.608 1.614 1.608Zm9.972-3.216h-.013c-.887 0-1.601.72-1.601 1.608 0 .887.727 1.608 1.614 1.608a1.609 1.609 0 0 0 0-3.216Z"/></svg>
                </button>
            </div>
        </div>
    </header>
    <div class="header-menu-bg blur-bg transition-default">
        <div class="main-menu header-menu transition-default">
            <div class="main-menu__head d-flex justify-content-between align-items-center">
                <a href="<?= home_url(); ?>" class="main-menu-logo d-block">
                    <img src="<?php bloginfo("template_url"); ?>/images/logo.svg" alt="logo" class="logo-img">
                </a>
                <button class="main-menu__close close-menu" aria-label="Закрити меню">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
                </button>
            </div>
            <section class="main-menu__customers">
                <h5 class="main-menu__section-title font-16-22 fw-600">Інформація для покупців</h5>
                <div class="main-menu__section__links">
                    <?php $main_menu = [
                        [
                            'title' => 'Доставка',
                            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M22.448 13.2766C22.448 13.2716 22.4509 13.2676 22.4509 13.2626C22.4509 13.2486 22.444 13.2376 22.443 13.2236C22.432 13.1556 22.417 13.0876 22.402 13.0196C22.395 12.9996 22.393 12.9786 22.385 12.9596C22.344 12.7856 22.302 12.6116 22.236 12.4406L21.198 9.87659C20.739 8.71359 20.264 7.5116 17.72 7.5116H15.5V5.7616C15.5 4.5206 14.49 3.5116 13.25 3.5116H5.25C4.01 3.5116 3 4.5206 3 5.7616V16.7616C3 17.9266 3.89295 18.8756 5.02795 18.9896C5.01895 19.0806 5 19.1686 5 19.2616C5 20.7776 6.233 22.0116 7.75 22.0116C9.267 22.0116 10.5 20.7776 10.5 19.2616C10.5 19.1756 10.482 19.0946 10.475 19.0116H15.026C15.018 19.0946 15.001 19.1756 15.001 19.2616C15.001 20.7776 16.234 22.0116 17.751 22.0116C19.268 22.0116 20.501 20.7776 20.501 19.2616C20.501 19.1686 20.483 19.0796 20.473 18.9896C21.608 18.8756 22.501 17.9266 22.501 16.7616V13.8416C22.501 13.6526 22.476 13.4646 22.448 13.2766ZM17.721 9.01257C19.244 9.01257 19.386 9.3696 19.806 10.4336L20.647 12.5126H15.501V9.01257H17.721ZM7.75098 20.5126C7.06198 20.5126 6.50098 19.9516 6.50098 19.2626C6.50098 18.5736 7.06198 18.0126 7.75098 18.0126C8.43998 18.0126 9.00098 18.5736 9.00098 19.2626C9.00098 19.9516 8.43998 20.5126 7.75098 20.5126ZM17.751 20.5126C17.062 20.5126 16.501 19.9516 16.501 19.2626C16.501 18.5736 17.062 18.0126 17.751 18.0126C18.44 18.0126 19.001 18.5736 19.001 19.2626C19.001 19.9516 18.44 20.5126 17.751 20.5126ZM20.251 17.5126H19.855C19.35 16.9066 18.6 16.5126 17.751 16.5126C16.902 16.5126 16.152 16.9066 15.647 17.5126H9.85401C9.34901 16.9066 8.599 16.5126 7.75 16.5126C6.901 16.5126 6.151 16.9066 5.646 17.5126H5.25C4.837 17.5126 4.5 17.1766 4.5 16.7626V14.0126H10.75C11.164 14.0126 11.5 13.6766 11.5 13.2626C11.5 12.8486 11.164 12.5126 10.75 12.5126H4.5V5.76257C4.5 5.34857 4.837 5.01257 5.25 5.01257H13.25C13.663 5.01257 14 5.34857 14 5.76257V14.0126H21V16.7626C21.001 17.1766 20.664 17.5126 20.251 17.5126Z" fill="#494558"/></svg>',
                            'link' => '/delivery/'
                        ],
                        [
                            'title' => 'Оплата',
                            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M19.5 6.55835V6.26135C19.5 3.84335 18.168 2.51135 15.75 2.51135H5.75C4.233 2.51135 3 3.74435 3 5.26135V18.2614C3 20.6794 4.332 22.0114 6.75 22.0114H18.75C21.168 22.0114 22.5 20.6794 22.5 18.2614V10.2614C22.5 8.10635 21.442 6.81435 19.5 6.55835ZM21 16.0114H17.25C16.285 16.0114 15.5 15.2264 15.5 14.2614C15.5 13.2964 16.285 12.5114 17.25 12.5114H21V16.0114ZM5.75 4.01135H15.75C17.327 4.01135 18 4.68435 18 6.26135V6.51135H5.75C5.061 6.51135 4.5 5.95035 4.5 5.26135C4.5 4.57235 5.061 4.01135 5.75 4.01135ZM18.75 20.5114H6.75C5.173 20.5114 4.5 19.8384 4.5 18.2614V7.71033C4.875 7.90233 5.3 8.01135 5.75 8.01135H18.75C20.327 8.01135 21 8.68435 21 10.2614V11.0114H17.25C15.458 11.0114 14 12.4694 14 14.2614C14 16.0534 15.458 17.5114 17.25 17.5114H21V18.2614C21 19.8384 20.327 20.5114 18.75 20.5114ZM17.76 13.2614H17.77C18.323 13.2614 18.77 13.7094 18.77 14.2614C18.77 14.8134 18.323 15.2614 17.77 15.2614C17.218 15.2614 16.765 14.8134 16.765 14.2614C16.765 13.7094 17.208 13.2614 17.76 13.2614Z" fill="#494558"/></svg>',
                            'link' => '/payment/'
                        ],
                        [
                            'title' => 'Повернення та гарантія',
                            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M17.7993 13.3383C17.8953 13.7413 17.6464 14.1453 17.2424 14.2413C17.1834 14.2553 17.1264 14.2614 17.0684 14.2614C16.7284 14.2614 16.4214 14.0294 16.3394 13.6844C15.9324 11.9634 14.4064 10.7614 12.6294 10.7614C11.4224 10.7614 10.3083 11.3354 9.60132 12.2614H10.3193C10.7333 12.2614 11.0693 12.5974 11.0693 13.0114C11.0693 13.4254 10.7333 13.7614 10.3193 13.7614H8.06934C7.65534 13.7614 7.31934 13.4254 7.31934 13.0114V10.7633C7.31934 10.3493 7.65534 10.0133 8.06934 10.0133C8.48334 10.0133 8.81934 10.3493 8.81934 10.7633V10.8912C9.80034 9.87823 11.1634 9.26135 12.6304 9.26135C15.1064 9.26135 17.2323 10.9383 17.7993 13.3383ZM23.3203 12.2614C23.3203 18.1894 18.4983 23.0114 12.5703 23.0114C6.64231 23.0114 1.82031 18.1894 1.82031 12.2614C1.82031 6.33335 6.64231 1.51135 12.5703 1.51135C18.4983 1.51135 23.3203 6.33335 23.3203 12.2614ZM21.8203 12.2614C21.8203 7.16035 17.6713 3.01135 12.5703 3.01135C7.46931 3.01135 3.32031 7.16035 3.32031 12.2614C3.32031 17.3624 7.46931 21.5114 12.5703 21.5114C17.6713 21.5114 21.8203 17.3624 21.8203 12.2614Z" fill="#494558"/></svg>',
                            'link' => '/refund_returns/'
                        ],
                    ];
                    foreach ($main_menu as $menu_item) { ?>
                        <a href="<?= get_site_url() . $menu_item['link']; ?>" class="main-menu__section__links-item transition-default d-flex align-items-center">
                            <div class="img-wrapper d-flex justify-content-center align-items-center">
                                <?= $menu_item['svg']; ?>
                            </div>
                            <p class="font-14-20 fw-500"><?= $menu_item['title']; ?></p>
                        </a>
                    <?php } ?>
                </div>
            </section>
            <section class="main-menu__company">
                <h5 class="main-menu__section__title font-16-22 fw-600">Інформація про компанію</h5>
                <div class="main-menu__section__links">
                    <?php $main_menu_about = [
                        [
                            'title' => 'Про нас',
                            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M20.958 8.40236L14.838 3.27138C13.629 2.25638 11.871 2.25638 10.662 3.27138L4.54199 8.40236C3.58599 9.19536 3 9.7894 3 11.9114V18.2614C3 20.6794 4.332 22.0114 6.75 22.0114H18.75C21.168 22.0114 22.5 20.6794 22.5 18.2614V11.9114C22.5 9.7894 21.914 9.19536 20.958 8.40236ZM21 18.2614C21 19.8384 20.327 20.5114 18.75 20.5114H6.75C5.173 20.5114 4.5 19.8384 4.5 18.2614V11.9114C4.5 10.3854 4.75202 10.1764 5.49902 9.55642L11.625 4.42043C11.951 4.14743 12.351 4.0104 12.75 4.0104C13.149 4.0104 13.549 4.14743 13.875 4.42043L20.001 9.55642C20.748 10.1764 21 10.3854 21 11.9114V18.2614ZM14.521 9.51137C14.516 9.51137 14.511 9.51137 14.507 9.51137C13.738 9.51137 13.159 9.82831 12.749 10.2273C12.339 9.82831 11.76 9.51137 10.99 9.51137C10.986 9.51137 10.981 9.51137 10.976 9.51137C10.053 9.51537 9.27904 9.86732 8.73804 10.5293C8.08604 11.3243 7.84901 12.4794 8.08801 13.6994C8.67701 16.7134 12.287 18.3763 12.441 18.4453C12.539 18.4893 12.644 18.5114 12.75 18.5114C12.856 18.5114 12.961 18.4893 13.059 18.4453C13.212 18.3763 16.823 16.7134 17.412 13.6994C17.65 12.4784 17.4129 11.3233 16.7629 10.5293C16.2199 9.86732 15.445 9.51537 14.521 9.51137ZM15.938 13.4104C15.583 15.2284 13.538 16.4934 12.75 16.9204C11.962 16.4944 9.91701 15.2294 9.56201 13.4104C9.41201 12.6424 9.53802 11.9204 9.90002 11.4794C10.152 11.1704 10.518 11.0134 10.986 11.0114C10.988 11.0114 10.989 11.0114 10.991 11.0114C11.728 11.0114 12.012 11.7414 12.04 11.8184C12.142 12.1214 12.425 12.3223 12.744 12.3263C12.747 12.3263 12.75 12.3263 12.752 12.3263C13.068 12.3263 13.353 12.1243 13.46 11.8263C13.489 11.7433 13.773 11.0123 14.51 11.0123C14.512 11.0123 14.513 11.0123 14.515 11.0123C14.985 11.0143 15.35 11.1724 15.603 11.4804C15.963 11.9204 16.089 12.6424 15.938 13.4104Z" fill="#494558"/></svg>',
                            'link' => '/about/'
                        ],
                        [
                            'title' => 'Умови використання сайту',
                            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M11.75 19.5114H6.75C5.173 19.5114 4.5 18.8384 4.5 17.2614V5.26135C4.5 3.68435 5.173 3.01135 6.75 3.01135H12V5.26135C12 7.67935 13.332 9.01135 15.75 9.01135H18V11.2614C18 11.6754 18.336 12.0114 18.75 12.0114C19.164 12.0114 19.5 11.6754 19.5 11.2614V8.26135C19.5 8.06235 19.421 7.87135 19.28 7.73135L13.28 1.73135C13.139 1.59035 12.949 1.51135 12.75 1.51135H6.75C4.332 1.51135 3 2.84335 3 5.26135V17.2614C3 19.6794 4.332 21.0114 6.75 21.0114H11.75C12.164 21.0114 12.5 20.6754 12.5 20.2614C12.5 19.8474 12.164 19.5114 11.75 19.5114ZM13.5 5.26135V4.07236L16.939 7.51135H15.75C14.173 7.51135 13.5 6.83835 13.5 5.26135ZM14.75 10.5114C15.164 10.5114 15.5 10.8474 15.5 11.2614C15.5 11.6754 15.164 12.0114 14.75 12.0114H7.75C7.336 12.0114 7 11.6754 7 11.2614C7 10.8474 7.336 10.5114 7.75 10.5114H14.75ZM12.5 15.2614C12.5 15.6754 12.164 16.0114 11.75 16.0114H7.75C7.336 16.0114 7 15.6754 7 15.2614C7 14.8474 7.336 14.5114 7.75 14.5114H11.75C12.164 14.5114 12.5 14.8474 12.5 15.2614ZM18.75 13.5114C16.131 13.5114 14 15.6424 14 18.2614C14 20.8804 16.131 23.0114 18.75 23.0114C21.369 23.0114 23.5 20.8804 23.5 18.2614C23.5 15.6424 21.369 13.5114 18.75 13.5114ZM18.75 21.5114C16.958 21.5114 15.5 20.0534 15.5 18.2614C15.5 16.4694 16.958 15.0114 18.75 15.0114C20.542 15.0114 22 16.4694 22 18.2614C22 20.0534 20.542 21.5114 18.75 21.5114ZM20.53 16.8973C20.823 17.1903 20.823 17.6653 20.53 17.9583L18.863 19.6254C18.722 19.7654 18.532 19.8444 18.333 19.8444C18.134 19.8444 17.943 19.7654 17.803 19.6244L16.97 18.7914C16.677 18.4984 16.677 18.0233 16.97 17.7303C17.263 17.4383 17.738 17.4373 18.031 17.7303L18.334 18.0334L19.4709 16.8973C19.7629 16.6053 20.237 16.6053 20.53 16.8973Z" fill="#494558"/></svg>',
                            'link' => '/privacy-policy/'
                        ],
                        [
                            'title' => 'Контакти',
                            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M21.75 14.5114H20.5V10.0114H21.75C22.164 10.0114 22.5 9.67535 22.5 9.26135C22.5 8.84735 22.164 8.51135 21.75 8.51135H20.5V6.26135C20.5 3.84335 19.168 2.51135 16.75 2.51135H6.75C4.332 2.51135 3 3.84335 3 6.26135V18.2614C3 20.6794 4.332 22.0114 6.75 22.0114H16.75C19.168 22.0114 20.5 20.6794 20.5 18.2614V16.0114H21.75C22.164 16.0114 22.5 15.6754 22.5 15.2614C22.5 14.8474 22.164 14.5114 21.75 14.5114ZM19 18.2614C19 19.8384 18.327 20.5114 16.75 20.5114H6.75C5.173 20.5114 4.5 19.8384 4.5 18.2614V6.26135C4.5 4.68435 5.173 4.01135 6.75 4.01135H16.75C18.327 4.01135 19 4.68435 19 6.26135V18.2614ZM11.75 12.0114C13.267 12.0114 14.5 10.7774 14.5 9.26135C14.5 7.74535 13.267 6.51135 11.75 6.51135C10.233 6.51135 9 7.74535 9 9.26135C9 10.7774 10.233 12.0114 11.75 12.0114ZM11.75 8.01135C12.439 8.01135 13 8.57235 13 9.26135C13 9.95035 12.439 10.5114 11.75 10.5114C11.061 10.5114 10.5 9.95035 10.5 9.26135C10.5 8.57235 11.061 8.01135 11.75 8.01135ZM16.5 16.6213V17.2614C16.5 17.6754 16.164 18.0114 15.75 18.0114C15.336 18.0114 15 17.6754 15 17.2614V16.6213C15 15.5713 14.2611 14.5114 12.6101 14.5114H10.8889C9.23892 14.5114 8.49902 15.5713 8.49902 16.6213V17.2614C8.49902 17.6754 8.16302 18.0114 7.74902 18.0114C7.33502 18.0114 6.99902 17.6754 6.99902 17.2614V16.6213C6.99902 14.8273 8.33492 13.0114 10.8889 13.0114H12.6101C15.1641 13.0114 16.5 14.8273 16.5 16.6213Z" fill="#494558"/></svg>',
                            'link' => '/contacts/'
                        ],
                    ];
                    foreach ($main_menu_about as $menu_item) { ?>
                        <a href="<?= get_site_url() . $menu_item['link']; ?>" class="main-menu__section__links-item transition-default d-flex align-items-center">
                            <div class="img-wrapper d-flex justify-content-center align-items-center">
                                <?= $menu_item['svg']; ?>
                            </div>
                            <p class="font-14-20 fw-500"><?= $menu_item['title']; ?></p>
                        </a>
                    <?php } ?>

                </div>
            </section>
        </div>
    </div>
    <div class="header-menu-bg blur-bg transition-default">
        <?php require 'components/catalog-menu.php'; ?>
    </div>
    <div class="header-menu-bg blur-bg transition-default">
        <div class="cart-menu header-menu transition-default d-flex flex-column">
            <div class="cart-menu__head d-flex justify-content-between">
                <h4 class="cart-menu__title font-20-24 fw-600">Ваш кошик</h4>
                <button class="cart-menu__close close-menu" aria-label="Закрити меню">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
                </button>
            </div>
            <div class="cart-menu__body d-flex flex-column flex-grow-1">
                <?php require 'components/cart-menu.php'; ?>
            </div>
        </div>
    </div>
    <div class="header-menu-bg blur-bg transition-default d-flex justify-content-center align-items-center">
        <?php require 'components/login.php'; ?>
    </div>
    <div class="header-menu-bg blur-bg transition-default d-flex justify-content-center align-items-center">
        <div class="lostpassword">
            <div class="lostpassword__head d-flex">
                <h4 class="lostpassword-title font-20-24 fw-600">Відновлення пароля</h4>
                <button class="cart-menu__close close-menu" aria-label="Закрити меню">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
                </button>
            </div>
            <form id="lostpasswordform" class="lostpassword-form" action="<?= wp_lostpassword_url(); ?>" method="post">
                <p class="lostpassword-subtitle font-15-24 fw-500">Щоб відновити пароль ведіть, будь ласка, свою електронну пошту, вказану вами раніше при реєстрації</p>
                <div class="input__wrapper">
                    <label for="lostpass_user_login">Електронна пошта<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                    <input type="text" name="user_login" id="lostpass_user_login" placeholder="Введіть електронну пошту">
                    <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                </div>
                <button type="submit" class="lostpassword-button std-btn purple-btn font-16-22 fw-600 w-100">Відновити пароль</button>
                <button type="button" class="lostpassword-cancel-button std-btn transparent-btn font-16-22 fw-600 d-block">Я згадав(ла) свій пароль</button>
            </form>
            <div class="lostpassword-success">
                <div class="lostpassword-success-image img-wrapper-contain">
                    <img src="<?php bloginfo('template_url') ?>/images/noinfo.png" alt="success">
                </div>
                <p class="lostpassword-success-text font-15-24 fw-500 text-center">На вказану електронну пошту було надіслано<br>посилання для відновлення вашого паролю. Будь ласка, перевірте вашу пошту</p>
                <button class="lostpassword-success-button std-btn purple-btn font-16-22 fw-600 w-100">Зрозуміло</button>
            </div>
        </div>
    </div>
    <div class="header-menu-bg blur-bg transition-default d-flex justify-content-center align-items-center">
        <div class="success-message text-center">
            <div class="success-message__head d-flex">
                <button class="cart-menu__close close-menu" aria-label="Закрити меню">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
                </button>
            </div>
            <div class="success-message-image img-wrapper-contain">
                <img src="<?php bloginfo('template_url'); ?>/images/shield.png" alt="success">
            </div>
            <h4 class="success-message-title font-20-24 fw-600">Дякуємо!</h4>
            <?php $order_number = isset($_GET['success-order']) ? ' №' . $_GET['success-order'] : ''; ?>
            <p class="success-message-text font-14-20 fw-500">Ваше замовлення<?= $order_number ?> успішно оформлене. Очікуйте відправку протягом 1-2 днів</p>
            <button type="button" class="success-message-button std-btn purple-btn font-16-22 fw-600 w-100">Продовжити покупки</button>
        </div>
    </div>
<?php }