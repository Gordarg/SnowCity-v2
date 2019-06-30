function collection(){ // Constructor class

    // TODO: if ✓ then SetHeavyAllowed for The Property
    $.get(Hi.controller() + "PostController.php?BinContent=✓&Type=QUST&" + Hi.loginprotocol() , function(data, status){ 
    
        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<a class="m-1 btn-sm" href="' + Hi.baseurl() + "say/qust/" + obj["Language"] + '/' + obj['MasterID'] +'">Edit Form</a>'
                + '<a class="m-1 btn-sm" href="' + Hi.baseurl() + "form/" + obj["Language"] + '/' + obj['MasterID'] +'">View Form</a>'
                + '<a class="m-1 btn-sm" href="' + Hi.baseurl() + "form/" + obj["Language"] + '/' + obj['MasterID'] +'/answers">View Answers</a>'
                + '<a class="m-1 btn-sm" href="">Export Data</a>'
                + '</th>'
                + '<td>' + obj["Title"] + '</td>'
                + '<td>' + obj["Submit"] + '</td>'
                + '<td>' + obj["Username"] + '</td>'
                + '<td>' + obj["Status"] + '</td>'
                // + '<td style="overflow: hidden; word-break: break-all; width:100px;">' + obj["Body"] + '</td>'
                + (
                    (obj["BinContent"] != null)
                ?
                    '<td><img width="100" height="100" src="data:image/jpeg;base64,'+obj["BinContent"]+'" /></td></tr>'
                :
                    '<td>Image not found</td>'
                )
                + "</tr>"
            );
        });
    });
}