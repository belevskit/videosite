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

if(isset($_POST['videoid']) && isset($_POST['rating'])) {
    $videoid = $_POST['videoid'];
    $rating = $_POST['rating'];

    $query = "SELECT id, likes, dislikes FROM videoratings WHERE videoid='$videoid'";
    $results = mysqli_query($db, $query);
    $res = mysqli_fetch_assoc($results);
    $id = $res['id'];

    if($rating == 'like') {
        $likes = $res['likes'];
        $likes++;
        $query = "UPDATE videoratings SET likes='$likes' WHERE id='$id'";
    }
    else {
        $dislikes = $res['dislikes'];
        $dislikes++;
        $query = "UPDATE videoratings SET dislikes='$dislikes' WHERE id='$id'";
    }
    mysqli_query($db, $query);

    $query = "SELECT likes, dislikes FROM videoratings WHERE videoid='$videoid'";
    $results = mysqli_query($db, $query);

    $ratings = mysqli_fetch_assoc($results);

    echo "<p>Likes: " . $ratings['likes'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dislikes: " . $ratings['dislikes'] . "</p>";
}

?>