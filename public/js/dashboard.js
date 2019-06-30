function loadform(){
  $('.content').load(Hi.baseurl() + 'ajax/say/qust', function(){
    loadScript(Hi.baseurl() + "public/js/say/qust.js", function(){    });
  });
}
function loadpost(){
  $('.content').load(Hi.baseurl() + 'ajax/say', function(){
    loadScript(Hi.baseurl() + "public/js/say.js", function(){    });
  });
}
loadpost();