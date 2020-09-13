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

$query = "CREATE TABLE IF NOT EXISTS `videocomments` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query($db, $query);

$user_logged_in = false;
if(isset($_SESSION['user'])) {
    $user_logged_in = true;
    $user = $_SESSION['user'];
    $userid = $_SESSION['userid'];
}

if(isset($_POST['videoid']) && isset($_POST['userid']) && isset($_POST['comment'])) {
    $videoid = $_POST['videoid'];
    $userid = $_POST['userid'];
    $comment = $_POST['comment'];
    $query = "INSERT INTO videocomments (videoid, userid, comment) 
					  VALUES('$videoid', '$userid', '$comment')";
    mysqli_query($db, $query);

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
}

?>