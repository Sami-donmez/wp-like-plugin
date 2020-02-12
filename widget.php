<?php
// Register and load the widget
function wpb_load_widget() {
  register_widget( 'liker_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Creating the widget 
class liker_widget extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'liker_widget', 

// Widget name will appear in UI
__('Liker Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'wordpress liker plugin top 10 post widget', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
$limit=get_option('widget_limit');
$arg=array('posts_per_page' => $limit,'post_type' => 'post','meta_key' => 'like',
'orderby' => 'meta_value_num',
'order' => 'DESC');
// Sorgu
$the_query = new WP_Query( $arg );
echo'<ul>';
// Loop Döngüsü
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts()){
		print_r($the_query->the_post());
    $id=get_the_ID();
    $like=get_post_meta( $id,'like');
    $title=get_the_title();
    echo '<li>'.$title."-".$like[0]."</li>";
	}
	echo '</ul>';
} else {
	// Yazı bulunamadı
}

/* Orjinal yazı bilgisini sisteme geri verelim */
wp_reset_postdata();
// This is where you run the code and display the output
//echo __( 'sami, World!', 'wpb_widget_domain' );
echo $args['after_widget'];
}
       
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
   
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here
?>