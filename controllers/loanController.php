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

    /*--- SEARCH PRODUCT FOR LOAN CONTROLLER ---*/
    public function search_product_loan_controller()
    {
        /* receive text */
        $product = mainModel::clean_input($_POST['search_product']);

        if($product == ""){
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        The input field is empty
                    </p>
                </div>';
            exit();
        }

        /* product in db */
        $data_product = mainModel::execute_simple_queries("SELECT * FROM item WHERE item_codigo LIKE '%$product%' OR item_nombre LIKE '%$product%' AND item_estado = 'Available' ORDER BY item_nombre");

        if($data_product->rowCount() >= 1){
            $data_product = $data_product->fetchAll();
            $table = '<div class="table-responsive"><table class="table table-hover table-bordered table-sm"><tbody>';
            foreach($data_product as $rows){
                $table.='<tr class="text-center">
                                <td>'.$rows['item_codigo'].' - '.$rows['item_nombre'].'</td><td><button type="button" class="btn btn-primary" onclick="modal_add_products('.$rows['item_id'].')"><i class="fas fa-box-open"></i></button></td></tr>';
            }

            $table.=' </tbody></table></div>';
            return $table;
        }else{
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        We couldn\'t find a product that matched with <strong>"'.$product.'"</strong>
                    </p>
                </div>';
            exit();
        }
    }

    /*--- ADD PRODUCT FOR LOAN CONTROLLER ---*/
    public function add_product_loan_controller()
    {
        $id = mainModel::clean_input($_POST['id_add_product']);

        $data_product = mainModel::execute_simple_queries("SELECT * FROM item WHERE (item_id='$id') AND (item_estado = 'Available')");

        if($data_product->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this product",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }else{
            $fields = $data_product->fetch();
        }

        $format = mainModel::clean_input($_POST['detail_format']);
        $quantity = mainModel::clean_input($_POST['detail_quantity']);
        $time = mainModel::clean_input($_POST['detail_time']);
        $cost = mainModel::clean_input($_POST['detail_cost_time']);

        if($quantity == "" || $time == "" || $cost == ""){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Some input fields are empty",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9]{1,7}", $quantity)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Quantity is not correct",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9]{1,7}", $time)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Time is not correct",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9.]{1,15}", $cost)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Cost is not correct",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($format != "Hours" && $format != "Days" && $format != "Event" && $format != "Month"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Format is not correct",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        session_start(['name' => 'LOAN']);
        if(empty($_SESSION['data_product'][$id])){
            $cost = number_format($cost, 2, '.', '');

            $_SESSION['data_product'][$id] = [
                "ID" => $fields['item_id'],
                "Code" => $fields['item_codigo'],
                "Name" => $fields['item_nombre'],
                "Detail" => $fields['item_detalle'],
                "Format" => $format,
                "Quantity" => $quantity,
                "Time" => $time,
                "Cost" => $cost
            ];
            $alert = [
                "Alert" => "reload",
                "Title" => "Done!",
                "Text" => "The Product was successfully added to the transaction",
                "Type" => "success"
            ];
            echo json_encode($alert);
            exit();
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Product you are trying to add is already selected",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

    }

    /*--- DELETE PRODUCT FOR LOAN CONTROLLER ---*/
    public function delete_product_loan_controller()
    {
        $id = mainModel::clean_input($_POST['id_delete_product']);

        session_start(['name' => 'LOAN']);
        unset($_SESSION['data_product'][$id]);

        if(empty($_SESSION['data_product'][$id])){
            $alert = [
                "Alert" => "reload",
                "Title" => "Done!",
                "Text" => "The product was successfully removed",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't remove this product",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- DATA LOAN CONTROLLER ---*/
    public function data_loan_controller($type, $id)
    {
        $type = mainModel::clean_input($type);
        $id = mainModel::decryption($id);
        $id = mainModel::clean_input($id);

        return loanModel::data_loan_model($type, $id);
    }

    /*--- ADD LOAN CONTROLLER ---*/
    public function add_loan_controller()
    {
        session_start(['name' => 'LOAN']);

        if($_SESSION['loan_item'] == 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "You haven't selected a product to make this transaction",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(empty($_SESSION['data_customer'])){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "You haven't selected a customer to make this transaction",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        // receiving data from the form
        $date_init = mainModel::clean_input($_POST['loan_date_init_reg']);
        $time_init = mainModel::clean_input($_POST['loan_time_init_reg']);
        $date_final = mainModel::clean_input($_POST['loan_date_final_reg']);
        $time_final = mainModel::clean_input($_POST['loan_time_final_reg']);
        $status = mainModel::clean_input($_POST['loan_status_reg']);
        $total_payed = mainModel::clean_input($_POST['loan_payed_reg']);
        $observation = mainModel::clean_input($_POST['loan_observation_reg']);

        if(mainModel::verify_input_dates($date_init)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The initial date is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $time_init)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The initial time is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_dates($date_final)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The final date is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $time_final)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The time input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9.]{1,10}", $total_payed)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The (Total payed) input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($observation != ""){
            if(mainModel::verify_input_data("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}", $observation)){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The (Observation) input is not valid",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if($status =! "Reservation" && $status =! "Loan" && $status =! "Finished"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The status input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /* making sure dates are right */
        if(strtotime($date_final) < strtotime($date_init)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The completion date cannot be set before the beginning of the lease",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /* formatting data */
        $total_loan = number_format($_SESSION['loan_total'], 2, '.', '');
        $total_payed = number_format($total_payed, 2, '.', '');
        $date_init = date("Y-m-d", strtotime($date_init));
        $date_final = date("Y-m-d", strtotime($date_final));
        $time_init = date("h:i a", strtotime($time_init));
        $time_final = date("h:i a", strtotime($time_final));

        /* generate unique code for loan */
        $correlative = mainModel::execute_simple_queries("SELECT prestamo_id FROM prestamo");
        $correlative = ($correlative->rowCount()) + 1;

        $code = mainModel::generate_random_code("LC", 6, $correlative);

        $data_loan_reg = [
            "Code" => $code,
            "IDate" => $date_init,
            "ITime" => $time_init,
            "FDate" => $date_final,
            "FTime" => $date_final,
            "Quantity" => $_SESSION['loan_item'],
            "Total" => $total_loan,
            "Payed" => $total_payed,
            "Status" => $status,
            "Observation" => $observation,
            "User" => $_SESSION['id_loan'],
            "Customer" => $_SESSION['data_customer']['ID']
        ];

        $add_loan = loanModel::add_loan_model($data_loan_reg);

        if($add_loan->rowCount() != 1) {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register the Loan (Error L1)",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /* adding a payment */
        if($total_payed > 0){
            $data_payment_reg = [
               "Total" => $total_payed,
                "Date" => $date_init,
                "Code" => $code
            ];

            $add_payment = loanModel::add_payment_model($data_payment_reg);

            if($add_payment->rowCount() != 1){
                loanModel::delete_loan_model($code, "Loan");
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "We couldn't register the Loan (Error L2)",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        /* adding details to the loan */
        $errors_detail = 0;
        foreach($_SESSION['data_product'] as $prod){
            $cost = number_format($prod['Cost'], 2, '.', '');
            $description = $prod['Code']." - ".$prod['Name'];

            $data_detail_reg = [
                "Quantity" => $prod['Quantity'],
                "Format" => $prod['Format'],
                "Time" => $prod['Time'],
                "TimeCost" => $prod['Cost'],
                "Description" => $description,
                "Code" => $code,
                "Product" => $prod['ID']
            ];

            $add_detail = loanModel::add_detail_model($data_detail_reg);

            if($add_detail->rowCount() != 1){
                $errors_detail = 1;
                break;
            }
        }

        if($errors_detail == 0){
            unset($_SESSION['data_customer']);
            unset($_SESSION['data_product']);
            $alert = [
                "Alert" => "reload",
                "Title" => "Done!",
                "Text" => "The Loan was successfully registered",
                "Type" => "success"
            ];
        }else {
            loanModel::delete_loan_model($code, "Detail");
            loanModel::delete_loan_model($code, "Payment");
            loanModel::delete_loan_model($code, "Loan");
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register the Loan (Error L3)",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);



    }
}


