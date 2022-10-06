<?php
	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' ); 

	$material_id = esc_sql( $_POST['material_id']);

	$secret = get_option('ll_recaptcha_secretkey', '');
	if ($secret != '') {
		require_once "../recaptchalib.php";		
		$response = null;
		$reCaptcha = new ReCaptcha($secret);

		if ($_POST["g-recaptcha-response"]) {
		    $response = $reCaptcha->verifyResponse(
		        $_SERVER["REMOTE_ADDR"],
		        $_POST["g-recaptcha-response"]
		    );
		}

		if (! ($response != null && $response->success)) {
	  		header('Location: '.get_permalink($material_id).'?msg=robot#comments');
	  		die();
		}
	}
	if (isset($_POST['comment_author']) && $_POST['comment_author'] != "") {
		$author = esc_sql( $_POST['comment_author']);
	}else {
		$author = "anonym";
	}

	if (isset($_POST['comment_author_mail']) && $_POST['comment_author_mail'] != "") {
		$mail = esc_sql( $_POST['comment_author_mail']);
	}else {
		$mail = "";
	}

	if (isset($_POST['comment_text']) && $_POST['comment_text'] != "") {
		$text = esc_sql( $_POST['comment_text']);
	}else {
		$text = "";
	}
	
	if (isset($_POST['star_count'])) {
		$stars = esc_sql( $_POST['star_count']);
	}

	$time = current_time('mysql');

	$data = array(
	    'comment_post_ID' => $material_id,
	    'comment_author' => $author,
	    'comment_author_email' => $mail,
	    'comment_author_url' => '',
	    'comment_content' => $text,
	    'comment_type' => '',
	    'comment_parent' => 0,
	    'user_id' => 1,
	    'comment_author_IP' => '',
	    'comment_agent' => '',
	    'comment_date' => $time,
	    'comment_approved' => 1,
	);

	$last_comment_id = wp_insert_comment($data);
	if ($last_comment_id) {
		if(add_comment_meta( $last_comment_id, 'stars', $stars)){
			header('Location: '.get_permalink($material_id).'?msg=added#comments');
		}
	}

?>