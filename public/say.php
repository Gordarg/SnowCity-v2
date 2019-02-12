<?php
// include_once ('core/init.php');
// include ('core/secure.php');
// include ('forms/submit.php');
// include ('master/public-header.php');
// $_GET['type'] = "POST";
// require_once ('forms/render.php');
// require_once 'semi-orm/Posts.php';
// use orm\Posts;
// $post = new Posts($conn);
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
// include ('master/public-footer.php');
?>
<?php
switch ($PATHINFO[2])
{
    case "comt":
        print('hello world');
        break;
}