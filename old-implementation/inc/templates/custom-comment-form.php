<?php
	echo '<form action="'.plugins_url() . '/e-learning-file-manager/inc/ajax/save-comments.php" method="post" id="material-comment-add">';
		echo '<h3 class="comments-block-title">Add new comment:</h3>';
		echo '<label for="comment_author">Your name: ';
			echo '<input type="text" name="comment_author" placeholder="Your name">';
		echo '</label>';
		echo '<label for="comment_author_mail">Your e-mail:';
			echo '<input type="email" name="comment_author_mail" placeholder="Your e-mail">';
		echo '</label>';
		echo '<label for="comment_text">Comment: ';
			echo '<div class="comment-text-stars stars">';
				for ($i=0; $i < 5; $i++) { 
					echo '<div class="star">';
						include(WP_PLUGIN_DIR.'/e-learning-file-manager/img/star.svg');
					echo '</div>';
				}	
			echo '</div>';
			echo '<textarea name="comment_text"></textarea>';
		echo '</label>';				
		echo '<input type="hidden" id="star_count" name="star_count" value="0">';
		echo '<input type="hidden" id="material_id" name="material_id" value="'.$materialID.'">';		
		echo '<p id="comment_error"></p>';
		if (get_option( 'll_recaptcha_allow', $default = false ) && (get_option( 'll_recaptcha_sitekey', '' ) != '') && (get_option( 'll_recaptcha_secretkey', '' ) != '')) {
			echo '<div class="g-recaptcha" data-sitekey="'.get_option( 'll_recaptcha_sitekey', '' ).'"></div>';
		}
		echo '<input type="submit" id="add_comment_submit" value="Send">';
	echo '</form>';
?>