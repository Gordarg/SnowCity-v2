<?php
// Handle html method="post"

// require_once $parent . '/semi-orm/Posts.php';
// use orm\Posts;
// $conn  = $db->open();
// $Post = new Posts($conn);

// if (isset($_POST["type"]))
// {
//     $type = mysqli_real_escape_string($conn, $_POST['type']);
//     $body = $_POST['body'];
//     $title = (Functionalities::IfExistsIndexInArray($_POST, 'title') == NULL) ? "NULL" : "'" . mysqli_real_escape_string($conn, ($_POST['title'])) . "'";
//     if ($type  == "KWRD")
//     {
//         $title = "'#" . substr($title, 1);
//     }
//     if ($type == 'ANSR_status')
//     {
//         // TODO: Check if needed:
//         $body = html_entity_decode($body);
//         $type = 'ANSR';
//     }
//     else if ($type == 'COMT_delete')
//     {
//         $type = 'COMT';
//     }
//     else if ($type == 'KWRD_delete')
//     {
//         $type = 'KWRD';
//     }
//     else if ($type  == "ANSR")
//     {
//         $data = array();
//         foreach($_POST as $key => $value)
//         {
//             if (substr($key, 0, 5) === 'form_')
//             $data[substr($key, 5)] = $value;
//             else continue;
//         }
//         $body = json_encode($data, JSON_UNESCAPED_UNICODE);
//         $body = mysqli_real_escape_string($conn, $body);
//     }
//     else
//     {
//         $status = mysqli_real_escape_string($conn, $_POST['status']);
//         $body = mysqli_real_escape_string($conn, $body);
//     }
// }
// if (isset($_POST["Block"]))
//     $status = 'Block';
// else if (isset($_POST["approve"]))
//     $status = 'Approve';
// else if (isset($_POST["pubilsh"]))
//     $status = 'Publish';
// else if (isset($_POST["draft"]))
//     $status = 'Draft';  
// else if (isset($_POST["sent"]))
//     $status = 'Sent';
// else if (isset($_POST["insert"]))
//     $status = 'Sent';
// if (
//     isset($_POST["insert"]) ||
//     isset($_POST['update']) ||
//     isset($_POST['clear']) ||
//     isset($_POST['Block']) ||
//     isset($_POST['approve']) ||
//     isset($_POST['pubilsh']) ||
//     isset($_POST['draft']) ||
//     isset($_POST['sent'])
//     )
//     {
//         $Post->Insert([
//             ["MasterId", "'" . mysqli_real_escape_string($conn, $_POST['masterid']) . "'"],
//             ["Title", $title],
//             ["Submit", "'" . mysqli_real_escape_string($conn, $_POST['submit']) . "'"],
//             ["Type", "'" . $type . "'"],
//             ["Language", "'" . mysqli_real_escape_string($conn, $_POST['language']) . "'"],
//             ["Level", (Functionalities::IfExistsIndexInArray($_POST, 'level') == NULL) ? "NULL" : "'" . mysqli_real_escape_string($conn, ($_POST['level'])) . "'"],
//             ["Body", "'" . $body . "'"],
//             ["UserId", mysqli_real_escape_string($conn, $_POST['userid'])],
//             ["ContentDeleted", "0"],
//             ["Status", "'" . $status . "'"],
//             ["RefrenceId", (Functionalities::IfExistsIndexInArray($_POST, 'refrenceid') == NULL) ? "NULL" : "'" . mysqli_real_escape_string($conn, ($_POST['refrenceid'])) . "'"],
//             ["Index", mysqli_real_escape_string($conn, ((Functionalities::IfExistsIndexInArray($_POST, 'index') == NULL) ? "NULL" : $_POST['index']))],
//             ["Deleted", "0"],
//         ]);
// }
// else if (isset($_POST["delete"])) {
//     $Post->Delete($_POST['id'], 
//         $_POST['language']);
// }
// if (isset($_POST["clear"]))
// {
//     $Post->Update(mysqli_insert_id($conn),[
//         ["ContentDeleted", "1"],
//     ]);
// }
// else if ((isset($_POST["update"])) or (isset($_POST["insert"])))
// {
//     if ($_FILES['content']['size'] > 0) 
//     $Post->Update(mysqli_insert_id($conn), [
//         ["Content", 
//             "'" . mysqli_real_escape_string($conn, file_get_contents($_FILES['content']['tmp_name'])) . "'"],
//     ]);
// }
// if (!empty($_POST))
// {
//     if ($type == "FILE")
//         exit(header("Location: " . $npath . '/box.php'));
//     else if ($type == "ANSR" && (isset($_POST["delete"]) or isset($_POST["approve"]) or isset($_POST["Block"])))
//         exit(header("Location: " . $npath . '/view.php?lang=' . $_POST['language'] . '&id=' . $_POST['refrenceid']));
//     else if ($type == "ANSR")
//         exit(header("Location: " . $npath . '/profile.php?message=✓&id=' . $_POST['userid']));
//     else if ($type == "COMT")
//         exit(header("Location: " . $npath . '/view.php?lang=' . $_POST['language'] . '&id=' . $_POST['refrenceid']));
//     else if ($type == "KWRD")
//         exit(header("Location: " . $npath . '/post.php?lang=' . $_POST['language'] . '&id=' . $_POST['refrenceid']));

//     if (isset($_POST["delete"]))
//         exit(header("Location: " . $npath ));
    
//     if ($type == "QUST")
//         exit(header("Location: " . $npath . '/view.php?lang=' . $_POST['language'] . '&id=' . $_POST['masterid']));
//     else if ($type == "POST")
//         exit(header("Location: " . $npath . '/post.php?lang=' . $_POST['language'] . '&id=' . $_POST['masterid']));
// }
?>


<?php
// Load current post if Id passed

// // TODO: keywords just visible on edit
// include ('helper/post_keywords.php');
// $rows=[];
// $rows = $post->ToList(-1, -1, "Submit", "DESC", "WHERE `Type` = 'KWRD' AND `RefrenceId`='" . $RefrenceID . "'");
// echo '<div class="keywords">';
// foreach ($rows as $row) {
//     $_GET['masterid'] = $row['MasterID'];
//     $_GET["type"] = 'KWRD';
//     include ('views/render.php');
// }
// echo '</div>';
?>


<?php
// Set values
$Id = null;
$Type = strtoupper($PATHINFO[2]);

$MasterID = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
mt_rand( 0, 0xffff ),
mt_rand( 0, 0x0fff ) | 0x4000,
mt_rand( 0, 0x3fff ) | 0x8000,
mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));

$Title = '';
$Language = 'fa-ir';
$Index = '0';
$Submit = DATETIMENOW; // Comes from Initialize
$UserID = Functionalities::IfExistsIndexInArray($_SESSION, 'PHP_AUTH_ID');       // Comes from secure.php
                            // TODO: WHY the function recived array? [0]
$Level = 1;
$Body = '';
$Status = 'Publish';
$Content = null;
$RefrenceID = null;

// switch ($Type)
// {   
//     case "POST":
//         $Id = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'id'));
//         $Language = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'lang'));
//         if ($Id != null)
//             $MasterID = $Id;
//         $row = $Post->FirstOrDefault($Id, $Language);
//         $Id = $Post->GetIdByMasterId($MasterID, $Language);
//         $Title = Functionalities::IfExistsIndexInArray($row,'Title');
//         $Level = Functionalities::IfExistsIndexInArray($row,'Level');
//         $Body = Functionalities::IfExistsIndexInArray($row,'Body');
//         break;
//     case "COMT":
//         $Language = $CURRENTLANGUAGE; // Comes from Index
//         $RefrenceID = Functionalities::IfExistsIndexInArray($row,'RefrenceID');
//         if ($RefrenceID == "")
//             $RefrenceID = Functionalities::IfExistsIndexInArray($_GET, 'id');
//         break;
//     case "KWRD":
//         $RefrenceID = Functionalities::IfExistsIndexInArray($row,'RefrenceID');
//         if ($RefrenceID == "")
//             $RefrenceID = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'id'));
//         break;
//     case "FILE":
//         $Id = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'id'));
//         $Language = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'lang'));
//         if ($Id != null)
//             $MasterID = $Id;
//         $row = $Post->FirstOrDefault($Id, $Language);
//         $Id = $Post->GetIdByMasterId($MasterID, $Language);
//         $Title = Functionalities::IfExistsIndexInArray($row,'Title');
//         break;
//     case "QUST":
//         $Id = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'id'));
//         $Language = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'lang'));
//         if ($Id != null)
//             $MasterID = $Id;
//         $row = $Post->FirstOrDefault($Id, $Language);
//         $Id = $Post->GetIdByMasterId($MasterID, $Language);
//         $Title = Functionalities::IfExistsIndexInArray($row,'Title');
//         $Body = Functionalities::IfExistsIndexInArray($row,'Body');
//         break;
//     case "ANSR":
//         $RefrenceID = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'id'));
//         $Status = 'Sent';
//         break;
//     case "ANSR_status":
//         $Language = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'lang'));
//         $MasterID = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'masterid'));
//         $Id = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'id'));
//         $RefrenceID = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'refrenceid'));
//         $UserID = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'userid'));
//         $Submit = mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'submit'));
//         $Body = htmlentities(mysqli_real_escape_string($conn, Functionalities::IfExistsIndexInArray($_GET, 'body')));
//         break;
//     case "COMT_delete":
//         $Id = $Post->GetIdByMasterId(
//             Functionalities::IfExistsIndexInArray($_GET, 'masterid'),
//             Functionalities::IfExistsIndexInArray($_GET, 'langauge'));
//         $RefrenceID = Functionalities::IfExistsIndexInArray($_GET, 'refrenceid');
//         break;
//     case "KWRD_delete":
//         $Id = $Post->GetIdByMasterId(
//             Functionalities::IfExistsIndexInArray($_GET, 'masterid'),
//             Functionalities::IfExistsIndexInArray($_GET, 'langauge'));
//         $RefrenceID = Functionalities::IfExistsIndexInArray($_GET, 'refrenceid');
//         break;
// }

?>
<?php
if (!$AJAX)
{
    echo '
    <nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">' . Translate::Label('پست') . '</a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="' . $BASEURL . 'dashboard">' . Translate::Label('بازگشت') . '</a>
      </li>
    </ul>
    </nav>
    <main role="main" class="container p-5">
  ';
}
?>
<form id="gordform" method="post" action="<?= $BASEURL . 'say/' . $Type ?>" enctype="multipart/form-data">
<input type="hidden" name="masterid" value="<?= $MasterID ?>" />
<?php
// Render form
include BASEPATH . 'public/forms/' . $Type . '.php'; 
?>
<input type="hidden" name="type" value="<?= $Type ?>" />
</form>
<?php
if (!$AJAX)
{
echo '
</main>
';
}
?>