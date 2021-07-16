<?php

if($ajaxRequest){
    require_once "../models/loanModel.php";
}else{
    require_once "./models/loanModel.php";
}

class loanController extends loanModel
{

    /*--- SEARCH CLIENT FOR LOAN CONTROLLER ---*/
    public function search_customer_loan_controller()
    {
        echo 'hi';
    }
}


