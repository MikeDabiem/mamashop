<?php
$fav_btn_classes = $fav_btn_classes ?? '';
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'favorites');
    $class_active = in_array($id, $favorites) ? 'active' : '';
    $fav_id = "fav-$id";
} else {
    $fav_id = 'login';
}
?>
<button data-id="<?= $fav_id ?>" class="add-to-fav <?= $fav_btn_classes ?> <?= $class_active ?>" aria-label="Додати до улюбленого">
    <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/></svg>
</button>