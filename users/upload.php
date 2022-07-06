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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/heroic-features.css" rel="stylesheet">
    <title>Video website</title>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <link href='//fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?v=3">
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
                        <a class="nav-link" href="upload.php">Upload video</a>
                    </li>
                <?php } ?>

                <?php if($user_logged_in == false) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php?initial=login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php?initial=register">Register</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>


<div class="container">

    <div class="page-header">
        <h1>Upload your video</h1>
    </div>
    <!-- Bootstrap Upload Control - START -->
    <div class="container">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form method="post" enctype="multipart/form-data" action="videos.php">
                <input type="file" id="files" name="file[]" multiple="multiple" />
                <p style="text-align: right; margin-top: 20px;">
                    <input type="submit" value="Upload Files" class="btn btn-lg btn-primary" />
                </p>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<!-- you need to include the ShieldUI CSS and JS assets in order for the Upload widget to work -->
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<script type="text/javascript">
    jQuery(function ($) {
        $("#files").shieldUpload();
    });
</script>
<!-- Bootstrap Upload Control - END -->


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


