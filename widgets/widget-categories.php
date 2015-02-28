<?php
/*
Plugin Name: W314a Category Widget
Plugin URI: http://3.14a.ch
Description: This widget displays the last x posts per category in the widget area CSS classes widget_sp_category, category-xxx, first-post 
Author: 3.14a
Version: 1.5
Author URI: http://3.14a.ch
*/
//http://core.trac.wordpress.org/browser/trunk/wp-includes/default-widgets.php
//error_reporting(E_ALL);
//add_action("widgets_init", array('SP_Category_Widget', 'register'));

/* Add our function to the widgets_init hook. */
//add_action( 'widgets_init', 'sp_load_widgets' );

/* Function that registers our widget. */
//function sp_load_widgets() {register_widget( 'SP_Category_Widget' );}

class w314a_category_widget extends WP_Widget{
	// constructor
	function w314a_category_widget(){
		$widget_ops = array('classname' => 'w314a-category-widget','description' => __( "w314a Category Widget", 'w314a') );
		$this->WP_Widget('w314a_category_widget', __('w314a Category Widget','w314a'), $widget_ops);
    }
  /*function register(){
    register_sidebar_widget('SP Category', array('SP_Category_Widget', 'widget'));
    register_widget_control('SP Category', array('SP_Category_Widget', 'form'));
  }*/
 
	function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		//print_r($instance);//print_r($args);

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$cat_ID = $instance['cat_ID'];
		$number_of_posts = $instance['number_of_posts'];
		$excerpt = isset( $instance['excerpt'] ) ? $instance['excerpt'] : false;
		$show_images = isset( $instance['show_images'] ) ? $instance['show_images'] : false;
		$first_post = isset( $instance['first_post'] ) ? $instance['first_post'] : false;
		$show_widgettitle = isset( $instance['show_widgettitle'] ) ? $instance['show_widgettitle'] : false;
		/* Widget content, selection of Category and the first posts */
		//if($cat_ID ==0){$query = 'showposts='.$instance['number_of_posts'];}
		//else{$query = 'cat='.$instance['cat_ID'].'&showposts='.$instance['number_of_posts'];}	
		if($cat_ID ==0){$args = array('cat' => '','posts_per_page' => $number_of_posts);}
		else{$args = array('cat' => $cat_ID,'posts_per_page' => $number_of_posts);}
		//$args = array('cat' => '','posts_per_page' => $number_of_posts);
		$my_query = 0;
		$my_query = new WP_Query($args);
		//$my_query = new WP_Query("cat=12");
		if ($my_query->have_posts()) :
		/* Before widget (defined by themes). */
		echo $before_widget;
		//echo $query;
		/* Display the widget title if one was input or the category title if there is no input */
		if($show_widgettitle){}
		elseif ( $title && $cat_ID !=0){echo $before_title .'<a href="'.get_category_link($instance['cat_ID']).'" title="'.get_cat_name($instance['cat_ID']).'">'.$title.'</a><span class="RSS"><a title="Subscribe to RSS feed" class="rss-link" href="'.get_category_feed_link($instance['cat_ID'], '').'">RSS</a></span>'. $after_title;}
		elseif($cat_ID ==0){echo $before_title."Neueste Beitr&auml;ge".$after_title;}
		else{echo $before_title .'<a href="'.get_category_link($instance['cat_ID']).'" title="'.get_cat_name($instance['cat_ID']).'">'.get_cat_name($instance['cat_ID']).'</a><span class="RSS"><a title="Subscribe to RSS feed" class="rss-link" href="'.get_category_feed_link($instance['cat_ID'], '').'">RSS</a></span>'. $after_title;}
		

		$count=1;
		echo '<ul >';
		while ($my_query->have_posts()) : $my_query->the_post();

		if($count==1 && $first_post==true){$firstItem="first-post";}else{$firstItem='';}
		if($show_images==true && $first_post==false){$full="full";}else{$full='list';}
		echo '<li class="category-'.get_cat_name($instance['cat_ID']).' category-'.$instance['cat_ID'].' '.$firstItem.' widget_p'.$count.' '.$full.'">';
			//the_post_thumbnail('w314a-featured-image');
			//if(w314a_get_image()!='' && $show_images ==true && ($first_post==false || ($first_post==true && $count==1))){
			if($show_images ==true && ($first_post==false || ($first_post==true && $count==1))){
				echo '<span class="entry-teaser">'.the_post_thumbnail('w314a-featured-image').'</span>';}
			echo '<h5><a href="'.get_permalink().'" title="'.get_the_title().'" rel="bookmark"><span>';
			echo the_title();
			echo '</h5></span>';
			if($excerpt==true && ($first_post==false || ($first_post==true && $count==1))){echo '<span class="excerpt">'.strip_tags($this->w314a_excerpt(get_the_excerpt(),20)).'</span>';}
			echo '</a></li>';
			$count++;
		endwhile;
		echo '</ul>';  		
		/* After widget (defined by themes). */
		echo $after_widget;
        endif;
	     //wp_reset_query();  Restore global post data stomped by the_post().		
		
		
	}
 
	/*function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//save the widget
		$instance['title'] = strip_tags($new_instance['title']);
 		$instance['cat_ID'] = $new_instance['cat_ID'];
		$instance['number_of_posts'] = $new_instance['number_of_posts']; 
		$instance['excerpt'] = $new_instance['excerpt']; 
		$instance['show_images'] = $new_instance['show_images']; 
		$instance['first_post'] = $new_instance['first_post']; 
		$instance['show_widgettitle'] = $new_instance['show_widgettitle']; 
		
		return $instance;
	}*/
 
	function form($instance) {
		//widgetform in backend
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'cat_ID' => '0', 'number_of_posts' => '5' , 'excerpt' => 'true' , 'show_images' => 'true' , 'first_post' => 'false' );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>

		<!-- Category: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_ID' ); ?>">Category:</label> 
			<select id="<?php echo $this->get_field_id( 'cat_ID' ); ?>" name="<?php echo $this->get_field_name( 'cat_ID' ); ?>" class="widefat" style="width:100%;">
			<option value="0" <?php if( $cat->cat_ID == $instance['cat_ID']){ echo 'selected="selected"';} ?> >All</option>
?			<?php  $categories = get_categories();   foreach ($categories as $cat) {  echo'<option value="'.$cat->cat_ID.'"'.( $cat->cat_ID == $instance['cat_ID']?'selected="selected"':'').'>'.$cat->cat_name."</option>\n";}?>
			</select>
		</p>

		<!-- Number of Posts: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>">Number of Posts: </label> 
			<select id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" class="widefat" style="width:100%;">
			<?php for ( $i = 1; $i <= 10; ++$i ) {echo'<option value="'.$i.'"'.( $i == $instance['number_of_posts']?'selected="selected"':'').'>'.$i."</option>\n";}?>
			</select>
		</p>
		
		<!-- Show excerpts? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['excerpt'], 'on'  ); ?> id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>">Show excerpts</label>
		</p>

		<!-- Show images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_images'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>">Show images</label>
		</p>
		
		<!-- Show images/excerpt only on first post in category? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['first_post'], 'on'  ); ?> id="<?php echo $this->get_field_id( 'first_post' ); ?>" name="<?php echo $this->get_field_name( 'first_post' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'first_post' ); ?>">Show images/excerpt only on first post in category</label>
		</p>
		<!-- Do not show widget title Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_widgettitle'], 'on'  ); ?> id="<?php echo $this->get_field_id( 'show_widgettitle' ); ?>" name="<?php echo $this->get_field_name( 'show_widgettitle' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_widgettitle' ); ?>">Don't show widget title</label>
		</p>		
		<?php		
	}
	/**
	 * Display Image function
	 * TODO Test if file exists
	 */

	function w314a_get_image($content=false){
		$img_src = sp_content_image_src($content);//echo $img_src; 
		//print_r(parse_url($img_src));
		//print_r($_SERVER['DOCUMENT_ROOT']);
		$url=parse_url($img_src);
	        $orientation='landscape';
	        if($url['host']==$_SERVER['HTTP_HOST']){
		   list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'].$url['path']);
		   if(!empty($height) || $height!=0){
		       $orientation = $width/$height < 1 ? 'portrait' : 'landscape'; 
		       $orientation = $width/$height > 2 ? 'panorama' : $orientation;}}
		if(empty($img_src)){return $image_src="";}
		else{return '<img title="'.get_the_title().'" src="'.$img_src.'" class="'.$orientation.'" alt="'.$img_src.'" />';}
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
//$spCatWidget= new W314a_Category_Widget ();
//register_widget('W314a_Category_Widget');
?>