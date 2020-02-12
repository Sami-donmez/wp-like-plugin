<?php
require_once(__DIR__.'/../languages/EN.php');

function settingstemplate()
{
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
                   $durum=updatebuttonsettings($_POST);
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
            <select id="lang">

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
        <input type="hidden" name="islem" value="page">
            <label for="">Buton Konum Ayarı</label>
            <select id="Konum">
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


function updatebuttonsettings($data)
{
    return 0;
}



?>