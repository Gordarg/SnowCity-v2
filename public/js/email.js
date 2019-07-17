url = Hi.controller() + "emailController.php?" + Hi.loginprotocol(); // controller address

function email(){ // Constructor class

    $.get(url , function(data, status){ 

        alert('Email synced!');

        $("tbody").html('');

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<a href="#">View Ticket</a>'
                + '</th>'
                + '<td>' + obj["Id"] + '</td>'
                + '<td>' + obj["SubmitDate"] + '</td>'
                + '<td>' + '<button onclick="open_email(' + obj['Id'] + ')" type="button" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#myModal">View Raw Data</button>' + '</td>'
                + '<td>' + obj["Sender"] + '</td>'
                + '<td>' + obj["Date"] + '</td>'
                + "</tr>"
            );
        });
    });
}

function open_email(id)
{
    $.get(url + "&Id=" + id , function(data, status){

        $('.modal-title').html(data[0]['Title']);
        $('#email_raw').html(data[0]['RAW']);
        $('#email_body').html(data[0]['Message']);
        $('#Outbound').html(data[0]['IsOutbound']);
        $('#MessageId').html(data[0]['MessageId']);
        $('#SubmitDate').html(data[0]['SubmitDate']);
        $('#Date').html(data[0]['Date']);
        $('#Sender').html(data[0]['Sender']);
    });

}
