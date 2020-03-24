<?php
add_action("wp_ajax_nopriv_page", "page");
add_action("wp_ajax_page", "page");
add_action('wp_enqueue_scripts','tagpagejsfilesave');
add_shortcode('likertag', 'tagslist'); 

function tagpagejsfilesave(){
    wp_register_script('page', plugins_url('src/js/page.js', __FILE__) , array(
        'jquery'
    ) , null, true);
    wp_localize_script('page', 'pageglobal', ['url'=>get_site_url(),'ajax_url' => admin_url('admin-ajax.php') , 'nonce' => wp_create_nonce('security-ajax') ]);
    wp_enqueue_script('page');
}


function page(){
    $page = $_POST['page'];
    $result=sorttagslike($page);
    for($i=0;$i<count($result);$i++){
      $result[$i]->link=get_tag_link($result[$i]->term_id);
    }
    if (count($result)!=0) {
      $response['status']='ok';
      $response['data']=$result;
    }else {
      $response['status']='no';
    }

    $json=json_encode($response);
    echo $json;
    die();
}

function tagslist() {
  $result=sorttagslike(0);
  $counttag=gettagscount();
  $limit=get_option('page_limit');
  $output='<div class=taglist>';
  $output .= '<ul class="tag-cloud-list">';

      if($result) {
        for ($i=0; $i <count($result) ; $i++) { 
            $output .= '<li><a href="'.get_tag_link($result[$i]->term_id).'">'. $result[$i]->name .'-'.$result[$i]->like.'</a></li>';
        }
      } else {
      _e('No tags created.', 'text-domain');
      }
  $output .= '</ul> </div> <br> <div style="display: inline-block;width:20%;height:20%;position: relative; padding: auto;">';
  $count=$counttag%$limit==0?$counttag/$limit:floor($counttag/$limit)+1;

  for ($i=0; $i < $count  ; $i++) { 
    $output.='<a href="#" style="
    text-decoration: none;color: black;
    float: left;
    padding: 8px 16px;" data-id="'.$i.'" class="tagpagination">'.($i+1).'</a>';
  }
return $output.'</div>';
}  


