<?
function likecount($postid){
    $postmeta=get_post_meta( $postid, 'like', true );
    $likevalue=$postmeta==""?0:$postmeta;
    return $likevalue;
}
function gettagscount()
{
    global $wpdb;
    return $wpdb->get_var("select COUNT(*) FROM ".$wpdb->prefix."term_taxonomy WHERE taxonomy='post_tag' ");
}
function sorttagslike($page){
    global $wpdb;
  $limit=get_option('page_limit');
  $args=array(
    'taxonomy'=>'post_tag',
    'number'=>$limit,//gelecek verini sayısı
    'offset'=>$page*intval($limit),//sayfalama anahtarı,
    'hide_empty' => false,
  );
  $tags= get_terms($args);
  $sqlquery="SELECT t.term_id, t.name, sum(m.meta_value) as 'like' FROM  wp_postmeta AS m 
  LEFT JOIN wp_term_relationships AS r ON (m.post_id = r.object_id) 
  RIGHT JOIN wp_term_taxonomy AS x ON (r.term_taxonomy_id = x.term_taxonomy_id) 
  INNER JOIN wp_terms AS t ON (r.term_taxonomy_id = t.term_id) 
  WHERE  m.meta_key = 'like' 
  AND x.taxonomy = 'post_tag' AND t.term_id in (";
  for ($i=0; $i < count($tags); $i++) { 
    $sqlquery.=$i==count($tags)-1?$tags[$i]->term_id:$tags[$i]->term_id.',';
  }
  $sqlquery.=") GROUP BY x.term_id ORDER BY SUM(m.meta_value) desc";
  $result= $wpdb->get_results($sqlquery , OBJECT );  
  for ($i=0; $i <count($tags) ; $i++) { 
      $res=array_search($tags[$i]->term_id,array_column($result,'term_id'));
      if ($res==FALSE) {
        array_push($result,(object)array('term_id'=>$tags[$i]->term_id,'name'=>$tags[$i]->name,'like'=>'0'));
      }
  }
  return $result;
}