<?php
//Ex1
// require_once '../controller/session.php';
require_once '../model/pdo-users.php';
include_once '../controller/session.php';

    $userId = getSessionUserId();
    
    $anonUser = $userId == 0;

    if (!$anonUser) {        
        $nickname = getUserNicknameById($userId);
    } else $changePasswordVisibility = '';
    
    $file = pathinfo($_SERVER['PHP_SELF'])['filename'];
    
    $homeActive = $file == "index" ? "active" : "";
    $loginActive = $file== "login" ? "active" : "";
    $signupActive = $file == "sign-up" ? "active" : "";
    $createActive = $file == "edit" ? "active" : "";
    $passwordActive = $file == "change-password" ? "active" : "";    
//EX1
// require_once '../view/navbar.view.php';

    include_once '../view/navbar.view.php';
