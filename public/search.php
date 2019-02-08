<?php
include ('core/init.php');
include ('master/public-header.php');
require_once 'core/functionalities.php';
use core\functionalities;
require_once 'semi-orm/Posts.php';
use orm\Posts;
require_once  $parent . '/plug-in/Parsedown.php';
$functionalitiesInstance = new functionalities();
$Parsedown = new Parsedown();
$Q = Functionalities::IfExistsIndexInArray($_GET,'Q');
?>
<form class="example" method="GET" action="search.php">
    <input type="text" name="Q" placeholder="<?= $Translate->Label("عبارت را وارد نمائید"); ?>" value="<?= $Q ?>" />
    <input type="submit" value = "<?= $Translate->Label("جستجو"); ?>" />
</form>
<?php
if ($Q != null)
{
    $a="SELECT DISTINCT
    `A`.* FROM `post_details` `A`

    LEFT OUTER JOIN `post_details` as pd2
    ON A.MasterID = pd2.RefrenceID

    WHERE
    (
        `A`.`Title` LIKE '%". $Q ."%'
    OR `pd2`.`Title` LIKE '%". $Q ."%'
    OR CONCAT ('@', `A`.`Username`) LIKE '". $Q ."'
    OR `A`.`Body` LIKE '%". $Q ."%'
    )
    AND
    (
        `A`.`Type` = 'POST'
    OR  `A`.`Type` = 'COMT' 
    OR  `A`.`Type` = 'FILE' 
    -- OR  `A`.`Type` = 'KWRD' 
    OR  `A`.`Type` = 'QUST'
    )
    AND
    (
        (
            `pd2`.`Type` = 'POST'
            AND
            `A`.RefrenceID IS NOT NULL
        )
        OR
        (
            `A`.RefrenceID IS NULL
        )
    )

    ORDER BY `A`.`Submit`
    Limit 10
    ;";
    $b=mysqli_query($conn,$a);
    // echo $a;
    if ($b->num_rows > 0) {
        while($row = mysqli_fetch_array($b)){
            echo '<div class="' . $row['Type'] . '">';
            switch ($row['Type'])
            {
                case 'COMT':
                    echo '<a href="view.php?lang=' . $row['Language'] . '&id=' . $row['RefrenceID'] . '">' . $row['Body']. '</a>';
                    break;
                case 'FILE':
                    echo '<a href="download.php?id=' . $row['MasterID'] . '">' . $row['Title']. '</a>';
                    break;
                case 'POST':
                    echo '<a href="view.php?lang=' . $row['Language'] . '&id=' . $row['MasterID'] . '">' .
                    '<img src="download.php?id=' . $row['MasterID'] . '" alt="' . $row['Title'] . '" />' .
                    '<span>' . $row['Title'] . '</span>' .
                    '<p>' . Text::GenerateAbstractForPost($Parsedown->text($row['Body']), 480)  . '</p>' .
                    '</a>';
                    break;
                case 'QUST':
                    echo '<a href="view.php?lang=' . $_COOKIE['LANG'] . '&id=' . $row['MasterID'] . '">' . $row['Title']. '</a>';
                    break;
                // case 'KWRD':
                //     echo '<a href="view.php?id=' . $row['RefrenceID'] . '">' . $row['Title']. '</p>';
                //     break;
            }
            echo "</div>";
        }
    }
    else{
        echo $Translate->Label("نتیجه یافت نشد");
    }
}
?>

<?php
include ('master/public-footer.php');
?>
