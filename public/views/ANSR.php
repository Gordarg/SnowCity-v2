<?php
switch ($_GET["level"])
{
    case "profile":
        echo '<div class="' . $row['Status'] . '">';
        echo  $refrence['Title'] ;
        echo '<div class="answers">';
        foreach (json_decode($row['Body'], true) as $key => $value)
        {
            echo '<span>' . str_replace("_"," ",$key)  . '</span><p>' .  $value . ' </p>';
        }
        echo '</div>';
        echo '</div>';
        break;
    default:
        echo '<div>';
        echo '<h4>' . $Translate->Label("فرستنده")  . ': <b><a href="profile.php?id=' . $row["UserID"] . '">' . $row['Username'] . '</a></b></h4>';
        echo '<div class="answers">';
        foreach (json_decode($row['Body'], true) as $key => $value)
        {
            echo '<span>' . str_replace("_"," ",$key)  . '</span><p>' .  $value . ' </p>';
        }
        echo '</div>';
        echo '</div>';
        break;
}
?>