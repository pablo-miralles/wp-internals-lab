<?php

class Pablo_Lab {

	function report($args, $assoc_args) {

		$raw_number = $assoc_args["post_number"] ?? NULL;
		$number = filter_var( $raw_number, FILTER_VALIDATE_INT );

		if ( $number === false || $number <= -2 ) {
			WP_CLI::error("Please, --post_number is required with a valid number. It needs to be an integer or -1.");
			return;
		}

		if ($number === 0) {
			WP_CLI::warning("Please, --post_number can't be 0. It needs to be an integer or -1.");
			return;
		}
			
		if ( $number >= -1 ) {

			$posts = get_posts([
				'post_type'      => 'post',
				'posts_per_page' => $number,
			]);

			if ($posts) {

				foreach ( $posts as $post ) {
					WP_CLI::log( "ID: " . $post->ID . " : " . $post->post_title);
				}

			} else {
				WP_CLI::warning("No post found for this query.");
			}
			
			return;
		} else {
			WP_CLI::warning("Please, --post_number is required with a valid number.");
			return;
		}
	}
}

WP_CLI::add_command( 'pablo-lab', 'Pablo_Lab' );
