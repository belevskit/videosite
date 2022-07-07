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


    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">

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
                        data = JSON.parse(data);
                        $('#likes').text('Likes: ' + data['likes']);
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
                        data = JSON.parse(data);
                        $('#dislikes').text('Dislikes: ' + data['dislikes']);
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
            echo "<h1 id='video-title'>$title</h1>";
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
    <?php if($user_logged_in) { ?>
        <?php
            if(isset($_GET['pdf'])) {
                $descrip = urldecode($_GET['pdf']);
                echo "<a class='btn btn-info' href='$descrip'>Download the Pdf file</a>";
            }
        ?>
    <?php } ?>
    <div id="all-likes" class="d-flex justify-content-end">
        <div style="border: double;" id="likes">Likes: <?= $ratings['likes'] ?> </div>
        <div class="ml-lg-3" style="border: double;" id="dislikes">Dislikes: <?= $ratings['dislikes'] ?></div>
    </div>
    <?php
        if(isset($_GET['descrip'])) {
            $descrip = urldecode($_GET['descrip']);
            echo "<div><h3>Description:</h3><textarea id='video-descript' class='form-control textarea-description summernote' 
                                            readonly>$descrip</textarea></div>";
        } else {
            echo '<h3></h3>';
        }
    ?>

    <div>
        <div class="mt-lg-5">Comments</div>
        <div>
            <ol id="all-comments-list" style="border: double; width: 100%;">
                <?php
                    $query = "SELECT userid, comment FROM videocomments WHERE videoid='$videoid'";
                    $results = mysqli_query($db, $query);

                    while($comments = mysqli_fetch_assoc($results)) {
                        $userid = $comments['userid'];
                        $query2 = "SELECT username FROM users WHERE id='$userid'";
                        $results2 = mysqli_query($db, $query2);
                        $username = mysqli_fetch_assoc($results2);
                        $username = $username['username'];
                        echo "<li style='margin: 0 !important;'><strong>" . $username . '</strong> --- ' . $comments['comment'] . "</li>";
                    }
                ?>
            </ol>
        </div>
    </div>
    <?php if($user_logged_in) { ?>
        <form id="add-comment-form" method="post" action="">
            <div class="form-group">
                <label for="comment">Add comment</label>
                <input type="text" class="form-control" style="border: double; width: 100%; background-position: -50000px;" id="comment" required>
            </div>
            <button id="add-comment-button" type="submit" class="btn btn-primary">Submit comment</button>
        </form>
        <div class="mt-lg-1 ml-lg-3">
            <div class="row">
            <form id="like-form" method="post" action="">
                <button id="add-like-button" type="submit" class="btn btn-primary">Like video</button>
            </form>
            <form id="dislike-form" method="post" action="" class="ml-lg-2">
                <button id="add-dislike-button" type="submit" class="btn btn-primary">Dislike video</button>
            </form>
            </div>
        </div>
    <?php } ?>
</div>

<div class="container mt-lg-2 mb-lg-2">
    <div class="row">
        <div class="ml-lg-3"><a href="index.php" class="btn btn-lg btn-primary">Go back</a></div>
        <?php if($user_logged_in) { ?>
            <button id="btn-edit" type="button" class="btn btn-lg btn-light ml-lg-2" data-toggle="modal" data-target="#editModal">Edit</button>
            <button id="btn-delete" type="button" class="btn btn-lg btn-danger ml-lg-2" data-toggle="modal" data-target="#myModal">Delete</button>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color: black;">Are you Sure?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="color: black">
                <p>Are you sure to Delete the Video really?</p>
            </div>
            <div class="modal-footer">
                <button id="btn-real-delete" type="button" class="btn btn-lg btn-success">Delete</button>
                <button type="button" class="btn btn-lg btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" action="editvideo.php">
                <input hidden type="text" name="id" value="<?= urlencode($_GET['id'])?>" />
                <div class="modal-header">
                    <h4 class="modal-title" style="color: black;">Edit the Video Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="color: black">
                    <div>
                        <label>Video Title</label>
                        <input type="text" class="form-control mb-4" name="title" style="width: 100%; border-color: black !important; color: black"
                               id="modal-video-title" value="<?= urldecode($_GET['title'])?>" required/>
                    </div>

                    <div>
                        <label>Thumbnail</label>
                        <p class="text-left m-0" style="font-size: 16px; width: 100%;">(If you want to change the thumbnail, click the Browse button, Or, the original file is saved.)</p>
                        <input type="file" class="fileupload mb-4" name="thumbnail" style="width: 100%; border-color: black !important; color: black"
                               id="modal-video-thumbnail" value="<?= urldecode($_GET['title'])?>" />
                    </div>

                    <div>
                        <label>Pdf file</label>
                        <p class="text-left m-0" style="font-size: 16px; width: 100%;">(If you want to change the Pdf file, click the Browse button, Or, the original file is saved.)</p>
                        <input type="file" class="fileupload mb-4" name="pdf" style="width: 100%; border-color: black !important; color: black"
                               id="modal-video-pdf" value="<?= urldecode($_GET['title'])?>" />
                    </div>
                    <div>
                        <label>Description</label>
                        <textarea type="text" id="modal-video-description" name="descript" class="form-control summernote" style="width: 100%;
                                border-color: black!important; color: black;"><?= urldecode($_GET['descrip'])?>
                        </textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="btn-real-edit" type="submit" class="btn btn-lg btn-success">Edit</button>
                    <button type="button" class="btn btn-lg btn-dark" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- you need to include the ShieldUI CSS and JS assets in order for the Upload widget to work -->
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>

<script type="text/javascript">
    jQuery(function ($) {
            $("#files").shieldUpload();
        });
    $('#myModal').on('shown.bs.modal', function (e) {
        $('#btn-real-delete').click(function () {
            var videoid = <?= urldecode($_GET['id'])?>;
            $.ajax({
                type: "POST",
                url: 'deletevideo.php',
                data: {
                    'videoid': videoid
                },
                success: function (data) {
                    alert("Delete Successfully!");
                    window.location = 'index.php';
                }
            });
        });
    });
    var summer = $('.summernote');
    summer.summernote({
        height: 255,
        placeholder: 'Description',
        focus: true,
        disableDragAndDrop: true
    });

    summer.summernote('disable');
    $('.note-toolbar').attr('hidden', true);
    $('.note-status-output').attr('hidden', true);
</script>
</body>
</html>