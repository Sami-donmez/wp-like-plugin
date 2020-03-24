jQuery(document).ready(function($){

$('.liker_plugin_button').click(function(){
   var postid=$(this).data("id");
   var islem=$(this).val();
   $.ajax({
      type:'post',
      dataType:'json',
      url:likerglobal.ajax_url,
      data:{
      action:'liker',
      _ajax_nonce:likerglobal.nonce,
      id:postid,
      islem:islem
      },
      success:(result)=> {
         if (result.islem=='like') {
            $(this).val('dislike');
         $(this).html("<img style='height:32px;width:32px;margin:2%' src='"+likerglobal.url+"/wp-content/plugins/wp like plugin/src/img/dislike.png' > <span> bu yazı <b>" +result.like+ "</b> kez begenilmistir</span>");
         }else{
            $(this).val('like');
         $(this).html("<img style='height:32px;width:32px;margin:2%' src='"+likerglobal.url+"/wp-content/plugins/wp like plugin/src/img/like.png' > <span> bu yazı <b>" +result.like+ "</b> kez begenilmistir</span>");
         }
         
      }
   })
})})
