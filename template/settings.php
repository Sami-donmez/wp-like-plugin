<?php
require_once(__DIR__.'/../languages/EN.php');

function settingstemplate()
{
    var_dump($_POST);
    var_dump($_FILES);
    global $dıl;
    $durum= 2;
    if(isset($_POST)){
        if (isset($_POST['islem'])){
            switch ($_POST['islem']) {
                case 'page':
                    $durum=updatepagesettings($_POST);                
                    break;
                case 'widget':
                    $durum=updatepwidgetsettings($_POST);
                    break;
                case 'button':
                   $durum=updatebuttonsettings($_POST,$_FILES);
                    break;
                case 'plugin':
                    $durum=updatepluginsettings($_POST);
                    break;
                default:
                    $durum=0;
                    break;
            };
        };
    }
     
    $wlimit=get_option('widget_limit');
    $plimit=get_option('page_limit');
    $lang=get_option('plugin_lang');
    $location=get_option('button_location');
    $like=get_option('like_icon');
    $dislike=get_option('dislike_icon');
    echo $durum;
if($durum!=2) {
?>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Seçtiginiz ayarlar <?php echo $durum==1?'kayıt edildi':'kayıt edilemedi' ?>
</div> 
<?php
}
echo $lang;
?>
<style>
.alert {
  padding: 10px;
  background-color:<?php echo $durum==1?'green':'red' ?> ; /* Red */
  color: white;
  margin-left:15px ;
  margin-right:15px ;
  margin-bottom:15px ;
  margin-top:5px;
}

/* The close button */
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

/* When moving the mouse over the close button */
.closebtn:hover {
  color: black;
}
</style>
<div style="">
    <div>
        <h1>Plugin ayarları</h1>
        <form method="post">
            <label><?php echo $dıl['a'];?></label>
            <input type="hidden" name="islem" value="plugin">
            <select id="lang" name="lang">

                <option value="TR" <?=$lang=="TR"?'selected="true"':''?>>Türkçe</option>
                <option value="EN" <?=$lang=="EN"?'selected="true"':''?>>English</option>
                <option value="GR" <?=$lang=="GR"?'selected="true"':''?>>Deutsch</option>
            </select>
            <br>
            <br>
            <button name="" >kaydet</button>
        </form>
    </div>
    <br>
    <hr>
    
    <div>
        <h1>Like buton ayarları</h1>
        <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="islem" value="button">
            <label for="">Buton Konum Ayarı</label>
            <select id="location" name="location">
                <option value="BOTTOM" <?=$location=="BOTTOM"?'selected="true"':''?>>Yazının altında</option>
                <option value="TOP" <?=$location=="TOP"?'selected="true"':''?>>Yazının üstünde</option>
            </select>
            <br>
            <label for="">Like ikon butonu    </label>
            <input type="file" name="like" accept="image/x-png,image/gif,image/jpeg" max="50000">
            <br>
            <label for="">dislike ikon butonu</label>
            <input type="file" name="dislike" accept="image/x-png,image/gif,image/jpeg" max="50000">
            <br>
            <br>
            <button name="" >kaydet</button>
        </form>
    </div>
    <br>
    <hr>

    <div>
        <h1>Widget ayarları</h1>
        <form method=post>
        <input type="hidden" name="islem" value="widget">
            <label for="">post sayısı</label>
            <input type="number" name="limit" value="<?=$wlimit?>">
            <br>
            <br>
            <button name="" >kaydet</button>
        </form>
    </div>
    <br>
    <hr>

    <div>
        <h1>Sayfa ayarları</h1>
        <form method="post">
        <input type="hidden" name="islem" value="page">
            <label for="">post sayısı</label>
            <input type="number" name="limit" value="<?=$plimit?>">
            <br>
            <br>
            <button name="" >kaydet</button>
        </form>
    </div>

</div>



<?}

function updatepagesettings($data)
{
   
    if (!isset($data)) {
        return 0;
    }

    if (isset($data['limit'])) {
        update_option('page_limit',$data['limit']);
        return 1;
    }
    return 0;
}

function updatepluginsettings($data)
{
    var_dump($data);
    if (!isset($data)) {
        return 3;
    }

    if (isset($data['lang'])) {
        update_option('plugin_lang',$data['lang']);
        return 1;
    }
    return 0;
}
    
function updatepwidgetsettings($data){

    if (!isset($data)) {
        return 0;
    }
    if (isset($data['limit'])) {
        update_option('widget_limit',$data['limit']);
        return 1;
    }
    
}

function updatebuttonsettings($data,$file)
{
  add_filter( 'upload_dir', 'wpse_141088_upload_dir' );
  if($file['like']['name'] != ''){
    
    $uploadedfile = $file['like'];
    $upload_overrides = array( 'test_form' => false );
    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
    $imageurl = "";
    if ( $movefile && ! isset( $movefile['error'] ) ) {
       $imageurl = $movefile['url'];
       echo "url : ".$imageurl;
    } else {
       echo $movefile['error'];
    }
  }
  update_option('like_button',$file['dislike']['name']);
  if($file['dislike']['name'] != ''){
        $uploadedfile = $file['dislike'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
        $imageurl = "";
        if ( $movefile && ! isset( $movefile['error'] ) ) {
           $imageurl = $movefile['url'];
           echo "url : ".$imageurl;
        } else {
           echo $movefile['error'];
    }
  }
  update_option('dislike_button',$file['dislike']['name']);
  remove_filter( 'upload_dir', 'wpse_141088_upload_dir' );
  if(isset($data['location'])){
    update_option('button_location',$data['location']);
  }
  return $imageurl; 
}

function wpse_141088_upload_dir( $dir ) {
    return array(
        'path'   => $dir['basedir'] . '/wp like plugin/',
        'url'    => $dir['baseurl'] . '/wp like plugin',
        'subdir' => '/wp like plugin',
    ) + $dir;
}


?>