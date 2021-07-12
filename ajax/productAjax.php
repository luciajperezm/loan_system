<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['']) || isset($_POST['']) || isset($_POST[''])){

    /*--- New Instance to the controller ---*/
    require_once "../controllers/productController.php";
    $ins_product = new productController();

    /*--- ADD CUSTOMER CONTROLLER ---*/
    /*if(isset($_POST['customer_name_reg']) && isset($_POST['customer_lastname_reg'])){
        echo $ins_product->add_customer_controller();
    }*/

    /*--- DELETE CUSTOMER CONTROLLER ---*/
    /*if(isset($_POST['customer_id_del'])){
        echo $ins_product->delete_customer_controller();
    }*/

    /*--- UPDATE CUSTOMER CONTROLLER ---*/
    /*if(isset($_POST['customer_id_up'])){
        echo $ins_product->update_customer_controller();
    }*/

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}

