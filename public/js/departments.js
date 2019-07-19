url = Hi.controller() + "departmentController.php?" + Hi.loginprotocol();
url_staff = Hi.controller() + "staffController.php?" + Hi.loginprotocol();

function departments() {
    $.get( url  , function(data, status){ 

        data.forEach(obj => {

            $("tbody#departments").append('<tr>'
                + '<th scope="row">'
                + '<button type="button" class="btn btn-primary" onclick="show_department(' + obj["Id"] + ')" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#myModal">Show</button>'
                + '</th>'
                + '<td>' + obj["Name"] + '</td>'
                + '<td>' + obj["IsPrivate"] + '</td>'
                + "</tr>"
            );
        });
    });
}

function show_department(id) {

    // Load department name
    $.get(url  + "&Id=" + id , function(data, status){ 

        $("input[name=\"Name\"]").val(data[0]['Name']);
        if (data[0]['IsPrivate'] === "1")
            $("input[name=\"IsPrivate\"]").prop("checked", true);
    });

    // Load department staff
    $.get(url_staff + "&DepartmentId=" + id , function(data, status){ 

        $(".modal-body table tbody").html('');

        $("input[name=\"DepartmentId\"]").val(id);

        data.forEach(obj => {

            $(".modal-body table tbody").append('<tr>'
                + '<th scope="row">'
                + '<button type="button" class="btn btn-primary" onclick="remove_assoc(' + obj['DepartmentId'] + ',' + obj["Id"] + ')" class="btn btn-info btn-sm m-2">Remove Assoc</button>'
                + '</th>'
                + '<td>' + obj["UserId"] + '</td>'
                + '<td>Loading the Username</td>'
                + "</tr>"
            );
        });
    });
}

function remove_assoc(depId,id) {
    $.delete( url_staff + "&Id=" + id, null , function( data ) {
        alert('Deleted Association');
    }, "json")
    .fail(function(errir) {
        console.log(errir.responseText);
    })
    .always(function() {
        show_department(depId);
    });
}