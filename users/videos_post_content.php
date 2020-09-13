<?php
include_once "../config/config.php";
session_start();

$user_logged_in = false;
if(isset($_SESSION['user'])) {
    $user_logged_in = true;
}

$target_dir = "../uploads/";

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


$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

// Loop through each file
$total = count($_FILES);
for( $i=0 ; $i < $total ; $i++ ) {
    if($_FILES["input-thumbnail-$i"]['size']<=0){
        continue;
    }
    //Get the temp file path
    $tmpFilePath = $_FILES["input-thumbnail-$i"]['tmp_name'];

    //Make sure we have a file path
    if ($tmpFilePath != ""){
        //Setup our new file path
        $fname_base = substr($_FILES["input-thumbnail-$i"]['name'], 0, strrpos($_FILES["input-thumbnail-$i"]['name'], "."));
        $fname_ext = substr($_FILES["input-thumbnail-$i"]['name'], strrpos($_FILES["input-thumbnail-$i"]['name'], "."));
        $newFilePath = $target_dir . $fname_base . "_" . strtotime("now") . $fname_ext;

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            $videoid = $_POST["input-videoid-$i"];
            $videotitle = $_POST["input-title-$i"];
            $query = "INSERT INTO videodetails (videoid, title, thumbnail) 
					  VALUES('$videoid', '$videotitle', '$newFilePath')";
            mysqli_query($db, $query);
            $query = "INSERT INTO videoratings (videoid, likes, dislikes) 
					  VALUES('$videoid', 0, 0)";
            mysqli_query($db, $query);
        }
    }
}
header('location: ../index.php');
?>