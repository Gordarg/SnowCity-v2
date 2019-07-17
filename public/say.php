<?php
// include models
include_once BASEPATH.'model/Post.php';

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
else if (isset($_POST["delete"])) {
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
    exit(header("Location: " . $BASEURL . 'say/' . $Post->GetProperties()['Language'] . '/' . $Post->GetProperties()['MasterId'] ));
}

// Select Post Details for Edit Window

$lines = array();
if (Functionalities::IfExistsIndexInArray($PATHINFO, 3) != null)
{
    $Title = Functionalities::IfExistsIndexInArray($row,'Title');
    $Level = Functionalities::IfExistsIndexInArray($row,'Level');
    $RefrenceID = Functionalities::IfExistsIndexInArray($row,'RefrenceId');
    $Body = Functionalities::IfExistsIndexInArray($row,'Body');
}
else
{
    
    $MasterID = Functionalities::GenerateGUID();
    $Title = '';
    $Language = CURRENTLANGUAGE;
    $Level = '0';
    $Body = '';

    // Make an instance of Post{}
    $Post = new Post();
    $Post->AuthConstruct($USERNAME, $USERTOKEN);
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
<form id="gordform" method="post" action="' . $BASEURL . 'say/' . (Functionalities::IfExistsIndexInArray($PATHINFO, 3) != null ? ($PATHINFO[2] . '/' . $PATHINFO[3]) : '' )  . '" enctype="multipart/form-data">
<input type="hidden" name="masterid" value="' . $MasterID . '" />
<input type="hidden" name="language" value="' . CURRENTLANGUAGE . '" />

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

<?php
if (Functionalities::IfExistsIndexInArray($PATHINFO, 4) == 'delete' && $row != null)
{
    echo ' 
    <div class="alert alert-danger" role="alert">
        ' . $Translate::Label('آیا اطمینان دارید؟') . '
    </div>
    <input type="submit" name="delete" class="btn btn-dark m-1" value="' . $Translate->Label("حذف") . '" />
    <a class="btn btn-info m-1" href="' . $BASEURL . 'say/' . $Language . '/' . $MasterID . '">' . $Translate->Label("بازگشت") . '</a>
    ';
}
else if ($row != null) {
    //TODO (ADMIN): echo '<input type="submit" class="btn btn-outline-primary m-1" name="publish" value="' . $Translate->Label("انتشار") . '" />';
    echo '<input type="submit" name="draft" class="btn btn-secondary m-1" value="' . $Translate->Label("پیش‌نویس") . '" />';
    echo '<input type="submit" name="update" class="btn btn-success m-1" value="' . $Translate->Label("به روز رسانی") . '" />';
    echo '<input type="submit" name="clear" class="btn btn-warning m-1" value="' . $Translate->Label("حذف پیوست") . '" />';
    echo '<input type="submit" name="block" class="btn btn-danger m-1" value="' . $Translate->Label("بلوکه") . '" />';
    echo '<a class="btn btn-dark m-1 text-light" href="' . $BASEURL . 'say/' . $Language . '/' . $MasterID . '/delete' . '">' . $Translate->Label("حذف") . '</a>';
    echo '<a target="_blank" class="m-1" href="' . $BASEURL . 'view/' . CURRENTLANGUAGE . '/' . $row['MasterID'] . '">' . $Translate->Label("مشاهده") . '</a>';
}
else {
    echo '<input type="submit" name="draft" class="btn btn-secondary m-1" value="' . $Translate->Label("پیش‌نویس") . '" />';
    echo '<input type="submit" class="btn btn-success m-1" name="insert" value="' . $Translate->Label("ارسال") . '" />';
}
?>
</form>
<?php
if (!$AJAX)
{
    echo '
    </main>
  ';
}
?>