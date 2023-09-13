<?php $cart_items_count = absint(WC()->cart->get_cart_contents_count()); ?>
<p class="cart-menu__value font-14-20 fw-500"><?= $cart_items_count; ?> <?= true_wordform($cart_items_count, 'товар', 'товари', 'товарів'); ?></p>
<?php if ($cart_items_count < 1) { ?>
    <div class="cart-menu__empty-cart text-center">
        <div class="empty-cart__image img-wrapper-contain">
            <img src="<?php bloginfo('template_url'); ?>/images/cart-empty.png" alt="Кошик порожній">
        </div>
        <h4 class="empty-cart-title font-20-24 fw-600">Ваш кошик порожній</h4>
        <div class="empty-cart-subtitle font-14-20 fw-400">Додайте свій перший товар</div>
        <a href="<?= get_home_url(); ?>/shop/" class="empty-cart__button std-btn purple-btn d-block">За покупками</a>
    </div>
<?php } else { ?>
    <div class="cart-menu__products">
        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $id = $cart_item['data']->id;
            $product = wc_get_product($id);
            $product_url = get_permalink($id);
            $name = $cart_item['data']->name;
            $brand = $product->get_attribute('pa_brand');
            $brand_slug = wc_get_product_terms($id, 'pa_brand')[0]->slug;
            $quantity = $cart_item['quantity'];
            $price = $cart_item['data']->regular_price;
            $sale_price = $cart_item['data']->sale_price;
            $sale_val = get_post_meta($id, '_discount_value', true);
            $image_id = $cart_item['data']->image_id;
            $image_url = wp_get_attachment_image_url($image_id, 'medium');
            $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true); ?>
            <div class="cart-menu__products__item d-flex align-items-center">
                <a href="<?= $product_url; ?>" class="item-image img-wrapper-contain d-block">
                    <?php if ($image_url) { ?>
                        <img src="<?= $image_url; ?>" alt="<?= $alt; ?>">
                    <?php } else { ?>
                        <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image">
                    <?php } ?>
                </a>
                <div class="item__info d-flex flex-column justify-content-between">
                    <div class="item__info__top d-flex justify-content-between">
                        <div class="item__name">
                            <a href="<?= $product_url; ?>" class="item__name-title font-13-16 fw-500 transition-default d-block"><?= $name; ?></a>
                            <a href="<?= wc_get_page_permalink('shop') . '?pa_brand=' . $brand_slug ?>" class="item__name-subtitle font-12-16 fw-500 transition-default d-block"><?= $brand; ?></a>
                        </div>
                        <button class="delete-cart-item align-self-start" data-key="<?= $cart_item_key; ?>" data-id="<?= $id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M3 6.13333C2.50294 6.13333 2.1 6.53627 2.1 7.03333C2.1 7.53038 2.50294 7.93333 3 7.93333V6.13333ZM21 7.93333C21.4971 7.93333 21.9 7.53038 21.9 7.03333C21.9 6.53627 21.4971 6.13333 21 6.13333V7.93333ZM5 7.03333V6.13333H4.1V7.03333H5ZM19 7.03333H19.9V6.13333H19V7.03333ZM18.3418 16.831L19.2065 17.0806L18.3418 16.831ZM13.724 20.8561L13.8739 21.7435V21.7435L13.724 20.8561ZM10.276 20.8561L10.426 19.9687H10.426L10.276 20.8561ZM10.1183 20.8294L9.9683 21.7168H9.96831L10.1183 20.8294ZM5.65815 16.831L4.79346 17.0806L5.65815 16.831ZM13.8817 20.8294L13.7318 19.942L13.8817 20.8294ZM7.84254 5.49012L8.65949 5.86773L7.84254 5.49012ZM8.81802 4.18185L8.21739 3.5116V3.5116L8.81802 4.18185ZM10.2779 3.3077L10.5911 4.15144V4.15144L10.2779 3.3077ZM13.7221 3.3077L14.0353 2.46395V2.46395L13.7221 3.3077ZM16.1575 5.49012L16.9744 5.11251V5.11251L16.1575 5.49012ZM3 7.93333H21V6.13333H3V7.93333ZM13.7318 19.942L13.574 19.9687L13.8739 21.7435L14.0317 21.7168L13.7318 19.942ZM10.426 19.9687L10.2682 19.942L9.96831 21.7168L10.1261 21.7435L10.426 19.9687ZM18.1 7.03333V12.1766H19.9V7.03333H18.1ZM5.9 12.1766V7.03333H4.1V12.1766H5.9ZM18.1 12.1766C18.1 13.6672 17.8903 15.1503 17.4771 16.5814L19.2065 17.0806C19.6665 15.4871 19.9 13.836 19.9 12.1766H18.1ZM13.574 19.9687C12.5319 20.1448 11.4681 20.1448 10.426 19.9687L10.126 21.7435C11.3667 21.9531 12.6333 21.9531 13.8739 21.7435L13.574 19.9687ZM10.2682 19.942C8.48759 19.6411 7.02985 18.3377 6.52284 16.5814L4.79346 17.0806C5.4905 19.4953 7.4993 21.2996 9.9683 21.7168L10.2682 19.942ZM6.52284 16.5814C6.10972 15.1503 5.9 13.6672 5.9 12.1766H4.1C4.1 13.836 4.33346 15.4871 4.79346 17.0806L6.52284 16.5814ZM14.0317 21.7168C16.5007 21.2996 18.5095 19.4953 19.2065 17.0806L17.4771 16.5814C16.9701 18.3377 15.5124 19.6411 13.7318 19.942L14.0317 21.7168ZM8.4 7.03333C8.4 6.63653 8.48705 6.24079 8.65949 5.86773L7.02559 5.1125C6.74574 5.71796 6.6 6.37098 6.6 7.03333H8.4ZM8.65949 5.86773C8.8321 5.4943 9.08825 5.14819 9.41865 4.8521L8.21739 3.5116C7.71207 3.96443 7.30528 4.50742 7.02559 5.1125L8.65949 5.86773ZM9.41865 4.8521C9.74925 4.55584 10.1469 4.31633 10.5911 4.15144L9.96473 2.46395C9.317 2.70438 8.72251 3.05894 8.21739 3.5116L9.41865 4.8521ZM10.5911 4.15144C11.0354 3.98655 11.5144 3.90073 12 3.90073V2.10073C11.3038 2.10073 10.6124 2.22353 9.96473 2.46395L10.5911 4.15144ZM12 3.90073C12.4856 3.90073 12.9646 3.98655 13.4089 4.15144L14.0353 2.46395C13.3876 2.22353 12.6962 2.10073 12 2.10073V3.90073ZM13.4089 4.15144C13.8531 4.31633 14.2507 4.55584 14.5813 4.8521L15.7826 3.5116C15.2775 3.05894 14.683 2.70438 14.0353 2.46395L13.4089 4.15144ZM14.5813 4.8521C14.9118 5.14819 15.1679 5.4943 15.3405 5.86773L16.9744 5.11251C16.6947 4.50742 16.2879 3.96443 15.7826 3.5116L14.5813 4.8521ZM15.3405 5.86773C15.5129 6.2408 15.6 6.63653 15.6 7.03333H17.4C17.4 6.37098 17.2543 5.71796 16.9744 5.11251L15.3405 5.86773ZM5 7.93333H19V6.13333H5V7.93333Z" fill="#494558"/>
                                <path d="M10 12.0007V16.0007M14 12.0007V16.0007" stroke="#494558" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                    <div class="item__info__bottom d-flex justify-content-between">
                        <div class="item__qty d-flex align-items-center">
                            <button class="item__qty-button qty_minus" data-key="<?= $cart_item_key; ?>" <?php $quantity < 2 ? print 'disabled' : null; ?>></button>
                            <input type="number" class="item__qty-num font-14-20 fw-500" value="<?= $quantity; ?>" disabled>
                            <button class="item__qty-button qty_plus" data-key="<?= $cart_item_key; ?>"></button>
                        </div>
                        <div class="item__price">
                            <?php if ($sale_price) { ?>
                                <div class="item__price__discount">
                                    <span class="item__price__discount-value font-9-11 fw-400 text-decoration-line-through"><?= $price; ?> грн</span>
                                    <span class="item__price__discount-percent font-11-13 fw-600">-<?= $sale_val; ?>%</span>
                                </div>
                            <?php } ?>
                            <p class="item__price-value font-15-18 fw-600 text-end"><?= $sale_price ?: $price; ?> грн</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="cart-menu__footer">
        <?php $cart_total = WC()->cart->get_cart_contents_total(); ?>
        <p class="cart-menu__footer--error error-min font-11-13 fw-400 transition-default <?php $cart_total < 250 ? print 'show' : null; ?>">Мінімальна вартість замовлення складає 250 грн</p>
        <p class="cart-menu__footer--error error-free font-11-13 fw-400 <?php $cart_total > 250 && $cart_total < 500 ? print 'show' : null; ?>">При замовленні на суму більше 500 грн доставка безкоштовна</p>
        <a href="<?= wc_get_checkout_url(); ?>" class="cart-menu__order std-btn font-15-18 fw-600 transition-default d-flex <?php $cart_total < 250 ? print 'disabled-check' : null; ?>">
            <p class="cart-menu__order-text text-center">Оформити замовлення</p>
            <div class="cart-menu__order-price d-flex align-items-center">
                <p><?= $cart_total; ?> грн</p>
            </div>
        </a>
    </div>
<?php }