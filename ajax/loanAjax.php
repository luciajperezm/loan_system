<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['search_customer']) || isset($_POST['id_add_customer']) || isset($_POST['id_delete_customer']) || isset
    ($_POST['search_product']) || isset($_POST['id_add_product']) || isset($_POST['id_delete_product']) || isset
    ($_POST['loan_date_init_reg']) || isset($_POST['loan_code_del']) || isset($_POST['payment_code_reg'])){

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

    /*--- DELETE PRODUCT IN LOAN ---*/
    if(isset($_POST['id_delete_product'])){
        echo $ins_loan->delete_product_loan_controller();
    }

    /*--- ADD LOAN ---*/
    if(isset($_POST['loan_date_init_reg'])){
        echo $ins_loan->add_loan_controller();
    }

    /*--- DELETE LOAN ---*/
    if(isset($_POST['loan_code_del'])){
        echo $ins_loan->delete_loan_controller();
    }

    /*--- ADD PAYMENT ---*/
    if(isset($_POST['payment_code_reg'])){
        echo $ins_loan->add_payment_controller();
    }

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}
