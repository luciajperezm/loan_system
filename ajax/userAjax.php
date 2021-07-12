<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['user_dni_reg']) || isset($_POST['user_id_del']) || isset($_POST['user_id_up'])){

    /*--- New Instance to the controller ---*/
    require_once "../controllers/userController.php";
    $ins_user = new userController();

    /*--- ADD NEW USER ---*/
    if(isset($_POST['user_dni_reg']) && isset($_POST['user_firstname_reg'])){
        echo $ins_user->add_user_controller();
    }

    /*--- DELETE USER ---*/
    if(isset($_POST['user_id_del'])){
        echo $ins_user->delete_user_controller();
    }

    /*--- UPDATE USER ---*/
    if(isset($_POST['user_id_up'])){
        echo $ins_user->update_user_controller();
    }

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}
