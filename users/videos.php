<?php
include_once "../config/config.php";
session_start();

$user_logged_in = false;
if(isset($_SESSION['user'])) {
    $user_logged_in = true;
}

$target_dir = "../uploads/";

// connect to database
//$db = mysqli_connect('localhost', 'root', '', 'trajche');
$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE_NAME);

$query = "CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);

$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

// Count # of uploaded files in array
$total = count($_FILES['file']['name']);
//var_dump($total);
//var_dump($_FILES);
?>  
<html>
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
    <link rel="stylesheet" href="../css/style.css">
    <!--[if lt IE 9]>
    <script src='//html5shiv.googlecode.com/svn/trunk/html5.js'></script>


    <![endif]-->


    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">

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
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if($user_logged_in == true) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="upload.php">Upload video</a>
                    </li>
                <?php } ?>

                <?php
                if($user_logged_in == false) {
                    header('location: ../index.php');
                } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="users/logout.php">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <form method="post" enctype="multipart/form-data" action="videos_post_content.php" style="margin-top: 120px;">

<?php
// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {
    if($_FILES['file']['size']<=0){
        continue;
    }
    //Get the temp file path
    $tmpFilePath = $_FILES['file']['tmp_name'][$i];

    //Make sure we have a file path
    if ($tmpFilePath != ""){
        //Setup our new file path
        $fname_base = substr($_FILES['file']['name'][$i], 0, strrpos($_FILES['file']['name'][$i], "."));
        $fname_ext = substr($_FILES['file']['name'][$i], strrpos($_FILES['file']['name'][$i], "."));
        //$newFilePath = $target_dir . $_FILES['file']['name'][$i] . strtotime("now");
        $newFilePath = $target_dir . $fname_base . "_" . strtotime("now") . $fname_ext;
        //var_dump($newFilePath);

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            $query = "INSERT INTO videos (userid, filename) 
					  VALUES('$userid', '$newFilePath')";
            mysqli_query($db, $query);

            $query = "SELECT id FROM videos
					  WHERE filename='$newFilePath'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                $id = mysqli_fetch_assoc($results);
                $id = $id['id'];
                echo '<input id="input-videoid-' . $i . '" type="hidden" name="input-videoid-' . $i . '" value="' . $id . '">';
            }
        }
        ?>
        <label for="<?= "input-title-$i" ?>">Title for "<?= $_FILES['file']['name'][$i] ?>"</label>
        <?php
        echo '<input class="form-group" id="input-title-' . $i . '" type="text" name="input-title-' . $i . '" placeholder="Title" 
            required="" style="width: 100%; border: double; background-position: -5000px;">';
        ?>
        <label for="<?= "input-thumbnail-$i" ?>">Image (thumbnail) for "<?= $_FILES['file']['name'][$i] ?>"</label>
        <?php
        echo '<input type="file" id="input-thumbnail-' . $i . '" placeholder="Select file" name="input-thumbnail-' . $i . '" required="">';
        ?>
        <br>
        <label for="<?= "input-pdf-$i" ?>">PDF (PDF file) for "<?= $_FILES['file']['name'][$i] ?>"</label>
        <?php
        echo '<input type="file" id="input-pdf-' . $i . '" placeholder="Select file" name="input-pdf-' . $i . '" required="">';
        ?>
        <br>
        <label for="<?= "input-title-$i" ?>">Description for "<?= $_FILES['file']['name'][$i] ?>"</label>
        <?php
        echo '<textarea id="input-description-' . $i . '" type="text" name="input-description-' . $i . '" placeholder="Description" class="form-control textarea-description summernote" required=""></textarea>';
        ?>
        <div class="clear"> </div>
        <div class="clear"> </div>
        <?php
    }
}
?>
        <div class="clear"> </div>
        <input id="input-submit" type="submit" value="Finish upload">
    </form>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>

    <script>
        $('.summernote').summernote({
            placeholder: 'Description',
            focus: true,
            disableDragAndDrop: true
        });
        $('.note-toolbar').attr('hidden', true);
        $('.note-status-output').attr('hidden', true);

    </script>
    </body>
</html>

<?php
//header('location: ../index.php');
?>