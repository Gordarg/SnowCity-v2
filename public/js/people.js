function people(){ // Constructor class

    $.get(Hi.controller() + "userController.php?&" + Hi.loginprotocol() , function(data, status){ 

        data.forEach(obj => {

            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<button type="button" class="btn btn-primary" onclick="Hi.load(\'profile\',\'' + obj["Username"] + '\')">Edit</button>'
                + '</th>'
                + '<td>' + obj["Username"] + '</td>'
                + '<td>' + obj["IsActive"] + '</td>'
                + '<td>' + obj["Role"] + '</td>'
                + "</tr>"
            );
        });
    });
}