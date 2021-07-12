<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['token']) && isset($_POST['username'])){

    /*--- New instance to the controller ---*/
    require_once "../controllers/loginController.php";
    $ins_login = new loginController();
    echo $ins_login->logout_controller();
}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}
