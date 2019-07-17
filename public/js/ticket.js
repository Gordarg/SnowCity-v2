url = Hi.controller() + "ticketController.php?" + Hi.loginprotocol(); // controller address

function ticket(){ // Constructor class

    $.get(url , function(data, status){ 

        $("tbody").html('');

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<button onclick="open_ticket(' + obj['Id'] + ')" type="button" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#myModal">View Ticket</button>'
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

        $('.modal-title').html(data[0]['Title'] + ' - Priority: ' + data[0]['Priority']);
        $('#operations').html(`
        <textarea class="form-control" name="body" ></textarea>
        <input type="submit" name="send" class="btn btn-primary" value="Send" />
        <input type="submit" name="close" class="btn btn-warning" value="Close" />
        <!--<input type="submit" name="delete" class="btn btn-danger" value="Delete" />-->
        Assign to: ....
        `);

        data.forEach(obj => {
            $('#tickets').prepend(
                `
                <div class="card m-1">
                <!--
                <img class="card-img-top" src="Logo.svg" alt="Attachment if is image">
                -->
                <div class="card-body">
                    <h5 class="card-title">` + obj['SenderEmail'] + `</h5>
                    <h6 class="card-subtitle mb-2 text-muted">` + obj['Title'] + `</h6>
                    <p class="card-text">
                    ` + obj['Message'] + `
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Submit Date </b>` + obj['SubmitDate'] + `</li>
                </ul>
                <div class="card-body">
                    <a href="#` + obj['ValidationCode'] + obj['IsValid'] + `" class="card-link">Send Activation Email</a>
                    <a href="#` + obj['EmailId'] + `" class="card-link">View Email</a>
                </div>
                </div>
                
                `
            );
        });

    });
}