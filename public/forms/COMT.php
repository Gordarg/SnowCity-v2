<input type="hidden" name="submit" value="<?= $Submit ?>" />
<input type="hidden" name="userid" value="<?= $UserID ?>" />
<input type="hidden" name="language" value="<?= $Language ?>" />
<input type="hidden" name="refrenceid" value="<?= $RefrenceID ?>" />
<input type="hidden" name="status" value="<?= $Status ?>" />
<label for="body"><?= $Translate->Label("دیدگاه"); ?></label>
<textarea name="body"><?= $Body ?></textarea>
<input type="submit" name="insert" value="<?= $Translate->Label("ارسال"); ?>" />