<?php
/**
 * Plugin Name: Twitter Follow Button
 * Plugin URI: http://marbu.org/marbu/argomento/wordpress-plugin/
 * Description: A widget that give you the possibility to add official Twitter Follow Button: http://twitter.com/about/resources/followbutton
 * Version: 1.0
 * Author: Marco Buttarini
 * Author URI: marbu.org
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 1.0
 */
add_action( 'widgets_init', 'twitterfollowbutton_load_widgets' );

/**
 * Register our widget.
 * 'twitterfollowbutton_Widget' is the widget class used below.
 *
 * @since 1.0
 */
function twitterfollowbutton_load_widgets() {
	register_widget( 'twitterfollowbutton_Widget' );
}

/**
 * twitterfollowbutton Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 * @since 1.0
 */
class twitterfollowbutton_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function twitterfollowbutton_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'twitterfollowbutton', 'description' => __('Widget to display twitter follow button', 'twitterfollowbutton') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitterfollowbutton-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'twitterfollowbutton-widget', __('Twitter Follow Widget', 'twitterfollowbutton'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$color = $instance['color'];
		$shownumber = $instance['shownumber'];
		$language = $instance['language'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;


if($color == "black")
	$addc=' data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF" ';

if($shownumber)
	$addn=' data-show-count="true" ';
else	
	$addn=' data-show-count="false" ';

if($language == "") $language = "en";
if($language != "en")	
	$addl=' data-lang="'.$language.'" ';

echo '<a href="http://twitter.com/'.$username.'" class="twitter-follow-button" '.$addc.' '.$addn.' '.$addl.'  >Follow @'.$username.'</a><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		
		$instance['color'] = $new_instance['color'];
		$instance['shownumber'] = $new_instance['shownumber'];
		$instance['language'] = $new_instance['language'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Follow me on Twitter', 'twitterfollowbutton'), 'username' => __('webgrafia', 'twitterfollowbutton'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username:', 'twitterfollowbutton'); ?></label>
			<input id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" style="width:100%;" />
		</p>
	
	<!-- Your Color -->

		<p>
			<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e('Background color:', 'twitterfollowbutton'); ?></label><br />
	<input type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="white" style="width:100%;" <? if(($instance['color'] == "") || ($instance['color '] == "white")) echo "checked"; ?> /> White<br />
	<input type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="black" style="width:100%;" <? if($instance['color'] == "black") echo "checked"; ?>/> Black
		</p>


		<!-- language: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'language' ); ?>"><?php _e('Language:', 'twitterfollowbutton'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'language' ); ?>" name="<?php echo $this->get_field_name( 'language' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'en' == $instance['language'] ) echo 'selected="selected"'; ?> value="en">English</option>
				<option <?php if ( 'ko' == $instance['language'] ) echo 'selected="selected"'; ?> value="ko">Corean</option>
				<option <?php if ( 'fr' == $instance['language'] ) echo 'selected="selected"'; ?> value="fr">France</option>
				<option <?php if ( 'ja' == $instance['language'] ) echo 'selected="selected"'; ?> value="ja">Japanese</option>
				<option <?php if ( 'ru' == $instance['language'] ) echo 'selected="selected"'; ?> value="ru">Russian</option>
				<option <?php if ( 'it' == $instance['language'] ) echo 'selected="selected"'; ?> value="it">Italiano</option>
				<option <?php if ( 'de' == $instance['language'] ) echo 'selected="selected"'; ?> value="de">Deutsch</option>
				<option <?php if ( 'tr' == $instance['language'] ) echo 'selected="selected"'; ?> value="tr">Turkish</option>
			</select>
		</p>

		<!-- Show number Checkbox -->
		<p>

			<input class="checkbox" type="checkbox" <?php checked( $instance['shownumber'], true ); ?> value="1" id="<?php echo $this->get_field_id( 'shownumber' ); ?>" name="<?php echo $this->get_field_name( 'shownumber' ); ?>" <?  if($instance['shownumber']) echo " checked ";?> /> 
			<label for="<?php echo $this->get_field_id( 'shownumber' ); ?>"><?php _e('Show numbers of follower?', 'twitterfollowbutton'); ?></label>
		</p>


<p style="background-color:#000; float:left; padding:6px; color:#ffffff;-moz-border-radius: 5px; border-radius: 5px; font-size:11px; ">

<a href="http://twitter.com/webgrafia" class="twitter-follow-button" data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF">Follow @webgrafia</a>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<br />for update on plugin development
</p>
	<?php
	}
}

?>
