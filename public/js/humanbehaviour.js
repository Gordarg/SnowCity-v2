function humanbehaviour(){ // Constructor class

    $.get(Hi.controller() + "humanbehaviourController.php?" + Hi.loginprotocol() , function(data, status){ 
        
        alert(data);

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
                + "</tr>"
            );
        });
    });
}