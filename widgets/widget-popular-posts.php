<?php
/*
Plugin Name: W314a Top Posts Widget
Plugin URI: http://3.14a.ch
Description: This widget displays the most commented posts TODO merge with category widget and add option to change css style (derived from sparkling)
Author: 3.14a
Version: 1.1
Author URI: http://3.14a.ch
*/
class w314a_popular_posts extends WP_Widget
{
	 function w314a_popular_posts(){

        $widget_ops = array('classname' => 'w314a-popular-posts','description' => __( "w314a Popular Posts Widget", 'w314a') );
		    $this->WP_Widget('w314a_popular_posts', __('w314a Popular Posts Widget','w314a'), $widget_ops);
    }

    function widget($args , $instance) {
    	extract($args);
        $title = ($instance['title']) ? $instance['title'] : __('Popular Posts', 'w314a');
        $limit = ($instance['limit']) ? $instance['limit'] : 5;

      echo $before_widget;
      echo $before_title;
      echo $title;
      echo $after_title;

		/**
		 * Widget Content
		 */
    ?>

    <!-- popular posts -->
          <div class="popular-posts-wrapper">

                <?php

                  $featured_args = array(
                      'posts_per_page' => $limit + 1 ,
                      'orderby' => 'comment_count',
                      'order' => 'DESC',
                      'ignore_sticky_posts' => 1
                    );

                  $featured_query = new WP_Query($featured_args);

                  /**
                   * Check if zilla likes plugin exists
                   */
                  if($featured_query->have_posts()) : while($featured_query->have_posts()) : $featured_query->the_post();

                    ?>

                        <?php if(get_the_content() != '') : ?>

                        <!-- post -->
                        <div class="post">

                          <!-- image -->
                          <div class="post-image <?php echo get_post_format(); ?>">

                                <a href="<?php echo get_permalink(); ?>"><?php
                                if(get_post_format() != 'quote') {
                                  echo get_the_post_thumbnail(get_the_ID() , 'tab-small');
                                }
                                 ?></a>

                          </div> <!-- end post image -->

                          <!-- content -->
                          <div class="post-content">

                              <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                              <span class="date"><?php echo get_the_date('d M , Y'); ?></span>


                          </div><!-- end content -->
                        </div><!-- end post -->

                        <?php endif; ?>

                    <?php

                  endwhile; endif; wp_reset_query();

                 ?>

          </div> <!-- end posts wrapper -->

		<?php

		echo $after_widget;
    }

    function form($instance) {

      if(!isset($instance['title'])) $instance['title'] = __('Popular Posts', 'w314a');
      if(!isset($instance['limit'])) $instance['limit'] = 5;

    	?>

      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'w314a') ?></label>

      <input  type="text" value="<?php echo esc_attr($instance['title']); ?>"
              name="<?php echo $this->get_field_name('title'); ?>"
              id="<?php $this->get_field_id('title'); ?>"
              class="widefat" />
      </p>

      <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit Posts Number', 'w314a') ?></label>

      <input  type="text" value="<?php echo esc_attr($instance['limit']); ?>"
              name="<?php echo $this->get_field_name('limit'); ?>"
              id="<?php $this->get_field_id('limit'); ?>"
              class="widefat" />
      <p>

    	<?php
    }
}
?>