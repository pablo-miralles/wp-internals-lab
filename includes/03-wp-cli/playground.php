<?php

class Pablo_Lab {

	function report($args, $assoc_args) {

		$number = $assoc_args["post_number"];

		if (($number && gettype($number) === "integer") || "-1" ) {

			$posts = get_posts([
				'post_type'      => 'post',
				'posts_per_page' => $number,
			]);

			if ($posts) {

				foreach ( $posts as $post ) {
					WP_CLI::log( "ID: " . $post->ID . " : " . $post->post_title);
				}
			} else {
				WP_CLI::error("No post found for this query.");
			}

		} else {
			WP_CLI::error("Please, --post_number is required with a valid number.");
		}


		if ($assoc_args["dry-run"]) {
			WP_CLI::success("Dry run executed successfully.");
		}
	}
}

WP_CLI::add_command( 'pablo-lab', 'Pablo_Lab' );
