<?php
include_once "../config/config.php";
session_start();

$user_logged_in = false;
if(isset($_SESSION['user'])) {
    $user_logged_in = true;
}

$target_dir = "../uploads/";
$target_pdf_dir = "uploads/";
$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE_NAME);


$query = "CREATE TABLE IF NOT EXISTS `videodetails` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `pdf` varchar(255) NOT NULL,
  `description` blob(100000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);


$query = "CREATE TABLE IF NOT EXISTS `videoratings` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);


$query = "CREATE TABLE IF NOT EXISTS `videocomments` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` blob(100000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);


$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

// Loop through each file
$total = count($_FILES);
for( $i=0 ; $i < $total ; $i++ ) {
    if($_FILES["input-thumbnail-$i"]['size']<=0 || $_FILES["input-pdf-$i"]['size'] <= 0){
        continue;
    }
    //Get the temp file path
    $tmpFilePath = $_FILES["input-thumbnail-$i"]['tmp_name'];
    $tmpPdfFilePath = $_FILES["input-pdf-$i"]['tmp_name'];
    //Make sure we have a file path
    if ($tmpFilePath != "" && $tmpPdfFilePath != ""){
        //Setup our new file path
        $fname_base = substr($_FILES["input-thumbnail-$i"]['name'], 0, strrpos($_FILES["input-thumbnail-$i"]['name'], "."));
        $fname_ext = substr($_FILES["input-thumbnail-$i"]['name'], strrpos($_FILES["input-thumbnail-$i"]['name'], "."));
        $newFilePath = $target_dir . $fname_base . "_" . strtotime("now") . $fname_ext;

        $fname_base_pdf = substr($_FILES["input-pdf-$i"]['name'], 0, strrpos($_FILES["input-pdf-$i"]['name'], "."));
        $fname_ext_pdf = substr($_FILES["input-pdf-$i"]['name'], strrpos($_FILES["input-pdf-$i"]['name'], "."));
        $newPdfFilePath = $target_dir . $fname_base_pdf . "_" . strtotime("now") . $fname_ext_pdf;
        $newPdfFileURL = $target_pdf_dir . $fname_base_pdf . "_" . strtotime("now") . $fname_ext_pdf;

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath) && move_uploaded_file($tmpPdfFilePath,  $newPdfFilePath)) {
            $videoid = $_POST["input-videoid-$i"];
            $videotitle = $_POST["input-title-$i"];
            $descript = $_POST["hiddenText"];

            $query = "INSERT INTO videodetails (videoid, title, thumbnail, pdf, description) 
					  VALUES('$videoid', '$videotitle', '$newFilePath', '$newPdfFileURL' ,'$descript')";
            mysqli_query($db, $query);
            $query = "INSERT INTO videoratings (videoid, likes, dislikes) 
					  VALUES('$videoid', 0, 0)";
            mysqli_query($db, $query);
        }
    }
}
header('location: ../index.php');
?>