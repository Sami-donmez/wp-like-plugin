<?php
require_once('template/hello.php');
require_once('template/settings.php');
add_action('admin_menu', 'benim_ekletim_menu');

function benim_ekletim_menu(){
 add_menu_page('Wp Liker','WP liker Anasayfa', 'manage_options', 'wp-liker', 'hellotemplate');
 add_submenu_page( 'wp-liker', 'ayarlar-Wp Liker', 'Ayarlar' ,'manage_options','wp-liker-settings', 'settingstemplate' );
}
