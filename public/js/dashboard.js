function loadpost(){
  loadScript(Hi.baseurl() + "public/js/say/post.js", function(){
    $('.content').load(Hi.baseurl() + 'ajax/say/post');
  });
}
