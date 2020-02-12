/*
 * Action hooks
 */
public function run() {     
    // Enqueue plugin styles and scripts
    add_action( ‘plugins_loaded’, array( $this, 'enqueue_liker_scripts' ) );
    add_action( ‘plugins_loaded’, array( $this, 'enqueue_liker_styles' ) );      
}   
/**
 * Register plugin styles and scripts
 */
public function register_liker_scripts() {
    wp_register_script( 'rml-script', plugins_url( 'src/js/liker.js', __FILE__ ), array('jquery'), null, true );
    wp_register_style( 'rml-style', plugins_url( 'src/css/liker.css' ) );
}   
/**
 * Enqueues plugin-specific scripts.
 */
public function enqueue_liker_scripts() {        
    wp_enqueue_script( 'rml-script' );
}   
/**
 * Enqueues plugin-specific styles.
 */
public function enqueue_liker_styles() {         
    wp_enqueue_style( 'rml-style' ); 
}