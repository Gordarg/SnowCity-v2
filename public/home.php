<?php
include_once BASEPATH . 'core/Bridge.php';
?>
<div class="container">
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a class="text-muted" href="<?php echo $BASEURL . 'rss' ?>"><?php echo $Translate::Label('خوراک'); ?></a>
      </div>
      <div class="col-4 text-center">
        <span class="blog-header-logo text-dark" href="#"><?php echo $Translate::Label(Config::TITLE); ?></span>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        <a class="text-muted" href="<?php echo $BASEURL . 'explore' ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3" focusable="false" role="img"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
        </a>
        <a class="btn btn-sm btn-outline-secondary" href="<?php echo $BASEURL . 'log/in' ?>"><?php echo $Translate::Label('ورود به سیستم'); ?></a>
      </div>
    </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <?php
      foreach (Config::Languages() as $lang)
          echo '<a class="p-2 text-muted" href="' . $BASEURL . 'language/' . $lang->code . '-' . $lang->region . '">' . $lang->flag . '</a>';
      
      // TODO: Customize results based on @Username;
      foreach (Bridge::Execute('categories', [['Username', null]], true) as $category)
          echo '<a class="p-2 text-muted" href="' . $BASEURL . 'explore?Q=%23' . $category['Title'] . '">' . $category['Title'] . '</a>';
      ?>
    </nav>
  </div>

  <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
    <?php
    $rows = $Post-> Select(-1, 1, "Submit", "DESC", "WHERE `Type` = 'POST' AND `Level` = '3' AND `LANGUAGE`='" . $CURRENTLANGUAGE  . "'");
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
    $rows = $Post-> Select(-1, 2, "Submit", "DESC", "WHERE `Type` = 'POST' AND `Level` = '2' AND `LANGUAGE`='" . $CURRENTLANGUAGE  . "'");
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
            <a href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '">' . $Translate::Label('ادامه مطلب') . '</a>
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
      $rows = $Post->Select(-1, 3, "Submit", "DESC", "WHERE `Type` = 'POST' AND `Level` = '1' AND `LANGUAGE`='" . $CURRENTLANGUAGE  . "'");
      foreach ($rows as $row) {
        echo '
        <div class="blog-post">
        <h2 class="blog-post-title">' . $row['Title'] . '</h2>
        <p class="blog-post-meta"><a href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '">' . $row['Submit'] . '</a> <a href="' . $BASEURL . 'explore/@' . $row['Username'] . '">' . $row['Username'] . '</a></p>
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
        <?php
        foreach (Bridge::Execute('archive', [], true) as $archive)
            echo '<li><a href="' . $BASEURL . 'explore/~' . $archive['link'] . '">' . $archive['formatted'] . '</a></li>';
        ?>
        </ol>
      </div>

      <div class="p-3">
        <h4 class="font-italic"><?= $Translate->Label("واژگان کلیدی"); ?></h4>
        <ol class="list-unstyled">
          <?php
          foreach (explode(',', Config::META_KEYWORDS) as $Keyword) {
              echo '<li><a rel="search" href="' . $BASEURL . 'explore/' . $Keyword . '"> ' . $Keyword . ' </a>' . '</li>';
          }
          ?>
        </ol>
      </div>
    </aside>

  </div>

</main>