<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['product_code_reg']) || isset($_POST['product_id_del']) || isset($_POST['product_id_up'])){

    /*--- New Instance to the controller ---*/
    require_once "../controllers/productController.php";
    $ins_product = new productController();

    /*--- ADD PRODUCT CONTROLLER ---*/
    if(isset($_POST['product_code_reg'])){
        echo $ins_product->add_product_controller();
    }

    /*--- DELETE PRODUCT CONTROLLER ---*/
    if(isset($_POST['product_id_del'])){
        echo $ins_product->delete_product_controller();
    }

    /*--- UPDATE PRODUCT CONTROLLER ---*/
    if(isset($_POST['product_id_up'])){
        echo $ins_product->update_product_controller();
    }

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}

