<?php if (isset ($product) && $product->is_in_stock()) {
    if(WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id(get_the_ID()))) { ?>
        <button class="buy-button buy-button--cart std-btn blue-btn font-16-22 fw-600 transition-default d-flex justify-content-center align-items-center" data-id="<?= $product->get_id(); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M21.8327 14.8306L21.8325 14.8315C21.6915 15.6066 21.4445 16.4439 20.8545 17.0873C20.2627 17.7326 19.3325 18.1758 17.84 18.1758H9.00916C7.53241 18.1758 6.26022 17.0732 6.05159 15.6105L4.43839 4.32358C4.34791 3.69431 3.80172 3.22014 3.16641 3.22014H2.88329C2.41338 3.22014 2.03203 2.83879 2.03203 2.36888C2.03203 1.89897 2.41338 1.51763 2.88329 1.51763H3.16746C4.64418 1.51763 5.91635 2.62024 6.12502 4.08285L21.8327 14.8306ZM21.8327 14.8306L22.9157 8.24413C22.9157 8.24398 22.9158 8.24384 22.9158 8.24369C23.0754 7.37027 22.8397 6.47724 22.2715 5.79613L22.2331 5.82816L22.2715 5.79612C21.7022 5.11381 20.8654 4.72265 19.9767 4.72265H6.21705L6.12502 4.08291L21.8327 14.8306ZM6.45895 6.42408H19.9757C20.3582 6.42408 20.717 6.59266 20.9629 6.8859C21.2085 7.17871 21.3095 7.56311 21.2384 7.95265L21.2383 7.95351L20.54 12.1999H13.5667C13.0968 12.1999 12.7154 12.5813 12.7154 13.0512C12.7154 13.5211 13.0968 13.9025 13.5667 13.9025H20.2597L20.1551 14.5412C20.1551 14.5413 20.155 14.5415 20.155 14.5416C20.034 15.2084 19.8715 15.6872 19.5368 16.0014C19.2031 16.3147 18.6884 16.4733 17.84 16.4733H9.00916C8.37386 16.4733 7.82756 15.9992 7.73705 15.3699L6.45895 6.42408ZM6.45895 6.42408L7.73705 15.3699L6.45895 6.42408ZM9.31471 22.9833C10.0795 22.9833 10.7001 22.3627 10.7001 21.5979C10.7001 20.8332 10.0795 20.2125 9.31471 20.2125H9.30402C8.53899 20.2125 7.92394 20.8334 7.92394 21.5979C7.92394 22.363 8.5513 22.9833 9.31471 22.9833ZM17.8614 20.2125H17.8507C17.0857 20.2125 16.4707 20.8334 16.4707 21.5979C16.4707 22.363 17.0969 22.9833 17.8614 22.9833C18.6262 22.9833 19.2469 22.3627 19.2469 21.5979C19.2469 20.8332 18.6262 20.2125 17.8614 20.2125Z" stroke-width="0.1"/>
            </svg>
            Перейти до кошика
        </button>
    <?php } else { ?>
        <button class="buy-button buy-button--buy std-btn purple-btn font-16-22 fw-600 transition-default d-block" data-id="<?= $product->get_id(); ?>">Купити</button>
    <?php }
} else { ?>
    <button class="buy-button buy-button--msg std-btn purple-btn font-16-22 fw-600 transition-default disabled-link d-block">Повідомити про появу</button>
<?php } ?>