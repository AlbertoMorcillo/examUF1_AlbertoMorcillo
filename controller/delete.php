
<?php

// Ex1
// He cambiado los dos de controlador de require_once por include_once
// require_once '../controller/session.php';
include_once '../controller/session.php';
require_once '../model/pdo-articles.php';

session_start();
$userId = getSessionUserId();
if ($userId == 0) {
    header('Location: login.php');
    return;
}

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
    $_SESSION["articleId"] = $articleId;
    $articleOwnerID = getPostOwnerID($articleId);

    if ($articleOwnerID != $userId) {
        redirectHome();
        return;
    }

    deletePost($articleId);
    redirectHome();
}
?>