<div class="container">
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a class="text-muted" href="<?php echo $BASEURL ?>"><?php echo $Translate::Label('خانه'); ?></a>
      </div>
      <div class="col-4 text-center">
        <a class="blog-header-logo text-dark" href="#"><?php echo $Translate::Label(Config::TITLE); ?></a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        <a class="text-muted" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3" focusable="false" role="img"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
        </a>
        <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>
      </div>
    </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <a class="p-2 text-muted" href="#">World</a>
      <a class="p-2 text-muted" href="#">U.S.</a>
      <a class="p-2 text-muted" href="#">Technology</a>
      <a class="p-2 text-muted" href="#">Design</a>
      <a class="p-2 text-muted" href="#">Culture</a>
      <a class="p-2 text-muted" href="#">Business</a>
      <a class="p-2 text-muted" href="#">Politics</a>
      <a class="p-2 text-muted" href="#">Opinion</a>
      <a class="p-2 text-muted" href="#">Science</a>
      <a class="p-2 text-muted" href="#">Health</a>
      <a class="p-2 text-muted" href="#">Style</a>
      <a class="p-2 text-muted" href="#">Travel</a>
    </nav>
  </div>

  <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
    <?php
    $rows = $PostDetail-> Select(-1, 1, "Submit", "DESC", "WHERE `Level` = '3' AND `LANGUAGE`='" . $CURRENTLANGUAGE  . "'");
    foreach ($rows as $row) {
      echo '
      <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">' . $row['Title'] . '</h1>
      <p class="lead my-3">' . Text::GenerateAbstractForPost($Parsedown->text($row['Body']), 500) . '</p>
      <p class="lead mb-0"><a href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '" class="text-white font-weight-bold">' . $Translate::Label('ادامه مطلب') . '</a></p>
      </div>
      ';
    }
    ?>
  </div>

  <div class="row mb-2">
    <?php
    $rows = $PostDetail-> Select(-1, 2, "Submit", "DESC", "WHERE `Level` = '2' AND `LANGUAGE`='" . $CURRENTLANGUAGE  . "'");
    foreach ($rows as $row) {
      echo '
        <div class="col-md-6">
        <div class="card flex-md-row mb-4 shadow-sm h-md-250">
          <div class="card-body d-flex flex-column align-items-start">
            <!-- <strong class="d-inline-block mb-2 text-primary">Category</strong> -->
            <h3 class="mb-0">
              <a class="text-dark" href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '">' . $row['Title'] . '</a>
            </h3>
            <div class="mb-1 text-muted">' . $row['Submit'] . '</div>
            <p class="card-text mb-auto">' . Text::GenerateAbstractForPost($row['Body'], 300) . '</p>
            <a href="#">' . $Translate::Label('ادامه مطلب') . '</a>
          </div>
          <img alt="' . $row['Title'] . '" style="object-fit:cover;" class="bd-placeholder-img card-img-right flex-auto d-none d-lg-block" width="200" height="250" src="' . $BASEURL . 'download.php?id=' . $row['MasterID'] . '"/>
        </div>
      </div>
      ';
    }
    ?>
  </div>
</div>

<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
      <!-- <h3 class="pb-3 mb-4 font-italic border-bottom">
        From the Firehose
      </h3> -->

      <?php
      $rows = $PostDetail->Select(-1, 3, "Submit", "DESC", "WHERE `Level` = '1' AND `LANGUAGE`='" . $CURRENTLANGUAGE  . "'");
      foreach ($rows as $row) {
        echo '
        <div class="blog-post">
        <h2 class="blog-post-title">Sample blog post</h2>
        <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>
        ' . $Parsedown->text($row['Body']) . '
        </div>
        ';
      }
      ?>

      <!-- <nav class="blog-pagination">
        <a class="btn btn-outline-primary" href="#">Older</a>
        <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
      </nav> -->

    </div>

    <aside class="col-md-4 blog-sidebar">
      <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic"><?php echo Translate::Label('درباره ما') ?></h4>
        <p class="mb-0"> <?php echo Translate::Label(Config::TITLE) ?> <em> <?php echo Translate::Label(Config::NAME) ?> </em> <?php echo Config::META_DESCRIPTION ?> </p>
      </div>

      <div class="p-3">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
          <li><a href="#">March 2014</a></li>
          <li><a href="#">February 2014</a></li>
          <li><a href="#">January 2014</a></li>
          <li><a href="#">December 2013</a></li>
          <li><a href="#">November 2013</a></li>
          <li><a href="#">October 2013</a></li>
          <li><a href="#">September 2013</a></li>
          <li><a href="#">August 2013</a></li>
          <li><a href="#">July 2013</a></li>
          <li><a href="#">June 2013</a></li>
          <li><a href="#">May 2013</a></li>
          <li><a href="#">April 2013</a></li>
        </ol>
      </div>

      <div class="p-3">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
          <li><a href="#">GitHub</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Facebook</a></li>
        </ol>
      </div>
    </aside>

  </div>

</main>