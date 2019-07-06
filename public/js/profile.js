url = Hi.controller() + "userController.php?" + Hi.loginprotocol(); // controller address

function profile(username){
    $("input[name=previousUsername]").val(username);
}

$("#changepassword-form").on('submit', function (event) { // submit event
    var mydata = $( "#changepassword-form" ).serialize(); // prepare data
    event.preventDefault(); // handle only javascript

    $.put( url, mydata , function( data ) {
        
    }, "json")
    .fail(function(errir) {
        alert('Failed');
    })
    .always(function() {
        $("#humanbehaviour-form")[0].reset();
        humanbehaviour();
    });
     
    ;
});
