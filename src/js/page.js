jQuery(document).ready(function($){
    $('.tagpagination').click(function(){
       var pageid=$(this).data("id");
       //console.log(postid);
       $.ajax({
          type:'post',
          dataType:'json',
          url:pageglobal.ajax_url,
          data:{
          action:'page',
          _ajax_nonce:pageglobal.nonce,
          page:pageid
           },
          success:(result)=> {        
             if (result.status=="ok") {
                htmlout='<ul>';
                result.data.forEach(data => {
                   htmlout+=" <li>"+data.name+"-"+data.like+"</li>"
                }); 
                htmlout+='</ul>';
                $('.taglist').html(htmlout);
                $(this).css("color", "red");

            }
          }
       })
    })})
    