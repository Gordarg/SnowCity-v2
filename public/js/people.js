function people(){ // Constructor class

    $.get(Hi.controller() + "userController.php?&" + Hi.loginprotocol() , function(data, status){ 

        data.forEach(obj => {

            $("tbody").append('<tr>'
                + '<th scope="row">'
                // + '<a href="' + Hi.baseurl() + "say/post/" + obj["Language"] + '/' + obj['MasterID'] +'">Edit</a>'
                + '</th>'
                + '<td>' + obj["Username"] + '</td>'
                + '<td>' + obj["IsActive"] + '</td>'
                + '<td>' + obj["Role"] + '</td>'
                + "</tr>"
            );
        });
    });
}