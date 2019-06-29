<?php
include_once BASEPATH.'model/Post.php';

// Default values

$MasterID = Functionalities::GenerateGUID();

$Title = '';
$Language = $CURRENTLANGUAGE;
$Index = '0';
$Level = '0';
$Body = '';
$Status = 'Publish';
$Content = null;

$Post = new Post();

// Handle HTTP_POST
if (
isset($_POST["block"]) ||
isset($_POST["approve"]) ||
isset($_POST["pubilsh"]) ||
isset($_POST["draft"]) ||
isset($_POST["insert"]) ||
isset($_POST["update"])
)
{    
    if (isset($_POST["block"])) // BLOCK A CONTENT WITHOUT DELETING
        $Status =  'BLOCKED';
    else if (isset($_POST["approve"])) // USED FOR ANSWERS
        $Status =  'APPROVED';
    else if (isset($_POST["pubilsh"])) // CAN BE VIEWED BY PUBLIC
        $Status =   'PUBLISHED';
    else if (isset($_POST["draft"])) // DRAFT FOR LATER USE
        $Status =  'DRAFT';
    else if (isset($_POST["insert"]) || isset($_POST["update"])) // WAITING FOR ADMIN TO PUBLISH
        $Status =  'SENT';

    $Post->SendPost(
        $_POST['masterid']
        , $_POST['title']
        , Functionalities::IfExistsIndexInArray($_POST, 'level')
        , $_FILES['content']
        , $_POST['body']
        , $Status
        , $_POST['language']
    );
    // $Id = $Post->GetProperties()['Id'];
}

if (isset($_POST["delete"])) {
    $Post->DeletePost($_POST['masterid']);
}
else if (isset($_POST["clear"]))
{
    $Post->DeletePostAttachment($_POST['masterid']);
}

if (isset($_POST["delete"]))
    exit(header("Location: " . $BASEURL . 'dashboard' ));
else if (
    isset($_POST["block"]) ||
    isset($_POST["approve"]) ||
    isset($_POST["pubilsh"]) ||
    isset($_POST["draft"]) ||
    isset($_POST["insert"]) ||
    isset($_POST["update"]) ||
    isset($_POST["clear"])
)
// TODO: Disable redirects in Ajax calls (needs UI designer attention)
{
    exit(header("Location: " . $BASEURL . 'say/post/' . $Post->GetProperties()['Language'] . '/' . $Post->GetProperties()['MasterId'] ));
}

// Select Post Details for Edit Window
$row = null;
$lines = array();
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
        $RefrenceID = Functionalities::IfExistsIndexInArray($row,'RefrenceId');
        $Body = Functionalities::IfExistsIndexInArray($row,'Body');
    }
}

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

echo '
<form id="gordform" method="post" action="' . $BASEURL . 'say/' . $Type . (Functionalities::IfExistsIndexInArray($PATHINFO, 4) != null ? ('/' . $PATHINFO[3] . '/' . $PATHINFO[4]) : '' )  . '" enctype="multipart/form-data">
<input type="hidden" name="masterid" value="' . $MasterID . '" />
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
?>