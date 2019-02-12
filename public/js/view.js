$('#newcomment').load('../../ajax/say/comt');
// TODO: Read post id from url
$.when(
    $.getScript( "../../public/js/jquery-ui.js" ),
    $.getScript( "../../public/js/sjfb-html-generator.js" ),
    $.Deferred(function( deferred ){
        $( deferred.resolve );
    })
).done(function(){
    generateForm();
});