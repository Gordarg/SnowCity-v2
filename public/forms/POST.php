<input type="hidden" name="id" value="<?= $Id ?>" />
<input type="hidden" name="submit" value="<?= $Submit ?>" />
<input type="hidden" name="userid" value="<?= $UserID ?>" />
<input type="hidden" name="index" value="<?= $Index ?>" />
<input type="hidden" name="refrenceid" value="<?= $RefrenceID ?>" />
<input type="hidden" name="status" value="<?= $Status ?>" />
<input type="hidden" name="language" value="<?= $CURRENTLANGUAGE ?>" />

<label for="title"><?= $Translate->Label("عنوان"); ?></label>
<input class="form-control" name="title" required placeholder="<?= $Translate->Label("عنوان"); ?>" type="text" value="<?= $Title ?>" />

<label for="level"><?= $Translate->Label("مرتبه"); ?></label>
<select class="form-control"  name="level">
  <option <?= ($Level == "1") ? "selected" : ""  ?> value="1"><?= $Translate->Label("سریع"); ?> - <?= $Translate->Label("بالا"); ?></option>
  <option <?= ($Level == "2") ? "selected" : ""  ?> value="2"><?= $Translate->Label("متوسط"); ?> - <?= $Translate->Label("مرکز"); ?></option>
  <option <?= ($Level == "3") ? "selected" : ""  ?> value="3"><?= $Translate->Label("کند"); ?> - <?= $Translate->Label("پایین"); ?></option>
</select>

<label for="body"><?= $Translate->Label("متن"); ?></label>
<textarea name="body"><?= $Body  ?></textarea>
<label for="content"><?= $Translate->Label("پرونده"); ?></label>
<input class="form-control" type="file" name="content" id="file" />
<?php
/*
TODO: create drafting and publish mechanisms
      based on user role

    echo '<input type="submit" name="draft" value="پیش‌نویس" />';
    echo '<input type="submit" name="edit" value="ویرایش" />';
    echo '<input type="submit" name="publish" value="انتشار عمومی" />';
    echo '<input type="submit" name="burn" value="لغو انتشار" />';
*/
if ($Id == null ) {
    echo '<input type="submit" name="insert" value="' . $Translate->Label("ارسال") . '" />';
} else {
    echo '<input type="submit" name="update" value="' . $Translate->Label("به‌روز رسانی") . '" />';
    echo '<input type="submit" name="delete" value="' . $Translate->Label("حذف") . '" />';
    echo '<input type="submit" name="clear" value="' . $Translate->Label("حذف پیوست") . '" />';
    echo '<a href="view.php?lang=' . $_COOKIE['LANG'] . '&id=' . $row['MasterID'] . '">' . $Translate->Label("مشاهده") . '</a>';
}
    echo '<a href="' . $BASEURL . 'dashboard">' . $Translate->Label("انصراف") . '</a>';
?>