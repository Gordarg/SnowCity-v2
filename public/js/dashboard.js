
function loadpost(){
  $('.content').load(Hi.baseurl() + 'ajax/say/post', function(){
    loadScript(Hi.baseurl() + "public/js/say/post.js", function(){    });
  });
}
loadpost();