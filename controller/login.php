<?php
// Ex1
// He cambiado los dos de controlador de require_once por include_once
// require_once '../controller/input-common.php';
// require_once '../controller/session.php';
require_once '../model/pdo-users.php';
include_once '../controller/input-common.php';
include_once '../controller/session.php';


$errors = [];
$email;
$password;

session_start();
$userId = getSessionUserId();
if ($userId != 0) {
    redirectHome();
    return;
}

if (isset($_POST['submit'])) {
    onSubmit();
}
// Ex1
// He cambiado los dos de controlador de require_once por include_once
// require_once '../view/login.view.php';
include_once '../view/login.view.php';

function onSubmit()
{
    global $errors, $email, $password;

    $email = $_POST['email'];
    $password = $_POST['password'];
    $keepSession = isset($_POST['keep-session']);


    checkUserInput($email, $password);

    if (empty($errors))
        login($email, $keepSession);

    if (isset($_SESSION["loginTries"]))
        $_SESSION["loginTries"]++;
        else $_SESSION["loginTries"] = 1;
}

/**
 * Comprova l'input de l'usuari i si n'hi ha errors, els afegeix a l'array global d'errors
 *
 * @param string $email email de l'usuari
 * @param string $password password
 * 
 */
function checkUserInput($email, $password)
{
    global $errors;

    checkEmail($email, false);
    if (empty($password))
        $errors['password'] = "Password can't be empty.";

    if (!empty($errors))
        return;

    if (!userExistsByEmail($email)) {
        $errors['email'] = "This user email doesn't exist.";
        return;
    }

    // $hashedPassword = password_hash($password1, PASSWORD_DEFAULT); 
    // insertNewUser($email, $nickname, $hashedPassword);
    // startSession($email, true);
    // redirectHome();
    $md5Hash = md5($password);
    $md5HashDB = getUserHash($email);

    if ($md5Hash != $md5HashDB) {
        $errors['password'] = "Wrong password.";
        return;
    }
}

// }
// $hashedPasswordDB = getUserHash($email);
// $isPasswordCorrect = password_verify($password, $hashedPasswordDB);

// if (!$isPasswordCorrect) {
//     $errors['password'] = "Wrong password.";
//     return;
// }
// }
/**
 * Inicia sessió a l'usuari i el redirigeix a l'inici
 *
 * @param string $email email de l'usuari
 * 
 */
//Ex5
function login($email, $keepSession)
{
    $administrador = false;
    if (isset($_SESSION["loginTries"]))
        unset($_SESSION["loginTries"]);

    startSession($email, $keepSession);
    if(getUserAdmin($email) == 1){
        $administrador = true;
        header("Location: ./index_admin.php");
            exit();
    }
    redirectHome();
}