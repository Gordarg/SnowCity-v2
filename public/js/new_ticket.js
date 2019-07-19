url_department = Hi.controller() + "departmentController.php?" + Hi.loginprotocol();
url = Hi.controller() + "ticketController.php?" + Hi.loginprotocol();

function new_ticket() {

    $('input[name="UserId"]').val($.cookie("USERID")); // If was user mode

    // TODO: Set admin id if it was admin mode
    // Turn flag on in server side if admin id wasn't null

    $.get(url_department, function(data, status){ 

        data.forEach(obj => {
            $("select").append(
                '<option value="' + obj['Id'] + '">' + obj['Name'] + '</option>'
            );
        });
    });
}

$("#new_ticket").on('submit', function (event) {

    var mydata = $("#new_ticket").serialize();
    event.preventDefault();


    // TODO: Handle post errors
    $.post( url, mydata);

    // TODO: clear form if post was OK
    $("#new_ticket").trigger("reset"); // trigger method to reset forms everywhere // TODO
    
});
