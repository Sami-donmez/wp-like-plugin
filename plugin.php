<?php
global $post;
add_filter("the_content", "add_like_button");
add_action("wp_ajax_liker", "liker");
add_action("wp_ajax_nopriv_liker", "liker");
add_action('wp_enqueue_scripts','jsfilesave');
add_action('wp_insert_post', 'add_like_meta', 10, 2);


function add_like_button($content)
{
    $id = get_the_ID();
    $likevalue = likecount($id);
    $like = "<button  style=' margin-left: 40%;margin-right:40%;width: 20%;' value='like' class='liker_plugin_button'  data-id='" . $id . "' ><img style='height:32px;width:32px;align-text:center;margin:%' src='".get_site_url()."/wp-content/plugins/wp like plugin/src/img/like.png' ><br> <span style='align-text:center;margin:auto;'> bu yazı <b>" . $likevalue . "</b> kez begenilmistir</span></button><br>";
    $location=get_option('button_location');
    if ($location=="TOP") {
        return $like . $content ;
    } else {
        return  $content.$like  ;
    }
    
    
}
function jsfilesave()
{
    wp_register_script('liker', plugins_url('src/js/liker.js', __FILE__) , array(
        'jquery'
    ) , null, true);
    wp_localize_script('liker', 'likerglobal', ['url'=>get_site_url(),'ajax_url' => admin_url('admin-ajax.php') , 'nonce' => wp_create_nonce('security-ajax') ]);
    wp_enqueue_script('liker');
}   
function add_meta_like($postid, $post) {
    add_post_meta($postid, 'like', 0);
}
function liker()
{
    $postid = $_POST['id'];
    $islem=$_POST['islem'];
    $response=[];
    $postmeta = get_post_meta($postid, 'like', true);
    $likevalue = $postmeta == "" ? 0 : $postmeta;
    $likevalue =$islem=='like'?$likevalue+1:$likevalue-1;
    $response['islem']=$islem=='like'?'like':'dislike';
    if ($postmeta == "")
    {
        add_post_meta($postid, 'like', $likevalue);
    }
    else
    {
        update_post_meta($postid, 'like', $likevalue);
    }
    $response['status']='ok';
    $response['like']=$likevalue;
    $json=json_encode($response);
    echo $json;
    die();
}

