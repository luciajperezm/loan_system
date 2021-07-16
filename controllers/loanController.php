<?php

if($ajaxRequest){
    require_once "../models/loanModel.php";
}else{
    require_once "./models/loanModel.php";
}

class loanController extends loanModel
{

    /*--- SEARCH CUSTOMER FOR LOAN CONTROLLER ---*/
    public function search_customer_loan_controller()
    {
        /* receive text */
        $customer = mainModel::clean_input($_POST['search_customer']);

        if($customer == ""){
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        The input field is empty
                    </p>
                </div>';
            exit();
        }

        /* customer in db */
        $data_customer = mainModel::execute_simple_queries("SELECT * FROM cliente WHERE cliente_dni LIKE '%$customer%' OR cliente_nombre LIKE '%$customer%' OR cliente_apellido LIKE '%$customer%' ORDER BY cliente_nombre");

        if($data_customer->rowCount() >= 1){
            $data_customer = $data_customer->fetchAll();
            $table = '<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm"><tbody>';

            foreach($data_customer as $rows){
                $table.='<tr class="text-center">
                                <td>'.$rows['cliente_dni'].' - '.$rows['cliente_nombre'].' '.$rows['cliente_apellido']
                    .'</td>
                                <td><button type="button" class="btn btn-primary" onclick="add_customer('.$rows['cliente_id'].')"><i class="fas fa-user-plus"></i></button></td></tr>';
            }

            $table.='</tbody></table></div>';
            return $table;
        }else{
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        We couldn\'t find a customer that matched with <strong>"'.$customer.'"</strong>
                    </p>
                </div>';
            exit();
        }
    }
    
    /*--- ADD CUSTOMER FOR LOAN CONTROLLER ---*/
    public function add_customer_loan_controller()
    {
        /* receiving id */
        $id = mainModel::clean_input($_POST['id_add_customer']);

        $check_customer = mainModel::execute_simple_queries("SELECT * FROM cliente WHERE cliente_id='$id'");

        if($check_customer->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This customer doesn't exist",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }else {
            $fields = $check_customer->fetch();
        }

        /*starting session */
        session_start(['name' => 'LOAN']);
        if(empty($_SESSION['data_customer'])){
            $_SESSION['data_customer'] = [
                "ID" => $fields['cliente_id'],
                "DNI" => $fields['cliente_dni'],
                "Name" => $fields['cliente_nombre'],
                "LastName" => $fields['cliente_apellido']
            ];
            $alert = [
                "Alert" => "reload",
                "Title" => "Done",
                "Text" => "The customer was successfully added to the transaction",
                "Type" => "success"
            ];
            echo json_encode($alert);
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't add this customer",
                "Type" => "error"
            ];
            echo json_encode($alert);
        }

    }

    /*--- DELETE CUSTOMER FOR LOAN CONTROLLER ---*/
    public function delete_customer_loan_controller()
    {
        session_start(['name' => 'LOAN']);
        unset($_SESSION['data_customer']);

        if(empty($_SESSION['data_customer'])){
            $alert = [
                "Alert" => "reload",
                "Title" => "Done!",
                "Text" => "The customer was successfully removed",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't remove this customer",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }
}


