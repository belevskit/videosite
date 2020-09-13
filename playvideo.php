<?php
include_once "config/config.php";
session_start();

$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE_NAME);


$query = "CREATE TABLE IF NOT EXISTS `videodetails` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);


$query = "CREATE TABLE IF NOT EXISTS `videoratings` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);

$user_logged_in = false;
if(isset($_SESSION['user'])) {
    $user_logged_in = true;
    $user = $_SESSION['user'];
    $userid = $_SESSION['userid'];
}
?>

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

    <script>
        $(document).ready(function () {
            $('#add-comment-button').click(function (e) {
                e.preventDefault();
                var comment = $('#comment').val();
                var userid = <?= $userid ?>;
                var videoid = <?= urldecode($_GET['id']) ?>;
                $.ajax
                ({
                    type: "POST",
                    url: "addcomment.php",
                    data: { "userid": userid, "comment": comment, "videoid": videoid },
                    success: function (data) {
                        $('#all-comments-list').html(data);
                        $('#add-comment-form')[0].reset();
                    }
                });
            });
            $('#add-like-button').click(function (e) {
                e.preventDefault();
                var rating = 'like';
                var videoid = <?= urldecode($_GET['id']) ?>;
                $.ajax
                ({
                    type: "POST",
                    url: "addratings.php",
                    data: { "rating": rating, "videoid": videoid },
                    success: function (data) {
                        $('#all-likes').html(data);
                    }
                });
            });
            $('#add-dislike-button').click(function (e) {
                e.preventDefault();
                var rating = 'dislike';
                var videoid = <?= urldecode($_GET['id']) ?>;
                $.ajax
                ({
                    type: "POST",
                    url: "addratings.php",
                    data: { "rating": rating, "videoid": videoid },
                    success: function (data) {
                        $('#all-likes').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>



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
                    <a class="nav-link" href="index.php">Home
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


<div class="container" style="margin-top: 130px;">

    <div class="page-header">
        <?php
        if(isset($_GET['title'])) {
            $title = urldecode($_GET['title']);
            echo "<h1>$title</h1>";
        } else {
            echo '<h1>Video player</h1>';
        }
        ?>
    </div>

<?php
if(isset($_GET['url'])) {
    $url = urldecode($_GET['url']);

    echo '<video src="' . $url .'" type="video/mp4" controls></video>';

}
else{
    header('location: index.php');
}
?>

</div>

<div class="container" style="margin-top: 20px;">
    <?php
        if(isset($_GET['id'])) {
            $videoid = urldecode($_GET['id']);

            $query = "SELECT likes, dislikes FROM videoratings WHERE videoid='$videoid'";
            $results = mysqli_query($db, $query);

            $ratings = mysqli_fetch_assoc($results);
        }
    ?>
    <div id="all-likes">
    <p>Likes: <?= $ratings['likes'] ?> </p>
    <p>Dislikes: <?= $ratings['dislikes'] ?> </p>
    </div>
    <p>Comments</p>
    <ol id="all-comments-list">
        <?php
            $query = "SELECT userid, comment FROM videocomments WHERE videoid='$videoid'";
            $results = mysqli_query($db, $query);

            while($comments = mysqli_fetch_assoc($results)) {
                $userid = $comments['userid'];
                $query2 = "SELECT username FROM users WHERE id='$userid'";
                $results2 = mysqli_query($db, $query2);
                $username = mysqli_fetch_assoc($results2);
                $username = $username['username'];
                echo "<li><strong>" . $username . '</strong> --- ' . $comments['comment'] . "</li>";
            }
        ?>
    </ol>
    <?php if($user_logged_in) { ?>
        <form id="add-comment-form" method="post" action="">
            <div class="form-group">
                <label for="comment">Add comment</label>
                <input type="text" class="form-control" id="comment">
            </div>
            <button id="add-comment-button" type="submit" class="btn btn-primary">Submit comment</button>
        </form>
        <form id="like-form" method="post" action="" style="margin-top: 20px;">
            <button id="add-like-button" type="submit" class="btn btn-primary">Like video</button>
        </form>
        <form id="dislike-form" method="post" action="">
            <button id="add-dislike-button" type="submit" class="btn btn-primary">Dislike video</button>
        </form>
    <?php } ?>
</div>

<div class="container" style="margin-top: 30px;">
    <p><a href="index.php">Go back</a></p>
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