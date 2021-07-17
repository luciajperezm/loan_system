<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['search_customer']) || isset($_POST['id_add_customer']) || isset($_POST['id_delete_customer']) || isset
    ($_POST['search_product']) || isset($_POST['id_add_product'])){

    /*--- New instance to the controller ---*/
    require_once "../controllers/loanController.php";
    $ins_loan = new loanController();

    /*--- SEARCH CUSTOMER IN LOAN ---*/
    if(isset($_POST['search_customer'])){
        echo $ins_loan->search_customer_loan_controller();
    }

    /*--- ADD CUSTOMER IN LOAN ---*/
    if(isset($_POST['id_add_customer'])){
        echo $ins_loan->add_customer_loan_controller();
    }

    /*--- DELETE CUSTOMER IN LOAN ---*/
    if(isset($_POST['id_delete_customer'])){
        echo $ins_loan->delete_customer_loan_controller();
    }

    /*--- SEARCH PRODUCT IN LOAN ---*/
    if(isset($_POST['search_product'])){
        echo $ins_loan->search_product_loan_controller();
    }

    /*--- ADD PRODUCT IN LOAN ---*/
    if(isset($_POST['id_add_product'])){
        echo $ins_loan->add_product_loan_controller();
    }

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}
