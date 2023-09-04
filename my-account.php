<?php /* Template Name: Account Template */
if (is_user_logged_in()) {
get_header();
global $wp;
$user_id = get_current_user_id();
$user = get_userdata($user_id); ?>
<div class="account-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <div class="account-page__content d-flex justify-content-between">
        <div class="account-page__col1">
            <div class="account__avatar d-flex align-items-center">
                <div class="account__avatar-image img-wrapper-contain">
                    <img src="<?= get_avatar_url($user_id); ?>" alt="avatar">
                </div>
                <div class="account__avatar__info">
                    <p class="account__avatar-name font-15-24 fw-600"><?= esc_attr($user->display_name) ?></p>
                    <p class="account__avatar-email font-14-20 fw-400"><?= esc_attr($user->user_email); ?></p>
                </div>
            </div>
            <nav class="account-page__menu">
                <?php $account_menu_arr = [
                    'edit-account' => [
                        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M15.75 9C15.75 10.7949 14.2949 12.25 12.5 12.25V13.75C15.1234 13.75 17.25 11.6234 17.25 9H15.75ZM12.5 12.25C10.7051 12.25 9.25 10.7949 9.25 9H7.75C7.75 11.6234 9.87665 13.75 12.5 13.75V12.25ZM9.25 9C9.25 7.20507 10.7051 5.75 12.5 5.75V4.25C9.87665 4.25 7.75 6.37665 7.75 9H9.25ZM12.5 5.75C14.2949 5.75 15.75 7.20507 15.75 9H17.25C17.25 6.37665 15.1234 4.25 12.5 4.25V5.75ZM9.5 16.75H15.5V15.25H9.5V16.75ZM3.25 12C3.25 6.89137 7.39137 2.75 12.5 2.75V1.25C6.56294 1.25 1.75 6.06294 1.75 12H3.25ZM12.5 2.75C17.6086 2.75 21.75 6.89137 21.75 12H23.25C23.25 6.06294 18.4371 1.25 12.5 1.25V2.75ZM21.75 12C21.75 14.6233 20.659 16.9905 18.9039 18.6748L19.9425 19.7571C21.9801 17.8016 23.25 15.0485 23.25 12H21.75ZM18.9039 18.6748C17.2412 20.2705 14.9858 21.25 12.5 21.25V22.75C15.3882 22.75 18.0117 21.61 19.9425 19.7571L18.9039 18.6748ZM15.5 16.75C17.076 16.75 18.3915 17.8726 18.6876 19.3621L20.1588 19.0697C19.726 16.8918 17.8055 15.25 15.5 15.25V16.75ZM12.5 21.25C10.0142 21.25 7.75884 20.2705 6.09612 18.6748L5.05751 19.7571C6.98833 21.61 9.61182 22.75 12.5 22.75V21.25ZM6.09612 18.6748C4.34103 16.9905 3.25 14.6233 3.25 12H1.75C1.75 15.0485 3.01989 17.8016 5.05751 19.7571L6.09612 18.6748ZM9.5 15.25C7.19445 15.25 5.27403 16.8918 4.8412 19.0697L6.31243 19.3621C6.60846 17.8726 7.92396 16.75 9.5 16.75V15.25Z" stroke="none"/></svg>',
                        'title' => 'Персональні дані',
                    ],
                    'orders' => [
                        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M19.7178 15.0616L19.6005 14.3208H19.6005L19.7178 15.0616ZM15.5616 19.2178L14.8208 19.1005V19.1005L15.5616 19.2178ZM5.56107 20.0451L6.00191 19.4383L5.56107 20.0451ZM4.45491 18.9389L5.06168 18.4981L4.45491 18.9389ZM20.5451 18.9389L21.1518 19.3798L20.5451 18.9389ZM19.4389 20.0451L19.8798 20.6518L19.4389 20.0451ZM19.4389 3.95491L18.9981 4.56168L19.4389 3.95491ZM20.5451 5.06107L19.9383 5.50191L20.5451 5.06107ZM5.56107 3.95491L6.00191 4.56168L5.56107 3.95491ZM4.45491 5.06107L5.06168 5.50191L4.45491 5.06107ZM21.4711 15L22.2206 15.0257L21.4711 15ZM15.5 20.9711L15.5257 21.7206L15.5 20.9711ZM8.5 15.25C8.08579 15.25 7.75 15.5858 7.75 16C7.75 16.4142 8.08579 16.75 8.5 16.75V15.25ZM11.5 16.75C11.9142 16.75 12.25 16.4142 12.25 16C12.25 15.5858 11.9142 15.25 11.5 15.25V16.75ZM8.5 11.25C8.08579 11.25 7.75 11.5858 7.75 12C7.75 12.4142 8.08579 12.75 8.5 12.75V11.25ZM16.5 12.75C16.9142 12.75 17.25 12.4142 17.25 12C17.25 11.5858 16.9142 11.25 16.5 11.25V12.75ZM8.5 7.25C8.08579 7.25 7.75 7.58579 7.75 8C7.75 8.41421 8.08579 8.75 8.5 8.75V7.25ZM11.5 8.75C11.9142 8.75 12.25 8.41421 12.25 8C12.25 7.58579 11.9142 7.25 11.5 7.25V8.75ZM19.6005 14.3208C17.1401 14.7105 15.2105 16.6401 14.8208 19.1005L16.3023 19.3352C16.5904 17.5166 18.0166 16.0904 19.8352 15.8023L19.6005 14.3208ZM12.5 20.25C10.6084 20.25 9.24999 20.249 8.19804 20.135C7.16013 20.0225 6.50992 19.8074 6.00191 19.4383L5.12023 20.6518C5.92656 21.2377 6.87094 21.5 8.03648 21.6263C9.18798 21.751 10.6418 21.75 12.5 21.75V20.25ZM2.75 12C2.75 13.8582 2.74897 15.312 2.87373 16.4635C3.00001 17.6291 3.26232 18.5734 3.84815 19.3798L5.06168 18.4981C4.69259 17.9901 4.47745 17.3399 4.365 16.302C4.25103 15.25 4.25 13.8916 4.25 12H2.75ZM6.00191 19.4383C5.64111 19.1762 5.32382 18.8589 5.06168 18.4981L3.84815 19.3798C4.20281 19.8679 4.63209 20.2972 5.12023 20.6518L6.00191 19.4383ZM19.9383 18.4981C19.6762 18.8589 19.3589 19.1762 18.9981 19.4383L19.8798 20.6518C20.3679 20.2972 20.7972 19.8679 21.1518 19.3798L19.9383 18.4981ZM12.5 3.75C14.3916 3.75 15.75 3.75103 16.802 3.865C17.8399 3.97745 18.4901 4.19259 18.9981 4.56168L19.8798 3.34815C19.0734 2.76232 18.1291 2.50001 16.9635 2.37373C15.812 2.24897 14.3582 2.25 12.5 2.25V3.75ZM22.25 12C22.25 10.1418 22.251 8.68798 22.1263 7.53648C22 6.37094 21.7377 5.42656 21.1518 4.62023L19.9383 5.50191C20.3074 6.00992 20.5225 6.66013 20.635 7.69804C20.749 8.74999 20.75 10.1084 20.75 12H22.25ZM18.9981 4.56168C19.3589 4.82382 19.6762 5.14111 19.9383 5.50191L21.1518 4.62023C20.7972 4.13209 20.3679 3.70281 19.8798 3.34815L18.9981 4.56168ZM12.5 2.25C10.6418 2.25 9.18798 2.24897 8.03648 2.37373C6.87094 2.50001 5.92656 2.76232 5.12023 3.34815L6.00191 4.56168C6.50992 4.19259 7.16013 3.97745 8.19804 3.865C9.24999 3.75103 10.6084 3.75 12.5 3.75V2.25ZM4.25 12C4.25 10.1084 4.25103 8.74999 4.365 7.69804C4.47745 6.66013 4.69259 6.00992 5.06168 5.50191L3.84815 4.62023C3.26232 5.42656 3.00001 6.37094 2.87373 7.53648C2.74897 8.68798 2.75 10.1418 2.75 12H4.25ZM5.12023 3.34815C4.63209 3.70281 4.20281 4.13209 3.84815 4.62023L5.06168 5.50191C5.32382 5.14111 5.64111 4.82382 6.00191 4.56168L5.12023 3.34815ZM20.75 12C20.75 13.1731 20.7499 14.1456 20.7215 14.9743L22.2206 15.0257C22.2501 14.1658 22.25 13.1648 22.25 12H20.75ZM20.7215 14.9743C20.658 16.8292 20.4509 17.7925 19.9383 18.4981L21.1518 19.3798C21.9537 18.2761 22.1564 16.8991 22.2206 15.0257L20.7215 14.9743ZM21.4711 14.25C20.5888 14.25 20.0579 14.2484 19.6005 14.3208L19.8352 15.8023C20.147 15.7529 20.5338 15.75 21.4711 15.75L21.4711 14.25ZM12.5 21.75C13.6648 21.75 14.6658 21.7501 15.5257 21.7206L15.4743 20.2215C14.6456 20.2499 13.6731 20.25 12.5 20.25V21.75ZM15.5257 21.7206C17.3991 21.6564 18.7761 21.4537 19.8798 20.6518L18.9981 19.4383C18.2925 19.9509 17.3292 20.158 15.4743 20.2215L15.5257 21.7206ZM16.25 20.9711C16.25 20.0338 16.2529 19.647 16.3023 19.3352L14.8208 19.1005C14.7484 19.5579 14.75 20.0888 14.75 20.9711L16.25 20.9711ZM8.5 16.75H11.5V15.25H8.5V16.75ZM8.5 12.75H16.5V11.25H8.5V12.75ZM8.5 8.75H11.5V7.25H8.5V8.75Z" stroke="none"/></svg>',
                        'title' => 'Мої замовлення'
                    ],
                    'favorites' => [
                        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="20" viewBox="0 0 23 20" fill="none"><path d="M18.4998 6.77673C18.293 6.10613 17.9226 5.47603 17.3545 4.91284C16.9073 4.46941 16.4431 4.17698 15.9774 4M9.89909 2.14593C8.22542 1.08425 5.52249 0.0803204 3.18828 2.46071C-2.35272 8.11136 7.1496 19 11.4997 19C15.8499 19 25.3523 8.11136 19.8112 2.46072C17.4771 0.0803466 14.7741 1.08427 13.1005 2.14593C12.1548 2.74582 10.8448 2.74582 9.89909 2.14593Z" stroke-width="1.5" stroke-linecap="round" fill="none"/></svg>',
                        'title' => 'Улюблене'
                    ],
                    'qna' => [
                        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M11.6079 9.85788C11.6079 9.44367 11.9437 9.10788 12.3579 9.10788L16.3579 9.10788C16.7721 9.10788 17.1079 9.44367 17.1079 9.85788C17.1079 10.2721 16.7721 10.6079 16.3579 10.6079H12.3579C11.9437 10.6079 11.6079 10.2721 11.6079 9.85788Z" stroke="none"/><path d="M7.60786 13.8579C7.60786 13.4437 7.94365 13.1079 8.35786 13.1079H16.3579C16.7721 13.1079 17.1079 13.4437 17.1079 13.8579C17.1079 14.2721 16.7721 14.6079 16.3579 14.6079H8.35786C7.94365 14.6079 7.60786 14.2721 7.60786 13.8579Z" stroke="none"/><path fill-rule="evenodd" clip-rule="evenodd" d="M4.8986 4.3986C9.09674 0.200466 15.9033 0.200466 20.1014 4.3986C21.335 5.63222 22.463 7.52758 22.9682 9.63953C23.4759 11.762 23.3653 14.1588 22.0286 16.322C21.9592 16.4342 21.9149 16.5061 21.8832 16.5604C21.8618 16.5972 21.8536 16.6136 21.8519 16.617C21.8377 16.6534 21.8362 16.6657 21.836 16.6668C21.8357 16.6685 21.8336 16.6821 21.8368 16.7238C21.8362 16.7165 21.8359 16.7239 21.8459 16.7682C21.8566 16.8152 21.8725 16.877 21.8996 16.9814L21.9064 17.0079C22.0636 17.6143 22.1911 18.1063 22.2658 18.5023C22.3409 18.9006 22.381 19.2871 22.3053 19.659C22.0852 20.7402 21.2402 21.5852 20.159 21.8053C19.7871 21.881 19.4006 21.8409 19.0023 21.7658C18.6063 21.6911 18.1143 21.5636 17.5079 21.4064L17.4814 21.3996C17.377 21.3725 17.3152 21.3566 17.2682 21.3459C17.2384 21.3392 17.2253 21.3372 17.2222 21.3367C17.1813 21.3337 17.1683 21.3359 17.1666 21.3362C17.1651 21.3364 17.1525 21.3381 17.1166 21.3521C17.1132 21.3538 17.097 21.362 17.0606 21.3833C17.0068 21.4149 16.9356 21.459 16.8241 21.5283C14.6701 22.8669 12.2994 23.0062 10.1821 22.5086C8.07586 22.0136 6.17827 20.8811 4.8986 19.6014C0.700466 15.4033 0.700466 8.59674 4.8986 4.3986ZM19.0407 5.45926C15.4284 1.84691 9.57161 1.84691 5.95926 5.45926C2.34691 9.07161 2.34691 14.9284 5.95926 18.5407C7.04798 19.6295 8.69937 20.6193 10.5253 21.0484C12.3402 21.475 14.285 21.3402 16.0323 20.2543C16.0482 20.2445 16.064 20.2346 16.0798 20.2247C16.2457 20.1213 16.41 20.0189 16.5572 19.9603C16.8207 19.8554 17.0559 19.8195 17.3386 19.8412C17.4962 19.8533 17.6598 19.896 17.8166 19.9368C17.8304 19.9404 17.8441 19.944 17.8578 19.9475C18.497 20.1132 18.9399 20.2276 19.2803 20.2918C19.6241 20.3566 19.7786 20.352 19.8598 20.3354C20.3513 20.2354 20.7354 19.8513 20.8354 19.3598C20.852 19.2786 20.8566 19.1241 20.7918 18.7803C20.7276 18.4399 20.6132 17.997 20.4475 17.3578C20.444 17.3441 20.4404 17.3303 20.4368 17.3165C20.396 17.1598 20.3534 16.9965 20.3413 16.8394C20.3194 16.557 20.3547 16.3235 20.459 16.0602C20.5172 15.9133 20.6194 15.7484 20.7229 15.5814C20.7328 15.5654 20.7427 15.5494 20.7526 15.5335C21.832 13.7868 21.9475 11.8201 21.5093 9.98851C21.0687 8.14644 20.0788 6.4973 19.0407 5.45926Z" stroke="none"/></svg>',
                        'title' => 'Мої відгуки та питання'
                    ],
                    'security' => [
                        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5256 8.75812C13.8931 6.74729 11.1073 6.74729 10.4748 8.75812C10.3846 9.0448 10.1361 9.21631 9.88024 9.21631C7.77118 9.21631 7.0081 11.93 8.62043 13.1401C8.8426 13.3068 8.94687 13.6157 8.85555 13.906C8.54566 14.8912 8.94312 15.8128 9.62116 16.3217C10.3027 16.8332 11.3039 16.9498 12.1408 16.3217C12.3568 16.1595 12.6436 16.1595 12.8596 16.3217C13.6965 16.9498 14.6977 16.8332 15.3792 16.3217C16.0573 15.8128 16.4547 14.8912 16.1448 13.906C16.0535 13.6157 16.1578 13.3068 16.38 13.1401C17.9923 11.93 17.2292 9.21631 15.1202 9.21631C14.8643 9.21631 14.6158 9.0448 14.5256 8.75812ZM11.9057 9.20819C12.0978 8.59727 12.9026 8.59727 13.0947 9.20819C13.3734 10.094 14.1826 10.7163 15.1202 10.7163C15.4102 10.7163 15.6267 10.8947 15.7147 11.1745C15.8032 11.456 15.7309 11.7518 15.4796 11.9404C14.7362 12.4983 14.4365 13.4739 14.714 14.3561C14.8164 14.6818 14.6938 14.9606 14.4788 15.122C14.2674 15.2807 14.0026 15.304 13.76 15.122C13.0105 14.5594 11.9899 14.5594 11.2404 15.122C10.9978 15.304 10.733 15.2807 10.5216 15.122C10.3066 14.9606 10.184 14.6818 10.2864 14.3561C10.5639 13.4739 10.2642 12.4983 9.52082 11.9404C9.26948 11.7518 9.19715 11.456 9.2857 11.1745C9.3737 10.8947 9.59017 10.7163 9.88024 10.7163C10.8178 10.7163 11.627 10.094 11.9057 9.20819Z" stroke="none"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0631 1.25C8.52129 1.25 7.27141 2.49987 7.27141 4.04167C7.27141 4.75503 6.69312 5.33333 5.97975 5.33333H5.67088C4.09483 5.33333 2.69091 6.55273 2.77642 8.24648C2.87794 10.2575 3.32459 13.3918 4.95375 16.3608C5.41004 17.1923 6.01943 18.0092 6.6782 18.7703L6.72779 18.8276C7.67546 19.9226 8.46562 20.8356 9.31509 21.4579C10.2288 22.1273 11.204 22.4607 12.5003 22.4607C13.7965 22.4607 14.7717 22.1273 15.6854 21.4579C16.5349 20.8356 17.325 19.9226 18.2727 18.8276L18.3223 18.7703C18.9811 18.0092 19.5905 17.1923 20.0468 16.3608C21.7301 13.2931 22.1498 9.82667 22.2326 7.66561C22.2972 5.97999 20.9033 4.75 19.3184 4.75H18.7291C18.1768 4.75 17.7291 4.30228 17.7291 3.75C17.7291 2.36929 16.6098 1.25 15.2291 1.25H10.0631ZM8.77141 4.04167C8.77141 3.3283 9.34971 2.75 10.0631 2.75H15.2291C15.7814 2.75 16.2291 3.19772 16.2291 3.75C16.2291 5.13071 17.3484 6.25 18.7291 6.25H19.3184C20.1561 6.25 20.7619 6.8731 20.7337 7.60819C20.6546 9.67293 20.252 12.8686 18.7317 15.6392C18.3428 16.348 17.8042 17.0768 17.1881 17.7886C16.178 18.9557 15.4959 19.7373 14.7989 20.2479C14.1514 20.7223 13.4891 20.9607 12.5003 20.9607C11.5114 20.9607 10.8491 20.7223 10.2016 20.2479C9.50457 19.7373 8.82248 18.9557 7.81237 17.7886C7.19628 17.0768 6.65772 16.348 6.26878 15.6392C4.79029 12.9448 4.36996 10.0616 4.27451 8.17085C4.23819 7.45149 4.83075 6.83333 5.67088 6.83333H5.97975C7.52154 6.83333 8.77141 5.58346 8.77141 4.04167Z" stroke="none"/></svg>',
                        'title' => 'Безпека'
                    ],
                    'customer-logout' => [
                        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M10.4192 2.25C9.56717 2.24994 9.04819 2.2499 8.60051 2.3208C6.14013 2.71049 4.21049 4.64013 3.8208 7.10051C3.7499 7.54819 3.74994 8.06717 3.75 8.91919L3.75 15.0808C3.74994 15.9328 3.7499 16.4518 3.8208 16.8995C4.21049 19.3599 6.14013 21.2895 8.60051 21.6792C9.04819 21.7501 9.56718 21.7501 10.4192 21.75L11.5 21.75C12.7936 21.75 13.9894 21.3219 14.9504 20.6C15.2816 20.3513 15.3485 19.8811 15.0997 19.5499C14.8509 19.2188 14.3808 19.1519 14.0496 19.4007C13.3393 19.9342 12.4576 20.25 11.5 20.25H10.5C9.54234 20.25 9.15083 20.2477 8.83516 20.1977C7.01662 19.9097 5.59036 18.4834 5.30233 16.6649C5.25234 16.3492 5.25001 15.9577 5.25001 15L5.25001 9.00001C5.25001 8.04234 5.25234 7.65083 5.30233 7.33516C5.59036 5.51662 7.01662 4.09036 8.83516 3.80233C9.15083 3.75234 9.54234 3.75001 10.5 3.75001H11.5C12.4576 3.75001 13.3393 4.06583 14.0496 4.59932C14.3808 4.84808 14.8509 4.78127 15.0997 4.45008C15.3485 4.11888 15.2816 3.64874 14.9504 3.39997C13.9894 2.67807 12.7936 2.25001 11.5 2.25001L10.4192 2.25Z" stroke="none"/><path d="M18.966 7.41232C18.6414 7.15498 18.1697 7.20947 17.9123 7.53404C17.655 7.85861 17.7095 8.33034 18.034 8.58769L19.797 9.98554C20.501 10.5438 20.983 10.9274 21.3105 11.25L8.50001 11.25C8.08579 11.25 7.75001 11.5858 7.75001 12C7.75001 12.4142 8.08579 12.75 8.50001 12.75L21.3105 12.75C20.983 13.0727 20.501 13.4563 19.797 14.0145L18.034 15.4123C17.7095 15.6697 17.655 16.1414 17.9123 16.466C18.1697 16.7905 18.6414 16.845 18.966 16.5877L20.7648 15.1615C21.4372 14.6283 21.9922 14.1883 22.3875 13.7945C22.7932 13.3904 23.1295 12.9419 23.2208 12.3687C23.2402 12.2466 23.25 12.1234 23.25 12C23.25 11.8766 23.2402 11.7534 23.2208 11.6313C23.1295 11.0582 22.7932 10.6096 22.3875 10.2055C21.9922 9.81173 21.4373 9.37176 20.7648 8.83858L18.966 7.41232Z" stroke="none"/></svg>',
                        'title' => 'Вихід'
                    ],
                ];
                foreach ($account_menu_arr as $key => $value) {
                    $active = isset($wp->query_vars[$key]) ? ' current_page' : ''; ?>
                    <a href="<?= esc_url(wc_get_account_endpoint_url($key)); ?>" class="menu__item font-16-22 fw-500 transition-default d-flex align-items-center<?= $active; ?>">
                        <div class="menu__item-image">
                            <?= $value['image']; ?>
                        </div>
                        <?= $value['title']; ?>
                    </a>
                <?php } ?>
            </nav>
        </div>
        <div class="account-page__col2">
            <?php if (is_account_page()) {
                if (isset($wp->query_vars['edit-account'])) { ?>
                    <h2 class="account-page-title font-28-36 fw-600">Персональні данні</h2>
                    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?> >
                        <fieldset class="edit-account__personal d-flex flex-wrap">
                            <legend class="font-16-22 fw-600 w-100 m-0">Особиста інформація</legend>
                            <div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first input__wrapper">
                                <label for="account_first_name"><?php esc_html_e('Ім’я', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default required" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?= esc_attr($user->first_name); ?>" />
                                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                            </div>
                            <div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last input__wrapper">
                                <label for="account_last_name"><?php esc_html_e('Прізвище', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default required" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?= esc_attr($user->last_name); ?>" />
                                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                            </div>
                            <div class="woocommerce-form-row woocommerce-form-row--middle form-row form-row-middle input__wrapper">
                                <label for="account_middle_name"><?php esc_html_e('По-батькові', 'woocommerce'); ?></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default" name="account_middle_name" id="account_middle_name" autocomplete="middle-name" value="<?= esc_attr($user->middle_name); ?>" />
                            </div>
                            <div class="woocommerce-form-row woocommerce-form-row--phone form-row form-row-phone input__wrapper">
                                <label for="account_phone_name"><?php esc_html_e('Телефон', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default required" name="account_phone_name" id="account_phone_name" autocomplete="phone" value="<?= get_user_meta( $user_id, 'billing_phone', true ) ?>" />
                                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                            </div>
                            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input__wrapper d-none">
                                <label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?= esc_attr($user->last_name . ' ' . $user->first_name); ?>" />
                            </div>
                            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input__wrapper">
                                <label for="account_email"><?php esc_html_e('Електронна пошта', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                                <input type="email" class="woocommerce-Input woocommerce-Input--email input-text transition-default required" name="account_email" id="account_email" autocomplete="email" value="<?= esc_attr($user->user_email); ?>" />
                                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                            </div>
                        </fieldset>
                        <fieldset class="edit-account__birthday">
                            <legend class="font-16-22 fw-600 w-100 m-0">Дата народження</legend>
                            <p class="edit-account__birthday-subtitle font-13-16 fw-400">Ми хочемо вас привітати!</p>
                            <div class="input__wrapper">
                                <?php $type = esc_attr($user->birthday) ? 'date' : 'text'; ?>
                                <input type="<?= $type; ?>" class="edit-account__birthday-input woocommerce-Input woocommerce-Input--text input-text font-13-16 fw-400 transition-default" name="birthday" id="birthday" value="<?= esc_attr($user->birthday); ?>" placeholder="ДД.ММ.РРРР" />
                            </div>
                        </fieldset>
                        <p>
                            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                            <button type="submit" class="std-btn purple-btn font-16-22 fw-600 transition-default woocommerce-Button button<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Зберегти зміни', 'woocommerce'); ?>"><?php esc_html_e('Зберегти зміни', 'woocommerce'); ?></button>
                            <input type="hidden" name="action" value="save_account_details" />
                        </p>
                    </form>
                <?php } elseif (isset($wp->query_vars['orders'])) {
                    $customer_orders = get_posts(
                        apply_filters(
                            'woocommerce_my_account_my_orders_query',
                            [
                                'numberposts' => 20,
                                'meta_key'    => '_customer_user',
                                'meta_value'  => $user_id,
                                'post_type'   => wc_get_order_types('view-orders'),
                                'post_status' => array_keys(wc_get_order_statuses()),
                            ]
                        )
                    );
                    require 'components/my-account/orders.php';
                } elseif (isset($wp->query_vars['favorites'])) { ?>
                    <h2 class="account-page-title font-28-36 fw-600">Улюблене</h2>
                    <?php require 'components/my-account/favorites.php'; ?>
                <?php } elseif (isset($wp->query_vars['qna'])) { ?>
                    <h2 class="account-page-title font-28-36 fw-600">Мої відгуки та питання</h2>
                <?php } elseif (isset($wp->query_vars['security'])) { ?>
                    <h2 class="account-page-title font-28-36 fw-600">Безпека</h2>
                    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?> >
                        <legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                        </p>
                        <p>
                            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                            <button type="submit" class="woocommerce-Button button<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                            <input type="hidden" name="action" value="save_account_details" />
                        </p>
                    </form>
                <?php } else {
                    wp_redirect(wc_get_page_permalink('myaccount') . '/edit-account/');
                }
            } ?>
            <?php //the_content(); ?>
        </div>
    </div>
</div>
<?php get_footer();
} else {
    wp_redirect(get_home_url());
}