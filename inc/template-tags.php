<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package w314a
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'w314a' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'w314a' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'w314a' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'w314a' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'w314a_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function w314a_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'w314a' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'w314a' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'w314a_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function w314a_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		// Post format
		$format = get_post_format();
		if ( current_theme_supports( 'post-formats', $format ) ) {
			printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
				sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'w314a' ) ),
				esc_url( get_post_format_link( $format ) ),
				get_post_format_string( $format )
			);
		}
		// Post time
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date(),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);

			printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
				_x( 'Posted on', 'Used before publish date.', 'w314a' ),
				esc_url( get_permalink() ),
				$time_string
			);
		}

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'w314a' ) );
		if ( $categories_list && w314a_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( '%1$s', 'w314a' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( );//get_the_tag_list( '', __( ', ', 'w314a' ) );
		if ( $tags_list ) {
			//printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'w314a' ) . '</span>', $tags_list );
			printf( '<span class="tags-links">' . __( '%1$s', 'w314a' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( '0 Comment', 'w314a' ), __( '1 Comment', 'w314a' ), __( '% Comments', 'w314a' ) );
		echo '</span>';
	}
	
	edit_post_link( __( 'Edit', 'w314a' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'w314a' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'w314a' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'w314a' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'w314a' ), get_the_date( _x( 'Y', 'yearly archives date format', 'w314a' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'w314a' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'w314a' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'w314a' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'w314a' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'w314a' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'w314a' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'w314a' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'w314a' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'w314a' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function w314a_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'w314a_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'w314a_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so w314a_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so w314a_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in w314a_categorized_blog.
 */
function w314a_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'w314a_categories' );
}
add_action( 'edit_category', 'w314a_category_transient_flusher' );
add_action( 'save_post',     'w314a_category_transient_flusher' );

/**************************************************************************************************/
/**
 * Change the class of the hero area depending on featured image.
 */
function w314a_additional_class() {
	if ( is_archive() || is_search() || is_404() || '' == get_the_post_thumbnail() ) {
		$additional_class =  'without-featured-image';
	} else {
		$additional_class =  'with-featured-image';
	}
	return $additional_class;
}


/**
 * Add background-image to hero area.
 */
function w314a_hero_background() {
	if ( is_archive() || is_search() || is_404() || '' == get_the_post_thumbnail() ) {
		return;
	} else {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'w314a-hero' );
		$css = '.hero.with-featured-image { background-image: url(' . esc_url( $thumbnail[0] ) . '); }';
		wp_add_inline_style( 'w314a-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'w314a_hero_background' );

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @return void
 */
function w314a_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() || has_post_format() ) { return;}
?>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>">
	<?php
		if( is_page_template( 'page-templates/front-page.php' ) || is_page_template( 'page-templates/grid-page.php' ) ) {
			the_post_thumbnail( 'w314a-thumbnail-landscape' );
			/*$ratio = get_theme_mod( 'edin_thumbnail_style' );
			switch ( $ratio ) {
				case 'square':
					the_post_thumbnail( 'w314a-thumbnail-square' );
					break;
				default :
					the_post_thumbnail( 'w314a-thumbnail-landscape' );
			}*/
		} else {the_post_thumbnail( 'w314a-featured-image' );}
	?>
	</a>

<?php
}

/**
 * Display featured pages.
 */
function w314a_featured_pages() {
	$featured_page_1 = esc_attr( get_theme_mod( 'w314a_featured_page_one_front_page', '0' ) );
	$featured_page_2 = esc_attr( get_theme_mod( 'w314a_featured_page_two_front_page', '0' ) );
	$featured_page_3 = esc_attr( get_theme_mod( 'w314a_featured_page_three_front_page', '0' ) );

	if ( 0 == $featured_page_1 && 0 == $featured_page_2 && 0 == $featured_page_3 ) {return;}
	// hack TODO
	if ( 20 == $featured_page_1 ){return;}
?>

	<div id="quaternary" class="featured-page-area">
		<div class="featured-page-wrapper clear">

			<?php for ( $page_number = 1; $page_number <= 3; $page_number++ ) : ?>
				<?php if ( 0 != ${'featured_page_' . $page_number} ) : // Check if a featured page has been set in the customizer ?>
					<div class="featured-page">

						<?php
							// Create new argument using the page ID of the page set in the customizer
							$featured_page_args = array(
								'page_id' => ${'featured_page_' . $page_number},
							);
							// Create a new WP_Query using the argument previously created
							$featured_page_query = new WP_Query( $featured_page_args );
						?>

						<?php while ( $featured_page_query->have_posts() ) : $featured_page_query->the_post(); ?>

							<?php get_template_part( 'content', 'grid' ); ?>

						<?php
							endwhile;
							wp_reset_postdata();
						?>
					</div><!-- .featured-page -->
				<?php endif; ?>
			<?php endfor; ?>

		</div><!-- .featured-page-wrapper -->
	</div><!-- #quaternary -->

<?php
}