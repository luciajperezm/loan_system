<?php

$ajaxRequest = true;
require_once "../config/APP.php";

if(isset($_POST['company_name_reg']) || isset($_POST['company_name_up'])){

    /*--- New Instance to the controller ---*/
    require_once "../controllers/companyController.php";
    $ins_company = new companyController();

    /*--- ADD COMPANY ---*/
    if(isset($_POST['company_name_reg']) && isset($_POST['company_email_reg'])){
        echo $ins_company->add_company_controller();
    }

    /*--- UPDATE COMPANY ---*/
    if(isset($_POST['company_name_up'])){
        echo $ins_company->update_company_controller();
    }

}else {
    session_start(['name' => 'LOAN']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
}
