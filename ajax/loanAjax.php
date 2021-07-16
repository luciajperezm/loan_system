<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['search_customer'])){

    /*--- New instance to the controller ---*/
    require_once "../controllers/loanController.php";
    $ins_loan = new loanController();

    if(isset($_POST['search_customer'])){
        echo $ins_loan->search_customer_loan_controller();
    }


}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}
