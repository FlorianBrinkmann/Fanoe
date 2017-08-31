<?php
/**
 * Comments template.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

if ( post_password_required() ) {
	return;
} ?>
<aside aria-labelledby="aside" id="comments" class="comments-area">
	<?php if ( have_comments() ) {
		/**
		 * We cannot use the second parameter from comments_template()
		 * to separate the reactions because if they are
		 * broken on multiple pages, the count() would only return
		 * the number of comments and pings which are displayed
		 * on the current page, not the total.
		 *
		 * Because of that, we use our own function to get the comments by type.
		 */
		$comments_by_type = fanoe_get_comments_by_type();
		if ( ! empty( $comments_by_type['comment'] ) ) {
			/**
			 * Save the comment count.
			 */
			$comment_number = count( $comments_by_type['comment'] ); ?>
			<h2 class="comments-title" id="comments-title">
				<?php printf( /* translators: Title for comment list. 1=comment number, 2=post title */
					_n(
						'%1$s Comment on “%2$s”',
						'%1$s Comments on “%2$s”',
						$comment_number,
						'fanoe'
					),
					number_format_i18n( $comment_number ),
					get_the_title() ); ?>
			</h2>

			<ul class="commentlist">
				<?php
				/**
				 * We need to specify the per_page key because otherwise
				 * the separated reactions would not be broken correctly into
				 * multiple pages.
				 */
				wp_list_comments( [
					'callback' => 'fanoe_comment',
					'style'    => 'ul',
					'type'     => 'comment',
					'per_page' => $comment_args['number'],
				] ); ?>
			</ul>
		<?php }
		if ( ! empty( $comments_by_type['pings'] ) ) {
			/**
			 * Save the count of trackbacks and pingbacks.
			 */
			$trackback_number = count( $comments_by_type['pings'] ); ?>
			<h2 class="trackbacks-title" id="trackbacks-title">
				<?php printf( /* translators: Title for trackback list. 1=trackback number, 2=post title */
					_n(
						'%1$s Trackback on “%2$s”',
						'%1$s Trackbacks on “%2$s”',
						$trackback_number,
						'fanoe'
					),
					number_format_i18n( $trackback_number ),
					get_the_title() ); ?>
			</h2>

			<ul class="commentlist">
				<?php
				/**
				 * Display the pings in short version.
				 */
				wp_list_comments( [
					'type'       => 'pings',
					'short_ping' => true,
					'per_page'   => $comment_args['number'],
				] ); ?>
			</ul>
		<?php }
		/**
		 * Only show the comments navigation if one of the reaction counts
		 * is larger than the set number of comments per page. Necessary because
		 * of our separation. Otherwise, the navigation would also be displayed if
		 * we should display 4 comments per page and have 3 comments and 2 trackbacks.
		 */
		if ( ( isset( $trackback_number ) && $trackback_number > $comment_args['number'] ) || ( isset( $comment_number ) && $comment_number > $comment_args['number'] ) ) {
			the_comments_navigation();
		}

		/**
		 * Display comments closed hint if comments are closed but we already have comments.
		 */
		if ( ! comments_open() && get_comments_number() ) { ?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'fanoe' ); ?></p>
		<?php }
	} // End if().

	/**
	 * Display comment form with modified submit label.
	 */
	comment_form( [
		'label_submit' => __( 'Submit Comment', 'fanoe' ),
	] ); ?>
</aside>
