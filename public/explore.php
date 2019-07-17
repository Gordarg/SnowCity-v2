<?php
$Q = Functionalities::IfExistsIndexInArray($PATHINFO, 2) != null ? $PATHINFO[2]
: (
   Functionalities::IfExistsIndexInArray($_GET, 'Q')
);
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <span class="navbar-brand" href="#"><?php echo Translate::Label(Config::TITLE) ?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $BASEURL ?>"><?php echo Translate::Label('خانه') ?><span class="sr-only">(<?php echo Translate::Label('فعلی') ?>)</span></a>
      </li>
    </ul>
  </div>
</nav>

<main role="main" class="container">
  <div class="jumbotron">
    <h1><?php echo Translate::Label('کاوش') ?>.</h1>
    <form class="form-inline" action="<?php echo $BASEURL ?>explore" method="GET" >
        <input class="form-control input-lg" type="text" name="Q" placeholder="<?= $Translate->Label("عبارت را وارد نمائید"); ?>" value="<?= $Q ?>" />
        <input class="btn btn-lg btn-primary" type="submit" value = "<?= $Translate->Label("جستجو"); ?>" />
    </form>
  </div>
</main>
<div class="container">
<?php
if ($Q != null)
{
    if (substr($Q, 0, 1) == "@") echo '<div class="profile"></div>';

    include_once BASEPATH . 'core/Bridge.php';
    $rows = Bridge::Execute('explore', [['Q', $Q]], true);

    if (count($rows)>=1)
    {
      foreach ($rows as $row) {
          echo '<div class="' . $row['Type'] . '">';
          switch ($row['Type'])
          {
              // TODO: UI
              case 'COMT':
                  echo '<a href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['RefrenceID'] . '">' . $row['Body']. '</a>';
                  break;
              case 'FILE':
                  echo '<a href="download.php?id=' . $row['MasterID'] . '">' . $row['Title']. '</a>';
                  break;
              case 'POST':


                  echo '<a href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '">' .
                  '<img src="' . $BASEURL . 'download.php?id=' . $row['MasterID'] . '" alt="' . $row['Title'] . '" />' .
                  '<span>' . $row['Title'] . '</span>' .
                  '<p>' . Text::GenerateAbstractForPost($Parsedown->text($row['Body']), 480)  . '</p>' .
                  '</a>';
                  break;
              case 'QUST':
                  echo '<a href="' . $BASEURL . 'view/' . CURRENTLANGUAGE . '/' . $row['MasterID'] . '">' . $row['Title']. '</a>';
                  break;
              // case 'KWRD':
              //     echo '<a href="view.php?id=' . $row['RefrenceID'] . '">' . $row['Title']. '</p>';
              //     break;
          }
          echo "</div>";
      }
    }
    else
    {
        print($Translate->Label("نتیجه یافت نشد"));
    }
}
?>
</div>