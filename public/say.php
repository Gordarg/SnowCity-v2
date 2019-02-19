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
$Level = '0';
$Body = '';
$Status = 'Publish';
$Content = null;
$RefrenceID = null;


?>



<?php

$Post = new Post();

// Handle Post

if ($Type == 'QUST')
{
    $FormItems = json_decode(html_entity_decode(Functionalities::IfExistsIndexInArray($_POST, 'temp_body')));
    if (!is_array($FormItems))
        $FormItems = array();
}

if (isset($_POST['form_add_submit']))
{

    // TODO: Reorder the array
    // $_POST['form_add_after']

    $item =        [
        $_POST['form_add_title'] ,
        $_POST['form_add_type'] 
    ];
    
    array_push($FormItems, $item);

    $Body = '';
    for ($i = 0 ; $i < sizeof($FormItems) ; $i++)
    {
        $Body .= str_replace(",", "-", $FormItems[$i][0]) . ",";
    }
    $Body .= '\n';
    for ($i = 0 ; $i < sizeof($FormItems) ; $i++)
    {
        $Body .= $FormItems[$i][1] . ', ';
    }

}
else if (isset($_POST['masterid']))
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

if (!empty($_POST)) // TODO: Disable redirects in Ajax calls (needs UI designer attention)
{
    if (isset($_POST["delete"]))
        exit(header("Location: " . $BASEURL . 'dashboard' ));
    else if (isset($_POST["form_add_submit"])) { 
        // Ignore
    }
    else if ($Post->GetProperties()['Type'] == 'QUST')
        exit(header("Location: " . $BASEURL . 'say/qust/' . $_POST['language'] . '/' . $_POST['masterid']));
    else if ($Post->GetProperties()['Type'] == 'POST')
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
    $row = $Post->Select(-1, 1, 'Id', 'DESC', "WHERE `Language`='" . $Language . "' AND `MasterID`='" . $MasterID . "'");
    if (sizeof($row) > 0)
    {
        $row = $row[0];
        $Title = Functionalities::IfExistsIndexInArray($row,'Title');
        $Level = Functionalities::IfExistsIndexInArray($row,'Level');

        switch ($Type)
        {
            case "POST":
                $Body = Functionalities::IfExistsIndexInArray($row,'Body');
                break;
            case "QUST":
                $Body = Functionalities::IfExistsIndexInArray($row,'Body');
                break;
        }
    }
}


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
<!--
    TODO: Disable redirects for ajax calls (Needs UI Designer Attention)
    <form id="gordform" method="post" action="<?= $BASEURL . ($AJAX ? "ajax/" : "") . 'say/' . $Type ?>" enctype="multipart/form-data"> -->
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
        break;
    
    case "QUST":
        // Level will count dynamic inputs
        echo '
            <input type="hidden" name="submit" value="' . $Submit . '" />
            <input type="hidden" name="userid" value="' . $UserID . '" />
            <input type="hidden" name="index" value="' . $Index . '" />
            <input type="hidden" name="status" value="' . $Status . '" />
            <input type="hidden" name="language" value="' . $CURRENTLANGUAGE . '" />
            <input type="hidden" name="level" value="' . $Level . '" /> <!-- Keeps form count -->
            <input type="hidden" name="body" value="' . $Body . '" />            
            <input type="hidden" name="temp_body" value="' . htmlentities(json_encode($FormItems)) . '" />            
            <div class="form-group">
            <label for="title">' . Translate::Label('عنوان') . '</label>
            <input type="text" class="form-control bg-dark text-light" name="title" value="' . $Title . '" />
            </div>
            <div class="form-group">
            <label for="refrenceid">' . Translate::Label('پیش نیاز') . '</label>
            <input type="text" class="form-control bg-dark text-light" name="refrenceid" value="' . $RefrenceID . '" /><!--TODO: پیش نیاز-->
            </div>
            '
            . '
            <div class="card">
                <div class="card bg-light text-dark m-4">
                <div class="form-inline card-body">
                ';

                $i = 0;
                foreach ($FormItems as $item)
                {
                    $i ++;

                    echo '
                    <div class="row">
                        <div class="form-group">
                            <label for="form_add_type">' . Translate::Label('عنوان') . '</label>
                            <input type="text" class="form-control m-1" value="' . $item[0] . '" />
                        </div>
                        <div class="form-group">
                            <label for="form_add_type">' . Translate::Label('نوع') . '</label>
                            <select class="form-control m-1" name="form_add_type">
                                <option ' . ($item[1] == 'Numeric' ? "selected" : "") . ' value="Numeric">' . Translate::Label('عددی') . '</option>
                                <option ' . ($item[1] == 'Characters' ? "selected" : "") . ' value="Characters">' . Translate::Label('رشته') . '</option>
                                <option ' . ($item[1] == 'File' ? "selected" : "") . ' value="File">' . Translate::Label('پرونده') . '</option>
                                <option ' . ($item[1] == 'Multiline Text' ? "selected" : "") . ' value="Multiline Text">' . Translate::Label('متن چند خط') . '</option>
                                <option ' . ($item[1] == 'Drop Down List' ? "selected" : "") . ' value="Drop Down List">' . Translate::Label('لیست آبشاری') . '</option>
                                <option ' . ($item[1] == 'Radio buttons' ? "selected" : "") . ' value="Radio buttons">' . Translate::Label('دکمه‌های رادیویی') . '</option>
                                <option ' . ($item[1] == 'Check Box' ? "selected" : "") . ' value="Check Box">' . Translate::Label('چک باکس') . '</option>
                                <option ' . ($item[1] == 'Agree Box' ? "selected" : "") . ' value="Agree Box">' . Translate::Label('باکس تائید') . '</option>
                                <option ' . ($item[1] == 'Heading' ? "selected" : "") . ' value="Heading">meta:' . Translate::Label('سر‌عنوان') . '</option>
                                <option ' . ($item[1] == 'Link' ? "selected" : "") . ' value="Link">meta:' . Translate::Label('پیوند') . '</option>
                                <option ' . ($item[1] == 'Long Text' ? "selected" : "") . ' value="Long Text">meta:' . Translate::Label('متن بلند') . '</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="form-operation-delete-' . $i . '" type="submit" class="form-control m-1 btn-sm btn-danger" value="' . Translate::Label('حذف') . '" />
                            <input name="form-operation-edit-' . $i . '" type="submit" class="form-control m-1 btn-sm btn-warning" value="' . Translate::Label('ویرایش') . '" />
                            <input name="form-operation-up-' . $i . '" type="submit" class="form-control m-1 btn-sm btn-info" value="' . Translate::Label('انتقال به بالا') . '" />
                            <input name="form-operation-down-' . $i . '" type="submit" class="form-control m-1 btn-sm btn-info" value="' . Translate::Label('انتقال به پایین') . '" />
                        </div>
                    </div>
                    ';

                    // Use commented lines in view page :)

                    // switch ($item[1])
                    // {
                    //     case "Numeric":
                    //         echo '<input class="form-control" type="number" name="form_item_' . $i . '" />';
                    //         break;
                    // }
                }
                if ($i == 0)
                echo Translate::Label('هیچ موردی یافت نشد');

                echo '                
                </div>
                </div>
                <div class="card bg-primary text-light m-4">
                    <div class="form-inline card-body">
                        <div class="form-group">
                            <label for="form_add_title">' . Translate::Label('عنوان') . '</label>
                            <input class="form-control m-1" type="text" name="form_add_title">
                        </div>
                        <div class="form-group">
                            <label for="form_add_type">' . Translate::Label('نوع') . '</label>
                            <select class="form-control m-1" name="form_add_type">
                                <option value="Numeric">' . Translate::Label('عددی') . '</option>
                                <option value="Characters">' . Translate::Label('رشته') . '</option>
                                <option value="File">' . Translate::Label('پرونده') . '</option>
                                <option value="Multiline Text">' . Translate::Label('متن چند خط') . '</option>
                                <option value="Drop Down List">' . Translate::Label('لیست آبشاری') . '</option>
                                <option value="Radio buttons">' . Translate::Label('دکمه‌های رادیویی') . '</option>
                                <option value="Check Box">' . Translate::Label('چک باکس') . '</option>
                                <option value="Agree Box">' . Translate::Label('باکس تائید') . '</option>
                                <option value="Heading">meta:' . Translate::Label('سر‌عنوان') . '</option>
                                <option value="Link">meta:' . Translate::Label('پیوند') . '</option>
                                <option value="Long Text">meta:' . Translate::Label('متن بلند') . '</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="form_add_after">' . Translate::Label('بعد از') . '</label>
                            <select class="form-control m-1" name="form_add_after">
                                <option value="0">' . Translate::Label('ابتدا') . '</option>'
                                //        . '<option value="test">Hello world</option>'
                            . '</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="form_add_submit" class="btn btn-primary btn-block btn-sm" value="' . $Translate->Label("افزودن فیلد") . '" />
                    </div>
                </div>
            </div>
        ';
        break;
}
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