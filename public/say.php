<?php
// Handle html method="post"

include_once BASEPATH.'model/Post.php';

?>



<?php

// Default values

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
$UserID = Functionalities::IfExistsIndexInArray($_COOKIE, 'USERID');
                            // TODO: WHY the function recived array? [0]
$Level = 1;
$Body = '';
$Status = 'Publish';
$Content = null;
$RefrenceID = null;


?>



<?php

// TODO: Maybe following lines are describing post method

switch ($Type)
{

    // case "QUST":
    //     $MasterID = Functionalities::IfExistsIndexInArray($PATHINFO, 4);
    //     $Language = Functionalities::IfExistsIndexInArray($PATHINFO, 3);
    //     $row = $Post->Select(-1, 1, 'MasterID', 'ASC', "WHERE `Language`='" . $Language . "' AND `MasterID`='" . $Id . "'")[0];
    //     $Title = Functionalities::IfExistsIndexInArray($row,'Title');
    //     $Level = Functionalities::IfExistsIndexInArray($row,'Level');
    //     $Body = html_entity_decode(Functionalities::IfExistsIndexInArray($row,'Body'));
    //     break;

    // case "ANSR":
    //     $data = array();
    //     foreach($_POST as $key => $value)
    //     {
    //         if (substr($key, 0, 5) === 'form_')
    //         $data[substr($key, 5)] = $value;
    //         else continue;
    //     }
    //     $Body = json_encode($data, JSON_UNESCAPED_UNICODE);
    //     break;

}



$Post = new Post();

if (isset($_POST['masterid']))
{
    $Post->SetValue("MasterId",  $_POST['masterid']);
    $Post->SetValue("Title",  $_POST['title']);
    $Post->SetValue("Submit", $_POST['submit']);
    $Post->SetValue("Type", $_POST['type']);
    $Post->SetValue("Language", $_POST['language']);
    $Post->SetValue("Level", (Functionalities::IfExistsIndexInArray($_POST, 'level') == NULL) ? "NULL" : $_POST['level']);
    $Post->SetValue("Body", $_POST['body']);
    $Post->SetValue("UserId", $_POST['userid']);
    $Post->SetValue("RefrenceId", (Functionalities::IfExistsIndexInArray($_POST, 'refrenceid') == NULL) ? "NULL" : mysqli_real_escape_string($conn, ($_POST['refrenceid'])));
    $Post->SetValue("Index", ((Functionalities::IfExistsIndexInArray($_POST, 'index') == NULL) ? "NULL" : $_POST['index']));
    
    if (isset($_POST["block"])) // BLOCK A CONTENT WITHOUT DELETING
        $Post->SetValue("Status", 'BLOCKED');
    else if (isset($_POST["approve"])) // USED FOR ANSWERS
        $Post->SetValue("Status", 'APPROVED');
    else if (isset($_POST["pubilsh"])) // CAN BE VIEWED BY PUBLIC
        $Post->SetValue("Status",  'PUBLISHED');
    else if (isset($_POST["draft"])) // DRAFT FOR LATER USE
        $Post->SetValue("Status", 'DRAFT');
    else if (isset($_POST["insert"]) || isset($_POST["update"])) // WAITING FOR ADMIN TO PUBLISH
        $Post->SetValue("Status", 'SENT');

    $Post->Insert();
    // $Id = $Post->GetProperties()['Id'];
}

if (isset($_POST["delete"])) {
    $Post->SetOperand("IsDeleted");
    $Post->SetValue("IsDeleted", "1");
    $Post->Update();
    $Post->ClearOperands("IsDeleted");
}
else if (isset($_POST["clear"]))
{
    $Post->SetOperand("IsContentDeleted");
    $Post->SetValue("IsContentDeleted", "1");
    $Post->Update();
    $Post->ClearOperands("IsContentDeleted");
}
else if (((isset($_POST["update"])) or (isset($_POST["insert"])))
        && ($_FILES['content']['size'] > 0))
{
    $Post->SetOperand("BinContent");
    $Post->SetValue("BinContent", ',' . urlencode(base64_encode(file_get_contents($_FILES['content']['tmp_name']))));
    $Post->Update();
}

if (!empty($_POST))
{
    if (isset($_POST["delete"]))
        exit(header("Location: " . $BASEURL . 'dashboard' ));
    else
        exit(header("Location: " . $BASEURL . 'say/post/' . $_POST['language'] . '/' . $_POST['masterid']));
}

?>

<?php

// Select Post Details for Edit Window

$row = null;
if (Functionalities::IfExistsIndexInArray($PATHINFO, 4) != null)
{
    $MasterID = Functionalities::IfExistsIndexInArray($PATHINFO, 4);
    $Language = Functionalities::IfExistsIndexInArray($PATHINFO, 3);
    $row = $Post->Select(-1, 1, 'MasterID', 'ASC', "WHERE `Language`='" . $Language . "' AND `MasterID`='" . $MasterID . "'");
    if (sizeof($row) > 0)
    {
        $row = $row[0];
        $Title = Functionalities::IfExistsIndexInArray($row,'Title');
        $Level = Functionalities::IfExistsIndexInArray($row,'Level');
        $Body = Functionalities::IfExistsIndexInArray($row,'Body');
    }
}
// TODO: We have to do some operations on $body based on type

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
switch ($Type)
{
    case 'POST':
        echo '
            <input type="hidden" name="submit" value="' . $Submit . '" />
            <input type="hidden" name="userid" value="' . $UserID . '" />
            <input type="hidden" name="index" value="' . $Index . '" />
            <input type="hidden" name="refrenceid" value="' . $RefrenceID . '" />
            <input type="hidden" name="status" value="' . $Status . '" />
            <input type="hidden" name="language" value="' . $CURRENTLANGUAGE . '" />

            <label for="title">' . Translate::Label("عنوان") . '</label>
            <input class="form-control" name="title" required placeholder="' . Translate::Label("عنوان") . '" type="text" value="' . $Title . '" />

            <label for="level">' . Translate::Label("مرتبه") . '</label>
            <select class="form-control"  name="level">
            <option ' . ( ($Level == "1") ? "selected" : "" ) . ' value="1">' . Translate::Label("سریع") . ' - ' . Translate::Label("بالا") . '</option>
            <option ' . ( ($Level == "2") ? "selected" : "" ) . ' value="2">' . Translate::Label("متوسط") . ' - ' . Translate::Label("مرکز") . '</option>
            <option ' . ( ($Level == "3") ? "selected" : "" ) . ' value="3">' . Translate::Label("کند") . ' - ' . Translate::Label("پایین") . '</option>
            </select>

            <label for="body">' . Translate::Label("متن") . '</label>
            <textarea name="body">' . $Body  . '</textarea>
            <label for="content">' . Translate::Label("پرونده") . '</label>
            <input class="form-control" type="file" name="content" id="file" />
            ';

            echo '<input type="submit" name="draft" class="btn btn-secondary m-1" value="' . $Translate->Label("پیش‌نویس") . '" />';

            if ($row != null) {
                //TODO (ADMIN): echo '<input type="submit" class="btn btn-outline-primary m-1" name="publish" value="' . $Translate->Label("انتشار") . '" />';
                echo '<input type="submit" name="update" class="btn btn-success m-1" value="' . $Translate->Label("به روز رسانی") . '" />';
                echo '<input type="submit" name="clear" class="btn btn-warning m-1" value="' . $Translate->Label("حذف پیوست") . '" />';
                echo '<input type="submit" name="block" class="btn btn-danger m-1" value="' . $Translate->Label("بلوکه") . '" />';
                echo '<input type="submit" name="delete" class="btn btn-dark m-1" value="' . $Translate->Label("حذف") . '" />';
                echo '<a target="_blank" class="m-1" href="' . $BASEURL . 'view/' . $_COOKIE['LANG'] . '/' . $row['MasterId'] . '">' . $Translate->Label("مشاهده") . '</a>';
            }
            else {
                echo '<input type="submit" class="btn btn-success m-1" name="insert" value="' . $Translate->Label("ارسال") . '" />';
            } 
        break;
}
?>
<input type="hidden" name="type" value="<?= $Type ?>" />
</form>
<?php
if (!$AJAX)
{
echo '
<a href="' . $BASEURL . 'dashboard">' . Translate::Label('داشبورد') . '</a>
</main>
';
}
?>