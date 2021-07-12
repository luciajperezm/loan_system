<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['customer_name_reg']) || isset($_POST['customer_id_del']) || isset($_POST['customer_id_up'])){

    /*--- New Instance to the controller ---*/
    require_once "../controllers/customerController.php";
    $ins_customer = new customerController();

    /*--- ADD CUSTOMER CONTROLLER ---*/
if(isset($_POST['customer_name_reg']) && isset($_POST['customer_lastname_reg'])){
    echo $ins_customer->add_customer_controller();
}

    /*--- DELETE CUSTOMER CONTROLLER ---*/
if(isset($_POST['customer_id_del'])){
    echo $ins_customer->delete_customer_controller();
}

    /*--- UPDATE CUSTOMER CONTROLLER ---*/
    if(isset($_POST['customer_id_up'])){
        echo $ins_customer->update_customer_controller();
    }

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}

