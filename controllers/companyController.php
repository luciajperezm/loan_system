<?php

if($ajaxRequest){
    require_once "../models/companyModel.php";
}else{
    require_once "./models/companyModel.php";
}

class companyController extends companyModel
{

    /*--- COMPANY DATA CONTROLLER ---*/
    public function company_data_controller()
    {
        return companyModel::company_data_model();
    }

    /*--- ADD COMPANY CONTROLLER ---*/
    public function add_company_controller()
    {
        $name = mainModel::clean_input($_POST['company_name_reg']);
        $email = mainModel::clean_input($_POST['company_email_reg']);
        $phone = mainModel::clean_input($_POST['company_phone_reg']);
        $address = mainModel::clean_input($_POST['company_address_reg']);

        if($name == "" || $email == "" || $phone == "" || $address == ""){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Some input fields are empty",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Company's Name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9()+]{8,20}", $phone)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Phone number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $address)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Address is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $check_email = mainModel::execute_simple_queries("SELECT empresa_email FROM empresa WHERE empresa_email='$email'");
            if($check_email->rowCount()>0){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The Email is already registered",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This Email is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data_company_reg = [
          "Name" => $name,
          "Email" => $email,
          "Phone" => $phone,
          "Address" => $address
        ];

        $add_company = companyModel::add_company_model($data_company_reg);

        if($add_company->rowCount() == 1){
            $alert = [
                "Alert" => "reload",
                "Title" => "Great News!",
                "Text" => "The company was registered successfully",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register the company",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);

    }
    
    /*--- UPDATE COMPANY CONTROLLER ---*/
    public function update_company_controller()
    {
        $name = mainModel::clean_input($_POST['company_name_up']);
        $email = mainModel::clean_input($_POST['company_email_up']);
        $phone = mainModel::clean_input($_POST['company_phone_up']);
        $address = mainModel::clean_input($_POST['company_address_up']);

        if(mainModel::verify_input_data("[a-zA-Z0-9- ]{1,45}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The company's Name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This Email is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9()+]{8,20}", $phone)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Phone number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $address)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Address is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        session_start(['name' => 'LOAN']);
        if($_SESSION['privilege_loan'] != 1){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "You are not allowed to update this account ",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $company_data_up = [
            "Name" => $name,
            "Email" => $email,
            "Phone" => $phone,
            "Address" => $address
        ];

        if(CompanyModel::update_company_model($company_data_up)){
            $alert = [
                "Alert" => "reload",
                "Title" => "Great News",
                "Text" => "The Company was successfully updated",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't update the Company",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

}