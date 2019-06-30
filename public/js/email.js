url = Hi.controller() + "emailController.php?" + Hi.loginprotocol(); // controller address

function email(){ // Constructor class

    $.get(url , function(data, status){ 

        $("tbody").html('');

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<a href="#">Delete Email</a>'
                + '<a href="#">View Ticket</a>'
                + '</th>'
                + '<td>' + obj["Id"] + '</td>'
                + '<td>' + obj["SubmitDate"] + '</td>'
                + '<td>' + 'view raw' + '</td>'
                + '<td>' + obj["Sender"] + '</td>'
                + '<td>' + obj["Date"] + '</td>'
                + '<td>' + obj["MessageNormal"] + '<a href="#">View original</a>' + '</td>'
                + "</tr>"
            );
        });
    });
}
