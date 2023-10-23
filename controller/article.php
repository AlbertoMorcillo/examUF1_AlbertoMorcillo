<?php

// Ex1
// He cambiado los dos de controlador de require_once por include_once
// require_once '../controller/input-common.php';
// require_once '../controller/session.php';

require_once '../model/pdo-articles.php';
include_once '../controller/input-common.php';
include_once '../controller/session.php';

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
} else {
    header("Location: index.php");
}

session_start();
$userId = getSessionUserId();

$latestPosts = getLatestPosts(5);

$article = getPost($articleId); 

if (empty($article)) {
    header("Location: index.php");
} else {  
    $ytId =  getYoutubeVideoId($article['youtube_link']);
    $imagePath = $article['image_path'];
    $filetime = filemtime("../uploads/$imagePath");
    require_once '../view/article.view.php';
}