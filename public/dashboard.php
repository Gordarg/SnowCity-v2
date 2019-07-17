<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand" href="#">
    <img src="https://gordarg.github.io/brand/MonoChrome.svg" width="30" height="30" class="d-inline-block align-top" alt="<?php echo Translate::Label(Config::TITLE) ?>">
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="dropdown-item" href="<?php echo $BASEURL . 'dashboard' ?>"><?php echo Translate::Label('داشبورد') ?><span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo Translate::Label(Config::NAME) ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('humanbehaviour')"><?php echo Translate::Label('رفتار انسانی') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('ticket')"><?php echo Translate::Label('برگه') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="loadpost()"><?php echo Translate::Label('پست') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('archive')"><?php echo Translate::Label('آرشیو') ?> </a>
          <a class="dropdown-item" style="cursor:pointer" onclick="loadform()"><?php echo Translate::Label('فرم‌ساز') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('collection')"><?php echo Translate::Label('کلکسیون') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('box')"><?php echo Translate::Label('جعبه') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('profile', $.cookie('USERNAME'))"><?php echo Translate::Label('پروفایل') ?></a>

          <div class="dropdown-divider"></div>
          <h6 class="px-3 mb-1 text-muted"><span><?php echo Translate::Label('ادمین') ?></span></h6>

          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('people')"><?php echo Translate::Label('مردم') ?></a>
          <a class="dropdown-item" style="cursor:pointer" onclick="Hi.load('email')"><?php echo Translate::Label('پست الکترونیک') ?></a>

        </div>
      </li>
      
      <li class="nav-item">
        <a class="dropdown-item" href="<?php echo $BASEURL . 'log/out' ?>"><?php echo Translate::Label('خروج') ?></a>
      </li>

    </ul>
    <form class="form-inline my-2 my-lg-0" action="<?php echo $BASEURL . 'explore' ?>">
      <input name="Q" class="form-control mr-sm-2" type="search" placeholder="<?php echo Translate::Label('جستجو') ?>" aria-label="<?php echo Translate::Label('جستجو') ?>">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php echo Translate::Label('کاوش') ?>.</button>
    </form>
  </div>
</nav>
<main role="main" class="m-4">
  <div class="content m-4 px-4">
  </div>
</main>