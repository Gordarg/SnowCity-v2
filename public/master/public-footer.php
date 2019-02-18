<footer class="blog-footer footer">
  <div class="container">
    <div class="row text-center text-xs-center text-sm-left text-md-left">
      <div class="col-xs-12 col-sm-4 col-md-8">
        <h5><?php echo $Translate->Label("یادداشت ها"); ?></h5>
        <ul class="list-unstyled quick-links">
        <?php
        $rows = $PostDetail->Select(0, 10, "Submit", "DESC", "WHERE Level = '3'");
        foreach ($rows as $row) {
            echo '<li><a href="' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '"><i class="fa fa-angle-double-right"></i>' . Text::GenerateAbstractForPost($row['Title'], 40) . '</a></li>';
        }
        ?>
        </ul>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4">
        <h5><?php echo $Translate->Label("همراهان ما"); ?></h5>
        <p class="list-unstyled quick-links">
        <?php echo Config::SPONSOR ?>
        </p>
      </div>
    </div>	
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
        <p><u><a href="<?php echo $BASEURL ?>"><?php echo Translate::Label(Config::TITLE) ?></a></u>
        * <?php echo Config::REGION ?>
        </p>
        <p class="h6">© <?php echo Translate::Label(Config::NAME) ?> - <a class="text-green ml-2" href="https://www.gordarg.com" target="_blank"><?php echo Translate::Label('گُرد') ?></a></p>
      </div>
      </hr>
    </div>	
  </div>
</footer>
<? echo $JSLINKS ?>
</html>