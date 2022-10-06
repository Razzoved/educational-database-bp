<?php 
echo '<div class="section top-materials">';
	echo '<h2>TOP materials: </h2>';
		$args = array(
			'meta_key' => 'stars',
			'meta_query' => array(
								array(
									'key'     => 'stars',
									'value'   => '0',
									'compare' => '>'
								)
							)
		);
		$comments = get_comments( $args );
		$bests = array();
		$bestsAvg = array();
		$top_count = get_option('ll_top_materials_count', '5');

		foreach ($comments as $comment) {
			$starsCount = get_comment_meta( $comment->comment_ID, $key = 'stars', $single = true );
			$postID = $comment->comment_post_ID;
			if (!array_key_exists($postID, $bests)) {
				$bests[$postID] = array('comments_count' => 1, 'stars_count' => $starsCount, 'avg' => $starsCount);
				$bestsAvg[$postID] = $starsCount;
			}else {
				//pocet hvezdicek u komentare
				$bests[$postID]['stars_count'] = $bests[$postID]['stars_count'] + $starsCount;
				$bests[$postID]['comments_count'] = $bests[$postID]['comments_count'] + 1;
				$bests[$postID]['avg'] = $bests[$postID]['stars_count'] / $bests[$postID]['comments_count'];
				$bestsAvg[$postID] = $bests[$postID]['avg'];
			}				 
		}
		arsort($bestsAvg);
		if (sizeof($bests) >= $top_count) {
			$bestsAvg = array_slice($bestsAvg, 0, $top_count, true);							
		}
		
		$args = array(
			'post__in'     => array_keys($bestsAvg),
			'post_type' => 'materials',
			'order'               => 'DESC',
			'orderby'=>'post__in',
			'posts_per_page' => $top_count
		);		
		$bestsMaterials = new WP_Query( $args );

		while ( $bestsMaterials->have_posts() ) : $bestsMaterials->the_post();
			include('material-item-template.php');
		endwhile; 
echo '</div>';
