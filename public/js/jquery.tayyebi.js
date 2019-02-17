
/*

Regarding to:

https://stackoverflow.com/questions/2008052/

*/

$.ajaxSetup({
  contentType: "application/x-www-form-urlencoded; charset=UTF-8"
});



/*


Regarding to:

https://stackoverflow.com/questions/2153917/

And also:

https://homework.nwsnet.de/releases/9132/

We can extend jQuery to make shortcuts for PUT and DELETE
then you can use:

$.put('http://stackoverflow.com/posts/22786755/edit', {text:'new text'}, function(result){
   console.log(result);
})


*/

jQuery.each( [ "put", "delete" ], function( i, method ) {
    jQuery[ method ] = function( url, data, callback, type ) {
      if ( jQuery.isFunction( data ) ) {
        type = type || callback;
        callback = data;
        data = undefined;
      }

      return jQuery.ajax({
        contentType:"application/json; charset=utf-8",
        url: url,
        type: method,
        dataType: type,
        data: decodeURI(data),
        success: callback
      });
    };
  });


/*

Regarding to:

https://stackoverflow.com/questions/951791/


*/

window.onerror = function(msg, url, line, col, error) {
  var extra = !col ? '' : '\ncolumn: ' + col;
  extra += !error ? '' : '\nerror: ' + error;
  // TODO: Disable in release
  // alert(msg + "\nurl: " + url + "\nline: " + line + extra);
};



/*

Regarding to:

https://stackoverflow.com/questions/1275190/

// Array Remove - By John Resig (MIT Licensed)

*/


Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};




/*

Regarding to:

https://gist.github.com/oswaldoacauan/7580474

// Serialize Form with File inputs
// By oswaldoacauan

*/



(function($) {
  $.fn.serializeFiles = function() {
    
    var form = $(this),
        // formData = new FormData(),
        formData = { },
        formParams = form.serializeArray();
    
    $.each(formParams, function(i, val) {
        // formData.append(val.name, val.value);
        formData[val.name] = val.value;
    });
    var proms = [] ;
    $.each(form.find('input[type="file"]'), function(i, tag) {


      $.each($(tag)[0].files, function(i, file) {
        // formData.append(tag.name, file);
        // formData[tag.name] = file;

        proms.push(
        getBase64(file).then(
          data => formData[tag.name] = data
        ));
      });
    });

    return new Promise((resolve, reject) => {
    Promise.all(proms)
    .then(res => 
      resolve(stringSerialize(formData))
    )});
  };
})(jQuery);




/*

Regarding to:

https://stackoverflow.com/questions/41431322/

// JSON str encoding of a Javascript Object

*/




jsonSerialize  = function(obj) {
  var object = {};
  obj.forEach(function(value, key){
      object[key] = value;
  });
  return JSON.stringify(object);

}


/*

Regarding to:

https://stackoverflow.com/questions/1714786

// Query-string encoding of a Javascript Object

*/

stringSerialize = function(obj) {
  var str = [];
  for(var p in obj){
      if (obj.hasOwnProperty(p)) {
          str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      }
  }
  return str.join("&");
}



/*

Regarding to:

https://stackoverflow.com/questions/36280818

// Base64 encode a javascript object


*/

function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}

/*


External Loader

*/

function loadStyle(url)
{
  document.querySelector('head').innerHTML += '<link rel="stylesheet" href="' + url + '" type="text/css"/>';
}
function loadScript(url, callback)
{
    // var len = $('script[src="' + url + '"]').length;
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    script.onreadystatechange = callback;
    script.onload = callback;
    head.appendChild(script);
}