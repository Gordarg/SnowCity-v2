url = Hi.controller() + "humanbehaviourController.php?" + Hi.loginprotocol(); // controller address

function humanbehaviour(){ // Constructor class

    $('input[name="UserId"]').val($.cookie("USERID"));

    $.get(url , function(data, status){ 

        $("tbody").html('');

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<a href="#">Delete</a>'
                + '</th>'
                + '<td>' + obj["Id"] + '</td>'
                + '<td>' + obj["Year"] + '</td>'
                + '<td>' + obj["Month"] + '</td>'
                + '<td>' + obj["Day"] + '</td>'
                + '<td>' + obj["From"] + '</td>'
                + '<td>' + obj["To"] + '</td>'
                + '<td>' + obj["Quality"] + '</td>'
                + '<td>' + obj["Task"] + '</td>'
                + '<td>' + obj["Brief"] + '</td>'
                + '<td>' + obj["UserId"] + '</td>'
                // TODO: We can assign a humanbehaviour to a post
                + "</tr>"
            );
        });
    });
}

$("#humanbehaviour-form").on('submit', function (event) { // submit event
    var mydata = $( "#humanbehaviour-form" ).serialize(); // prepare data
    event.preventDefault(); // handle only javascript

    $.post( url, mydata , function( data ) {

    }, "json")
    .fail(function(errir) {
        console.log('Error', errir);
    })
    .always(function() {
        $("#humanbehaviour-form")[0].reset();
        humanbehaviour();
    });
     
    ;
});
