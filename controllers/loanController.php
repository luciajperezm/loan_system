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

    /*--- PAGINATION LOAN CONTROLLER ---*/
    public function pagination_loan_controller($page, $n_results, $privilege, $url, $type, $date_init, $date_final)
    {
        $page = mainModel::clean_input($page);
        $n_results = mainModel::clean_input($n_results);
        $privilege = mainModel::clean_input($privilege);

        $url = mainModel::clean_input($url);
        $url = SERVER_URL.$url."/";

        $type = mainModel::clean_input($type);
        $date_init = mainModel::clean_input($date_init);
        $date_final = mainModel::clean_input($date_final);

        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $init = ($page > 0) ? (($page * $n_results) - $n_results) : 0;

        if($type == "Search"){
            if(mainModel::verify_input_dates($date_init) || mainModel::verify_input_dates($date_final)){
                return '
                <div class="alert alert-danger text-center" role="alert">
                    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                    <h4 class="alert-heading">Something went Wrong!</h4>
                    <p class="mb-0">Sorry, we are unable to show the requested information, The dates are not valid.</p>
                </div>
                ';
                exit();
            }
        }

        $fields = "prestamo.prestamo_id, prestamo.prestamo_codigo, prestamo.prestamo_fecha_inicio, prestamo.prestamo_fecha_final, prestamo.prestamo_total, prestamo.prestamo_pagadp, prestamo.prestamo_estado, prestamo.usuario_id, prestamo.cliente_id, cliente.cliente_nombre, cliente.cliente_apellido";

        if($type == "Search" && $date_init != "" && $date_final != ""){
            $query = "SELECT SQL_CALC_FOUND_ROWS $fields FROM prestamo INNER JOIN cliente ON prestamo.cliente_id = cliente.cliente_id WHERE  (prestamo.prestamo_fecha_inicio BETWEEN '$date_init' AND '$date_final') ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $init, $n_results";
        }else{
            $query = "SELECT SQL_CALC_FOUND_ROWS $fields FROM prestamo INNER JOIN cliente ON prestamo.cliente_id = cliente.cliente_id WHERE prestamo.prestamo_estado ='$type' ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $init, $n_results";
        }

        $connection = mainModel::connect();

        $data = $connection->query($query);
        $data = $data->fetchAll();

        /* NUmber of registered data */
        $total = $connection->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $N_pages = ceil($total / $n_results);

        $table.='<table class="table table-sm">
        <thead >
    <tr class="t-row">
        <th>#</th>
        <th class="text-center ">customer</th>
        <th class="text-center ">Loan date</th>
        <th class="text-center ">Return Date</th>
        <th class="text-center ">Type</th>
        <th class="text-center ">status</th>
        <th class="text-center ">receipt</th>';

        if($privilege == 1 || $privilege == 2){
            $table.='<th class="text-center ">Update</th>';
        }
        if($privilege == 1){
            $table.='<th class="text-center ">Delete</th>';
        }

        $table.=' </tr></thead><tbody class="table__body">';

        if($total >= 1 && $page <= $N_pages){
            $counter = $init + 1;
            $reg_init = $init + 1;
            foreach($data as $rows) {
                $table.='<tr>
        <td class="text-center ">'.$counter.'</td>
        <td class="text-center ">'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
        <td class="text-center ">'.date("d-m-Y", strtotime($rows['prestamo_fecha_inicio'])).'</td>
        <td class="text-center ">'.date("d-m-Y", strtotime($rows['prestamo_fecha_final'])).'</td>
        <td class="text-center ">'.$rows['prestamo_estado'].'</td>';


                if($rows['prestamo_pagado'] < $rows['prestamo_total']){
                    $table.='<td class="text-center "><span class="badge badge-primary">Pending'.CURRENCY
                        .number_format(($rows['prestamo_total'] - $rows['prestamo_pagado']), 2, '.',',').'</span></td>';
                }else {
        $table.='<td class="text-center "><span class="badge badge-light">Canceled</span></td>';}

        $table.='
            <td class="text-center">
                <a href="'.SERVER_URL.'receipts/invoice.php?id='.mainModel::encryption($rows['prestamo_id']).'" target="_blank" class="btn btn-danger">
                    <i class="fas fa-file-invoice"></i>
                </a>
            </td>
        
        ';
            if($privilege == 1 || $privilege == 2){
                if($rows['prestamo_estado'] == "Finished" && $rows['prestamo_pagado'] == $rows['prestamo_total']){
                    $table.='<td class="text-center ">
                        <button class="btn 
                btn-success" disabled>
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>';
                }else {
                $table.='<td class="text-center ">
                        <a href="'.SERVER_URL.'reservation-update/'.mainModel::encryption($rows['prestamo_id']).'/" class="btn 
                btn-success">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </td>';}
            }

                if($privilege == 1){
                    $table.='<td class="text-center ">
            <form class="Ajax_Form form-table" action="'.SERVER_URL.'ajax/loanAjax.php" method="post" data-form="delete"
autocomplete="off"> 
<input type="hidden" name="loan_code_del" value="'.mainModel::encryption($rows['prestamo_codigo']).'">
                <button type="submit" class="btn btn-warning">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
        </td>';
                }

                $table.='</tr>';
                $counter++;
            }
            $reg_final = $counter - 1;
        }else {
            if($total >= 1){
                $table.='<tr><td colspan="9" class="text-center"><a href="'.$url.'" class="btn btn-raised btn-success btn-sm">CLick here to reload list</a></td></tr>';
            }else {
                $table.='<tr><td colspan="9" class="text-center">There are no loans registered in the system</td></tr>';
            }
        }
        $table.='</tbody></table>';

        if($total >= 1 && $page <= $N_pages){
            $table.='<p class="text-right">'.$reg_final.' out of '.$total.' loan(s)</p>';
            $table.=mainModel::pagination($page, $N_pages, $url, 7);
        }

        return $table;
    }

}


