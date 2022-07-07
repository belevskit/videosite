<?php
include_once "config/config.php";
session_start();

$user_logged_in = false;

if(isset($_SESSION['user'])) {
    $user_logged_in = true;
}

$target_dir = "uploads/";

$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE_NAME);


$query = "CREATE TABLE IF NOT EXISTS `videodetails` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
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

$id = $_POST['id'];
$title = $_POST['title'];
$descript = $_POST['descript'];

$tmpFilePath = $_FILES['thumbnail']['tmp_name'];

if ($tmpFilePath != "") {
    $fname_base = substr($_FILES['thumbnail']['name'], 0, strrpos($_FILES['thumbnail']['name'], "."));
    $fname_ext = substr($_FILES['thumbnail']['name'], strrpos($_FILES['thumbnail']['name'], "."));
    $newFilePath = $target_dir . $fname_base . "_" . strtotime("now") . $fname_ext;

    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
        $newFilePath = '../' . $newFilePath;
        $query = "UPDATE videodetails SET title='$title', thumbnail='$newFilePath', description='$descript'
              WHERE videoid='$id'";
        mysqli_query($db, $query);
    }
}
else {
    $query = "UPDATE videodetails SET title='$title', description='$descript'
              WHERE videoid='$id'";
    mysqli_query($db, $query);
}
$tmpPdfFilePath = $_FILES['pdf']['tmp_name'];

if ($tmpPdfFilePath != "") {
    $fname_base = substr($_FILES['pdf']['name'], 0, strrpos($_FILES['pdf']['name'], "."));
    $fname_ext = substr($_FILES['thumbnail']['name'], strrpos($_FILES['thumbnail']['name'], "."));
    $newFilePath = $target_dir . $fname_base . "_" . strtotime("now") . $fname_ext;

    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
        $newFilePath = '../' . $newFilePath;
        $query = "UPDATE videodetails SET title='$title', thumbnail='$newFilePath', description='$descript'
              WHERE videoid='$id'";
        mysqli_query($db, $query);
    }
}
else {
    $query = "UPDATE videodetails SET title='$title', description='$descript'
              WHERE videoid='$id'";
    mysqli_query($db, $query);
}

header('location: index.php');
?>