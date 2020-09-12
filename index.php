<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="css/heroic-features.css" rel="stylesheet">
    <title>Video website</title>
    <script src="js/jquery-3.5.1.min.js"></script>
    <link href='//fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css">
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>

  <?php
    session_start();

    $user_logged_in = false;
    if(isset($_SESSION['user'])) {
        $user_logged_in = true;
    }
  ?>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
          <a class="navbar-brand" href="index.php">Computer Fixer</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item active">
                      <a class="nav-link" href="#">Home
                          <span class="sr-only">(current)</span>
                      </a>
                  </li>
                  <?php if($user_logged_in == true) { ?>
                  <li class="nav-item">
                      <a class="nav-link" href="users/upload.php">Upload video</a>
                  </li>
                  <?php } ?>

                  <?php if($user_logged_in == false) { ?>
                  <li class="nav-item">
                      <a class="nav-link" href="users/users.php?initial=login">Login</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="users/users.php?initial=register">Register</a>
                  </li>
                  <?php } else { ?>
                      <li class="nav-item">
                          <a class="nav-link" href="users/logout.php">Logout</a>
                      </li>
                  <?php } ?>
              </ul>
          </div>
      </div>
  </nav>

  <div class="container">
    <section class="second clearfix">
      <header>
        <h1>Browse Videos</h1>
      </header>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/zH3ZohGnjcg"><img class="videoThumb" src="//i1.ytimg.com/vi/zH3ZohGnjcg/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Kumru Ballad</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//player.vimeo.com/video/26890275"><img class="videoThumb" src="//secure-b.vimeocdn.com/ts/178/010/178010767_295.jpg"></a>
        </figure>
        <h2 class="videoTitle">Kumru Orchestral</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/paG__3FBLzI"><img class="videoThumb" src="//i1.ytimg.com/vi/paG__3FBLzI/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Mesopotamia</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/OF9fneQ50Us"><img class="videoThumb" src="//i1.ytimg.com/vi/OF9fneQ50Us/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Kreutzer</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/1swsXJuclGM"><img class="videoThumb" src="//i1.ytimg.com/vi/1swsXJuclGM/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Bodrum</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/WQ3Gf9PLUO8"><img class="videoThumb" src="//i1.ytimg.com/vi/WQ3Gf9PLUO8/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Mesopotamia</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//player.vimeo.com/video/7533229"><img class="videoThumb" src="//secure-b.vimeocdn.com/ts/326/392/32639200_295.jpg"></a>
        </figure>
        <h2 class="videoTitle">Symhpony in Red</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/bYy1yKqspYs"><img class="videoThumb" src="//i1.ytimg.com/vi/bYy1yKqspYs/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Paganini Jazz</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/Vx3GkAzwVWM"><img class="videoThumb" src="//i1.ytimg.com/vi/Vx3GkAzwVWM/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Say Plays Say</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/r2jkR_rUaMY"><img class="videoThumb" src="//i1.ytimg.com/vi/r2jkR_rUaMY/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Say in Switzerland</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/rw7bkVPtYmY"><img class="videoThumb" src="//i1.ytimg.com/vi/rw7bkVPtYmY/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Serenad Bağcan</h2>
      </article>
      <article class="video">
        <figure>
        <a class="fancybox fancybox.iframe" href="//www.youtube.com/embed/njnuqtPAWDw"><img class="videoThumb" src="//i1.ytimg.com/vi/njnuqtPAWDw/mqdefault.jpg"></a>
        </figure>
        <h2 class="videoTitle">Mozart Maratonu</h2>
      </article>
    </section>

  </div>
  <!-- Footer -->
  <footer class="py-5 bg-dark">
      <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; Trajche 2020</p>
      </div>
      <a href="#" class="scroll-top">↑</a>
    </footer>
    <script src="compiled/base.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>