<?php if (isset($args['question']) && isset($args['prod_id'])) {
    $question = $args['question'];
    $product_id = $args['prod_id'];
}
$comment_id = $question->comment_ID;
$q_user = get_userdata($question->user_id);
$name = $q_user->display_name;
$date = get_comment_date('d.m.Y', $question->comment_ID);
$question_content = $question->comment_content; ?>
<div class="questions__item">
    <div class="questions__item-head d-flex justify-content-between">
        <h4 class="questions__item-name font-15-18 fw-500"><?= $name ?></h4>
        <time class="questions__item-date font-11-13 fw-400"><?= $date ?></time>
    </div>
    <p class="questions__item-status font-11-13 fw-400">Покупець</p>
    <p class="questions__item-text font-13-16 fw-400"><?= $question_content ?></p>
    <div class="questions__item__answer">
        <?php $answers = get_approved_comments($product_id, ['parent' => $comment_id]);
        foreach ($answers as $answer) {
            $date = get_comment_date('d.m.Y', $question->comment_ID);
            $answer_content = $answer->comment_content; ?>
            <div class="answer__head d-flex justify-content-between">
                <div class="answer__head__text d-flex align-items-baseline">
                    <h5 class="answer-name font-13-16 fw-500">Представник Mamashop</h5>
                    <span class="answer-status font-11-13 fw-400">Відповідь</span>
                </div>
                <time class="questions__item-date font-11-13 fw-400"><?= $date ?></time>
            </div>
            <p class="answer-text font-13-16 fw-400"><?= $answer_content ?></p>
        <?php } ?>
    </div>
</div>