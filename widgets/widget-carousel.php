<?php
/*
Plugin Name: W314a Carousel Widget
Plugin URI: http://3.14a.ch
Description: This widget displays a carousel of pages or category posts
Author: 3.14a
Version: 1.5
Author URI: http://3.14a.ch
*/
//http://core.trac.wordpress.org/browser/trunk/wp-includes/default-widgets.php
//error_reporting(E_ALL);
class w31a_carousel_widget extends WP_Widget {
	function w31a_carousel_widget() {
		//Constructor
		$widget_ops = array('classname' => 'w314a-carousel-widget','description' => __( "w314a Carousel Widget", 'w314a') );
		$this->WP_Widget('w314a_carousel_widget', __('w314a Carousel Widget','w314a'), $widget_ops);
		/* if you want to exclude the stylesheet uncomment the following line		 * wp_enqueue_style('carousel.css', plugins_url('carousel.css', __FILE__));		 */
		// wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '', true );
	}

	function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		//print_r($instance);//print_r($args);

		/* widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$page_ID = $instance['page_ID'];
		$span_position = $instance['span_position'];
		$show_category = isset( $instance['show_category'] ) ? true : false;
		$cat_ID = $instance['cat_ID'];
		$cat_name = ( $instance['cat_ID']!=0 ) ? get_cat_name($instance['cat_ID']) : "Neueste Beitr&auml;ge";
		$number_of_posts = $instance['number_of_posts'];		
		$html='';
		$tmp =40;
		$carousel_ID = 'carousel'.$this->number;
		if($show_category ==true){
			if($cat_ID==0){$query='showposts='.$number_of_posts;}
			else{$query='showposts='.$number_of_posts.'&cat='.$cat_ID;}
			$my_query = new WP_Query($query); 
			if ( $title=='' ){$title=$cat_name;}						
			if ($my_query->have_posts()) :
			$count =0;
			while ($my_query->have_posts()) : $my_query->the_post();
				if($count<$number_of_posts){
					$first = ($count==0)?'active':'';
					$img_size = ($this->number==5)?'large':'medium'; // if is shown on frontpage get large picture or use custom image sizes
					$indicator .= '<li data-target="#'.$carousel_ID.'" data-slide-to="'.$count.'"></li>';
				
					$content = strip_shortcodes($content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$content = strip_tags($content);
					
					$html .= '<div class="item '.$first.'">';
					$html .= get_the_post_thumbnail(get_the_ID(),$img_size);
					$html .= '<div class="container"><div class="carousel-caption">';
					$html .= '<h1><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h1>';
					$html .= $this->w314a_excerpt($content,$tmp);
					$html .= '<p><a class="btn btn-lg btn-primary" href="'.get_permalink().'" role="button">Read more</a></p>';
					$html .= '</div></div></div>';
				}
				$count++;				
			endwhile;
        endif;		
		}
		else{
			//define query
			$query = 'child_of='.$page_ID;
			$pages = get_pages($query); 
			//print_r($pages);
			//$my_query = new WP_Query($query); 
			$count = 0;
			$indicator='';
			if ($pages) :
			foreach( $pages as $page ) {	
				$first = ($count==0)?'active':'';
				$indicator .= '<li data-target="#'.$carousel_ID.'" data-slide-to="'.$count.'"></li>';
								
				$html .= '<div class="item '.$first.'">';
				$html .= get_the_post_thumbnail($page->ID );
				$html .= '<div class="container"><div class="carousel-caption">';
				$html .= '<h1><a href="'.get_permalink($page->ID).'" title="'.$page->post_title.'">'.$page->post_title.'</a></h1>';
				$html .= $this->w314a_excerpt($page->post_content,$tmp);
				$html .= '<p><a class="btn btn-lg btn-primary" href="'.get_permalink($page->ID).'" role="button">Read more</a></p>';
				$html .= '</div></div></div>';
				
				$count++;
			}			
			/* After widget (defined by themes). */			
			endif;	
		}
		if($html!=''){
			echo $before_widget;
			if ( $title ){echo $before_title .$title. $after_title;}?>
			<div id="<?php echo $carousel_ID; ?>" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php echo $indicator; ?>
			</ol>
			<div class="carousel-inner" role="listbox">
				<?php echo $html; ?>
			</div>
			<?php if($number_of_posts>1): ?>
				<a class="left carousel-control" href="#<?php echo $carousel_ID; ?>" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#<?php echo $carousel_ID; ?>" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>			
			<?php endif; ?>
			<?php echo $after_widget;
		}
		//add_action('wp_footer', 'print_carousel_script');		
	}
 
	/*function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//save the widget
		$instance['title'] = strip_tags($new_instance['title']);
 		$instance['page_ID'] = $new_instance['page_ID'];
 		$instance['span_position'] = $new_instance['span_position'];
 		$instance['show_category'] = $new_instance['show_category'];
 		$instance['cat_ID'] = $new_instance['cat_ID'];
		$instance['number_of_posts'] = $new_instance['number_of_posts']; 		
		return $instance;
	}*/
 
	function form($instance) {
		//widgetform in backend
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'cat_ID' => '0', 'number_of_posts' => '5' , 'date' => 'true' , 'coments' => 'true' );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<!-- Page parents: Select Box -->
		<hr />
		<p>
			<label for="<?php echo $this->get_field_id( 'page_ID' ); ?>">Pages<br/><?php __('Set parent page', 'w314a')?></label> 
			<select id="<?php echo $this->get_field_id( 'page_ID' ); ?>" name="<?php echo $this->get_field_name( 'page_ID' ); ?>" class="widefat" style="width:100%;">
			<?php  ?>
			<?php  $pages = get_pages(); foreach ($pages as $page) { if($page->post_parent!=0){$child='- ';}else{$child='';} echo'<option value="'.$page->ID.'"'.( $page->ID == $instance['page_ID']?'selected="selected"':'').'>'.$child.$page->post_title."</option>\n";}?>
			</select>
		</p>
	

		<hr />
		<!-- Category: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_ID' ); ?>">Category</label> 
			<select id="<?php echo $this->get_field_id( 'cat_ID' ); ?>" name="<?php echo $this->get_field_name( 'cat_ID' ); ?>" class="widefat" style="width:100%;">
			<option value="0" <?php if( $cat->cat_ID == $instance['cat_ID']){ echo 'selected="selected"';} ?> >All</option>
			<?php  $categories = get_categories();   foreach ($categories as $cat) {  echo'<option value="'.$cat->cat_ID.'"'.( $cat->cat_ID == $instance['cat_ID']?'selected="selected"':'').'>'.$cat->cat_name."</option>\n";}?>
			</select>
		</p>	
		<!-- Number of Posts: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>">Number of posts</label> 
			<select id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" class="widefat" style="width:100%;">
			<?php for ( $i = 1; $i <= 10; ++$i ) {echo'<option value="'.$i.'"'.( $i == $instance['number_of_posts']?'selected="selected"':'').'>'.$i."</option>\n";}?>
			</select>
		</p>	
		<hr />
		<!-- Use category or pages? Radio -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_category'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_category' ); ?>">Show category (otherwise subpages is selected)</label>
		</p>			
		<!-- Position of Text -->
		<!--<p>
			<label for="<?php echo $this->get_field_id( 'span_position' ); ?>">Text position</label> 
			<select id="<?php echo $this->get_field_id( 'span_position' ); ?>" name="<?php echo $this->get_field_name( 'span_position' ); ?>" class="widefat" style="width:100%;">
				<option value="right" <?php echo('right' == $instance['span_position']?'selected="selected"':'')?>>right</option>
				<option value="left" <?php echo('left' == $instance['span_position']?'selected="selected"':'')?>>left</option>
				<option value="top" <?php echo('top' == $instance['span_position']?'selected="selected"':'')?>>top</option>
				<option value="bottom" <?php echo('bottom' == $instance['span_position']?'selected="selected"':'')?>>bottom</option>
			</select>
		</p>-->
		<?php		
	}
	// imported from  Thin & Light (http://thinlight.org/) for thess custom functions via Futurosity aperio prototype..

	function w314a_excerpt($text, $excerpt_length = 30) {
		$text = str_replace(']]>', ']]&gt;', $text);
		// remove captions from next gen gallery plugin
		$text = preg_replace("/(\[caption.*\].*\[\/caption\])/",'', $text);
		$text = preg_replace("/(\[singlepic .*\])/",'', $text);
		$text = strip_tags($text);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '[...]');
			$text = implode(' ', $words);
		}
		return apply_filters('the_excerpt', $text);
	}
	
}
?>