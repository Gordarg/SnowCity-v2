<input type="hidden" name="submit" value="<?= $Submit ?>" />
<input type="hidden" name="language" value="<?= $Language ?>" />
<input type="hidden" name="userid" value="<?= $UserID ?>" />
<input type="hidden" name="refrenceid" value="<?= $RefrenceID ?>" />
<input type="hidden" name="status" value="<?= $Status ?>" />
<label for="title"><?= $Translate->Label("کلمه‌ی کلیدی"); ?></label>
<input type="text" name="title" required value="<?= $Title  ?>" />
<input type="submit" name="insert" value="<?= $Translate->Label("ارسال"); ?>" />
