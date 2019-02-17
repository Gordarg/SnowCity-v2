var myPrettyCode = function() {
  if (loaded_before)
    return;
  loaded_before = true;
  new SimpleMDE({
        element: document.getElementsByName("body")[0],
        spellChecker: false,
    });
    $('[type="file"]').ezdz('options', {
      validators: {
          maxSize: 10000
      }
  });
};
var loaded_before = false;
loadStyle(Hi.baseurl() + "public/css/simplemde.css");
loadStyle(Hi.baseurl() + "public/css/ezdz.css");
loadScript(Hi.baseurl() + "public/js/simplemde.js", myPrettyCode);
loadScript(Hi.baseurl() + "public/js/ezdz.js", myPrettyCode);
// loadScript(Hi.baseurl() + "public/js/select2.js", myPrettyCode);