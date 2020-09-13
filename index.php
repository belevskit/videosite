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
    include_once "config/config.php";
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
        <?php
        // connect to database
        //$db = mysqli_connect('localhost', 'root', '', 'trajche');
        $db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE_NAME);
        $query = "CREATE TABLE IF NOT EXISTS `videos` (
          `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
          `userid` int(11) NOT NULL,
          `filename` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        mysqli_query($db, $query);
        $query = "CREATE TABLE IF NOT EXISTS `videodetails` (
          `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
          `videoid` int(11) NOT NULL,
          `title` varchar(255) NOT NULL,
          `thumbnail` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        mysqli_query($db, $query);
        $query = "SELECT id, filename FROM videos";
        $results = mysqli_query($db, $query);

        while ($list = mysqli_fetch_assoc($results)) {
            $vidid = $list['id'];
            $query2 = "SELECT title, thumbnail FROM videodetails WHERE videoid='$vidid'";
            $results2 = mysqli_query($db, $query2);
            $viddetails = mysqli_fetch_assoc($results2)
            ?>
                <article class="video">
                <figure> <?php
                echo '<a class="fancybox fancybox.iframe" target="_blank" href="playvideo.php?id=' . $vidid . '&url=' . urlencode($_SERVER['REQUEST_URI'] . 'users/' . $list['filename']) . '&title=' . urlencode($viddetails['title']) .'"><img class="videoThumb" src="' . $_SERVER['REQUEST_URI'] . 'users/' . $viddetails['thumbnail'] . '"></a>';
                ?>
                </figure>
                <h2 class="videoTitle"><?= $viddetails['title'] ?></h2>
              </article>
        <?php
        }
        ?>
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