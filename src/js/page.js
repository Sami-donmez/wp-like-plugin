jQuery(document).ready(function($){
    $('.tagpagination').click(function(){
       var pageid=$(this).data("id");
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
                   htmlout+=' <li><a href="'+data.link+'">'+data.name+'-'+data.like+'</a></li>'
                }); 
                htmlout+='</ul>';
                $('.taglist').html(htmlout);
                $(this).css("color", "red");

            }
          }
       })
    })})
    
