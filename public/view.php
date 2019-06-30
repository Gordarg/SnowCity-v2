<?php
if ($row == null)
{
    exit(header("HTTP/1.0 404 Not Found"));
}

// TODO: Show post contributers
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
        <a class="nav-link" href="<?php echo $BASEURL . 'say/' . $row['Language'] . '/' . $row['MasterID'] ?>"><?php echo Translate::Label("ویرایش", $row['Language']) ?></a>
      </nav>
    </div>
  </header>

  <main role="main" class="inner cover">
    <img class="img-fluid" src="<?php echo $BASEURL . 'download.php?id=' . $row['MasterID'] ?>" />
    <h1 class="cover-heading h1"><?php echo $row['Title'] ?></h1>
    <p class="lead">
      <a href="<?php echo $BASEURL . 'explore/@' . $row['Username'] ?>" class="btn btn-lg btn-secondary"><?php echo $row['Username'] ?></a>
      <span><?php echo $row['Submit'] ?></span>
      <!-- <a class="attachment" href="download.php?id=' . $Id . '">' . $functionalitiesInstance->label("دانلود پیوست") . '</a>' -->
    </p>
    <div id="keywords">
    <?php
    foreach
    ((new Post())->
        Select(-1, -1, 'Id', 'DESC',
        "WHERE `TYPE` = 'KWRD' AND `Language`='" . $Language .
        "' AND `RefrenceID`='" . $row['MasterID'] . "'")
    as $keyword)
    {
        echo '<a class="btn btn-sm btn-link text-light bg-dark" href="' . $BASEURL . 'explore?Q=%23' . $keyword['Title'] . '">' . $keyword['Title'] . '</a>';
    }
    ?>
    </div>
    <article>
    <?php echo $Parsedown->text($row['Body']) ?>   
    </article>
    <div id="comments">
    </div>
  </main>
</div>
