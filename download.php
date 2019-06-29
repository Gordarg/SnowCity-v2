<?php
include ('core/Initialize.php');

$Id = $_GET["id"];

include_once BASEPATH.'model/Post.php';
$Post = new Post();
$Post->SetValue("BinContent", "✓");
$Post->DisableEncoding(true);
$item = $Post->Select(-1, 1, 'MasterID', 'ASC', "WHERE `MasterID`='" . $Id . "'")[0];
$content = $item["BinContent"];

$finfo = new finfo(FILEINFO_MIME);
$type = $finfo->buffer($content);
$size = strlen($content);

$delimiters = array("/",";"," ","=");
$ready = str_replace($delimiters, $delimiters[0], $type);
$launch = explode($delimiters[0], $ready);
$name = "Gord-" . $Id . '.' . $launch[1];

header("Content-type: " . $type);
header('Content-Disposition: attachment; filename="' . $name . '"');
// header("Content-Transfer-Encoding: base64");
header("Content-Transfer-Encoding: binary");
// header('Expires: 0');
// header('Pragma: no-cache');
header("Expires: ".gmdate("D, d M Y H:i:s", time()+1800)." GMT");
header("Cache-Control: max-age=1800");
header("Content-Length: " . $size);
echo $content;
?>