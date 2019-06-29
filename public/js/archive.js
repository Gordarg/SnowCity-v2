function archive(){ // Constructor class

    // TODO: Needs attention
    $.get(Hi.controller() + "PostController.php?BinContent=✓&Type=POST&" + Hi.loginprotocol() , function(data, status){ 
    
        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<a href="' + Hi.baseurl() + "say/post/" + obj["Language"] + '/' + obj['MasterID'] +'">Edit</a>'
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