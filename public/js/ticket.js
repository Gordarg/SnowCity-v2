url = Hi.controller() + "ticketController.php?" + Hi.loginprotocol(); // controller address

function ticket(){ // Constructor class

    $.get(url , function(data, status){ 

        $("tbody").html('');

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<button onclick="open_ticket(' + obj['Id'] + ')" type="button" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#myModal">View Ticket</button>'
                + '<button onclick="view_email(' + obj['Id'] + ')" type="button" class="btn btn-info btn-sm m-2" >View Email</button>'
                + '</th>'
                + '<td>' + obj["Id"] + '</td>'
                + '<td>' + obj["Title"] + '</td>'
                + '<td>' + obj["Priority"] + '</td>'
                + '<td>' + obj["SenderEmail"] + '</td>'
                + '<td>' + obj["SubmitDate"] + '</td>'
                + '<td>' + obj["AdminId"] + '</td>'             
                + '<td>' + obj["IsValid"] + '</td>'
                + "</tr>"
            );
        });
    });
}

function open_ticket(i)
{
    $('#tickets').html('');
    $.get(url + "&Id=" + i , function(data, status){
        $('.modal-title').html(data[0]['Title']);
        $('#tickets').prepend(
            '<div class="">'
            + data[0]['SenderEmail']
            + '<pre>' + data[0]['Message'] + '</pre>'
            + '</div>'
        );
    });
}