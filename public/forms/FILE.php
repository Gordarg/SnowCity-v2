<input type="hidden" name="id" value="<?= $Id ?>" />
<input type="hidden" name="submit" value="<?= $Submit ?>" />
<input type="hidden" name="userid" value="<?= $UserID ?>" />
<input type="hidden" name="index" value="<?= $Index ?>" />
<input type="hidden" name="refrenceid" value="<?= $RefrenceID ?>" />
<input type="hidden" name="status" value="<?= $Status ?>" />
<input type="hidden" name="language" value="<?= $CURRENTLANGUAGE ?>" />

<label for="title"><?= $Translate->Label("اسم"); ?></label>
<input name="title" required placeholder="<?= $Translate->Label("اسم"); ?>" type="text" value="<?= $Title ?>" />
<input type="file" name="content" id="file" />
<?php
if ($Id == null ) {
    echo '<input type="submit" name="insert" value="' . $Translate->Label("ارسال") . '" />';
} else {
    echo '<input type="submit" name="update" value="' . $Translate->Label("به‌روز رسانی") . '" />';
    echo '<input type="submit" name="delete" value="' . $Translate->Label("حذف") . '" />';
}
?>