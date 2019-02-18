<?php
if ($row == null)
{
    exit(header("HTTP/1.0 404 Not Found"));
}
?>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
    <div class="inner">
      <h3 class="masthead-brand"><?php echo Translate::Label(Config::NAME, $row['Language']) ?></h3>
      <nav class="nav nav-masthead justify-content-center">
        <a class="nav-link" href="<?php echo $BASEURL ?>"><?php echo Translate::Label("خانه", $row['Language']) ?></a>
        <a class="nav-link active" href="#"><?php echo Translate::Label("پست", $row['Language']) ?></a>
        <a class="nav-link" href="#comments"><?php echo Translate::Label("نظرات", $row['Language']) ?></a>
        <?php //TODO: If was admin enable edit ?>
        <a class="nav-link" href="<?php echo $BASEURL . 'say/post/' . $row['Language'] . '/' . $row['MasterID'] ?>"><?php echo Translate::Label("ویرایش", $row['Language']) ?></a>
      </nav>
    </div>
  </header>

  <main role="main" class="inner cover">
    <img class="img-fluid" src="<?php echo $BASEURL . 'download.php?id=' . $row['MasterID'] ?>"
    <h1 class="cover-heading"><?php echo $row['Title'] ?></h1>
    <p class="lead">
      <a href="<?php echo $BASEURL . 'explore/@' . $row['Username'] ?>" class="btn btn-lg btn-secondary"><?php echo $row['Username'] ?></a>
      <span><?php echo $row['Submit'] ?></span>
      <!-- <a class="attachment" href="download.php?id=' . $Id . '">' . $functionalitiesInstance->label("دانلود پیوست") . '</a>' -->
    </p>
    <article>
    <?php echo $Parsedown->text($row['Body']) ?>   
    </article>

    <?php
    // TODO:
    ?>
    <div id="comments">
      <div id="newcomment"></div>
      <?php
      foreach ($PostDetail->Select(-1, -1, "Submit", "DESC", "WHERE `Type` = 'COMT' AND `RefrenceId`='" . $Id . "'") as $row) {
          $_GET['masterid'] = $row['MasterID'];
          $_GET["type"] = 'COMT';
          
          echo '<div>';
          /*
          $UserId = $authentication->login('comment_helper.php');
          if ($UserId != null)
          {
              // echo $row['MasterID'];
              // TODO: Delete
          }
          */
          echo '<img src="drawable/profile.png" />';
          echo '<span>' . $row['Body'] . '</span>';
          // TODO
          // include ('helper/post_comment_delete.php');
          echo '</div>';
      }
      ?>
    </div>
    <div id="keywords">
        <?php
        foreach ($PostDetail->Select(-1, -1, "Submit", "DESC", "WHERE `Type` = 'KWRD' AND `RefrenceId`='" . $Id . "'") as $row) {
            $_GET['masterid'] = $row['MasterID'];
            $_GET["type"] = 'KWRD';
            
            echo '<div>';
            /* TODO: Delete keyword helper here */
            echo '  <a href="' . $BASEURL . 'explore/%23' . substr($row['Title'], 1) . '" rel="tag">' . $row['Title'] . '</a>';
            echo '</div>';
        }
        ?>
    </div>

  </main>

</div>
