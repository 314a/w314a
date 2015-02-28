<?php
/**
 * The template for displaying all attachments.
 *
 * @package w314a
 */
get_header(); ?>
	<div class="content-wrapper clear">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php
				if ( have_posts() ) : while ( have_posts() ) : the_post();
				//print_r($post)
				?>
				<h1><?php the_title(); ?></h1>

				<div class="entry-attachment">
					<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
						<p class="attachment">
							<a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment">
								<img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a>
					    </p>
					<?php else : ?>
					    <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
					<?php endif; ?>
				 </div>
				 <?php if ($post->post_excerpt!='') :?> 
				 <div class="entry-excerpt">
					<?php echo $post->post_excerpt; ?>
				 </div><!-- .entry-excerpt -->
				<?php endif; ?>

				 <div class="entry-content">
					<?php echo $post->post_content; ?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'w314a' ),
							'after'  => '</div>',
						) ); ?>
				</div><!-- .entry-content -->
				 <footer class="entry-footer">
					<?php w314a_posted_on(); ?>
				</footer><!-- .entry-meta -->
				<?php endwhile; ?>
				<?php endif; ?>
			</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
