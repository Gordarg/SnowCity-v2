<?php
setcookie('LANG', $PATHINFO[2], time() + (86400 * 30), '/');
?>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><?php echo Translate::Label(Config::TITLE) ?></h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="<?php echo $BASEURL ?>"><?php echo $Translate::Label('خانه'); ?></a>
  </nav>
  <a class="btn btn-outline-primary" href="<?php echo $BASEURL . 'log/in' ?>"><?php echo $Translate::Label('ورود به سیستم'); ?></a>

</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4"><?php echo Translate::Label('انتخاب زبان') ?></h1>
  <p class="lead"><?php echo Translate::Label('زبان شما فارسی است') ?></p>
</div>

<div class="container">
    <div class="card-deck mb-4 text-center">
    <?php
    foreach (Config::Languages() as $lang)
    {
        echo '
        <div class="card mb-4 shadow-sm">' .
            // <div class="card-header">
            //     <h4 class="my-0 font-weight-normal">Pro</h4>
            // </div>
            '<div class="card-body">
                <h1 class="card-title pricing-card-title">
                ' . $lang . '
                </h1> ' .
                // <ul class="list-unstyled mt-3 mb-4">
                // <li>20 users included</li>
                // <li>10 GB of storage</li>
                // <li>Priority email support</li>
                // <li>Help center access</li>
                '</ul>
                <a class="btn btn-lg btn-block btn-primary" href="'. $lang->code . '-' . $lang->region . '">' . Translate::Label('انتخاب', $lang->code . '-' . $lang->region) . '</a>
            </div>
        </div>
        ';
    }
    ?>
    </div>
</div>