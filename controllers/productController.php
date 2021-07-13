<?php

if($ajaxRequest){
    require_once "../models/productModel.php";
}else{
    require_once "./models/productModel.php";
}

class productController extends productModel
{
    /*--- ADD PRODUCT CONTROLLER ---*/
    public function add_product_controller()
    {
        $code = mainModel::clean_input($_POST['product_code_reg']);
        $name = mainModel::clean_input($_POST['product_name_reg']);
        $stock = mainModel::clean_input($_POST['product_stock_reg']);
        $status = mainModel::clean_input($_POST['product_status_reg']);
        $detail = mainModel::clean_input($_POST['product_detail_reg']);

        /*- Checking for empty fields -*/
        if($code == "" || $name == "" || $stock == "" || $status == ""){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Some input fields are empty",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- Checking for data integrity -*/
        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $code)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Code number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The product's Name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9]{1,9}", $stock)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The stock input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($detail != ""){
            if(mainModel::verify_input_data("[a-zA-Z0-9- ]{1,45}", $detail)){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The Detail input is not valid",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if($status != "Available" && $status != "Unavailable"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Detail input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- Is the product already registered? -*/
        $check_product = mainModel::execute_simple_queries("SELECT item_id FROM item WHERE item_codigo='$code'");
        if($check_product->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This Product is already registered",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_name = mainModel::execute_simple_queries("SELECT item_nombre FROM item WHERE item_nombre='$name'");
        if($check_name->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This Product is already registered",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data_product_reg = [
            "Code" => $code,
            "Name" => $name,
            "Stock" => $stock,
            "Status" => $status,
            "Detail" => $detail
        ];

        $add_product = productModel::add_product_model($data_product_reg);

        if($add_product->rowCount() == 1){
            $alert = [
                "Alert" => "clean",
                "Title" => "Great News",
                "Text" => "This Product successfully registered",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register this product",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }




}