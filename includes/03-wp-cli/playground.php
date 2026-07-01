<?php

if ( defined( 'WP_CLI' ) && WP_CLI ) {

	class Pablo_Lab {

		function report($args, $assoc_args) {

			$number = $assoc_args["post_number"];

			if ($number === "0") {
				WP_CLI::warning("Please, --post_number can't be 0.");
			} else if (($number && gettype($number) === "integer" ) || $number === "-1" ) {

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

			} else {
				WP_CLI::warning("Please, --post_number is required with a valid number.");
			}


			if ($assoc_args["dry-run"]) {
				WP_CLI::success("Dry run executed successfully.");
			}
		}
	}

	WP_CLI::add_command( 'pablo-lab', 'Pablo_Lab' );

}