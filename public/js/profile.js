url = Hi.controller() + "userController.php?" + Hi.loginprotocol(); // controller address
url_contact = Hi.controller() + "contactController.php?" + Hi.loginprotocol();

function profile(username){
    $("input[name=previousUsername]").val(username);
    
    // Convert username to UserId
    $.get(url + "&Username=" + username, function(data, status){
        $("input[name=UserId]").val(data[0]["Id"]);
    });

    $.get(url_contact, function(data, status){
        
        $("tbody").html('');

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<button class="btn btn-sm" onclick="delete_contact(' + obj["Id"] + ')">Delete</button>'
                + '</th>'
                + '<td>' + obj["UserId"] + '</td>'
                + '<td>' + obj["Type"] + '</td>'
                + '<td>' + obj["Value"] + '</td>'
                + "</tr>"
            );
        });
    });
}

$("#changepassword-form").on('submit', function (event) { // submit event
    var mydata = $( "#changepassword-form" ).serialize(); // prepare data
    event.preventDefault(); // handle only javascript

    if (!mydata['New'] === mydata['HashPassword'])
    {
        alert('Password and it\'s confirm must be exactly the same.');
        return;
    }

    $.put( url, mydata , function( data ) {
        alert('Password changed successfuly');
    }, "json")
    .fail(function(errir) {
        alert('Task failed; please double check your data.');
    })
    .always(function() {
        $("#changepassword-form")[0].reset();
        profile();
    });
});

// TODO: Complete me
$("#contact-form").on('submit', function (event) {
    var mydata = $( "#contact-form" ).serialize();
    event.preventDefault();

    $.post( url_contact, mydata , function( data ) {
        
    }, "json")
    .always(function() {
        $("#contact-form")[0].reset();
        profile();
    });
});

function delete_contact(id) {
    $.delete( url_contact + "&Id=" + id, null , function( data ) {
        alert('Password changed successfuly');
    }, "json")
    .fail(function(errir) {
        console.log(errir.responseText);
        alert('Task failed; please double check your data.');
    })
    .always(function() {
        $("#changepassword-form")[0].reset();
        profile();
    });
}