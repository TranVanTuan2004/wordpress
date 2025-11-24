<?php
/**
 * Template for displaying comments for movies
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="movie-comments-section">
    <h2 class="comments-title">
        <?php
        $comments_number = get_comments_number();
        if ($comments_number > 0) {
            printf(
                _n('%s bình luận', '%s bình luận', $comments_number, 'movie'),
                number_format_i18n($comments_number)
            );
        } else {
            echo 'Chưa có bình luận nào';
        }
        ?>
    </h2>

    <?php if (have_comments()) : ?>
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback'    => 'movie_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_pagination(array(
            'prev_text' => '<i class="bx bx-chevron-left"></i> ' . __('Trước', 'movie'),
            'next_text' => __('Sau', 'movie') . ' <i class="bx bx-chevron-right"></i>',
        ));
        ?>
    <?php endif; ?>

    <?php
    // Force enable comments for movies
    global $post;
    if ($post && $post->post_type === 'mbs_movie' && !comments_open()) {
        // Nếu comments bị đóng, vẫn hiển thị form
    }
    ?>

    <?php
    // Custom comment form
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $comment_form_args = array(
        'title_reply'          => 'Viết bình luận',
        'title_reply_to'       => 'Trả lời %s',
        'cancel_reply_link'    => '<i class="bx bx-x"></i> Hủy',
        'label_submit'         => 'Gửi bình luận',
        'comment_field'        => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="Viết bình luận của bạn..." aria-required="true"></textarea></div>',
        'fields'               => array(
            'author' => '<div class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' placeholder="Tên của bạn *" /></div>',
            'email'  => '<div class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' placeholder="Email của bạn *" /></div>',
        ),
        'comment_notes_before' => '<p class="comment-notes">Email của bạn sẽ không được hiển thị công khai.</p>',
        'comment_notes_after'  => '',
        'class_submit'         => 'submit-comment-btn',
    );

    comment_form($comment_form_args);
    ?>
</div>

<?php
/**
 * Custom comment callback
 */
function movie_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar($comment, 50); ?>
            </div>
            <div class="comment-content">
                <div class="comment-meta">
                    <span class="comment-author-name">
                        <?php comment_author_link(); ?>
                    </span>
                    <span class="comment-date">
                        <i class="bx bx-time"></i>
                        <?php
                        printf(
                            __('%1$s lúc %2$s', 'movie'),
                            get_comment_date(),
                            get_comment_time()
                        );
                        ?>
                    </span>
                    <?php if ($comment->comment_approved == '0') : ?>
                        <span class="comment-awaiting-moderation">(Bình luận đang chờ duyệt)</span>
                    <?php endif; ?>
                </div>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                <div class="comment-actions">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => '<i class="bx bx-reply"></i> Trả lời'
                    )));
                    ?>
                </div>
            </div>
        </div>
    <?php
}
?>

