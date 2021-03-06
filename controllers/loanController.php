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
                "Text" => "The Quantity is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9]{1,7}", $time)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Time is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9.]{1,15}", $cost)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Cost is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($format != "Hours" && $format != "Days" && $format != "Event" && $format != "Month"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Format is not valid",
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
        /*starting session */
        session_start(['name' => 'LOAN']);

        /* making sure we have items selected */
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

        /* making sure we have a customer selected */
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
                "Text" => "The date input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $time_init)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The time input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_dates($date_final)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The return date is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $time_final)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The return time input is not valid",
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
            if(mainModel::verify_input_data("[a-zA-z0-9????????????????????????#() ]{1,400}", $observation)){
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

        if($status != "Reservation" && $status != "Loan" && $status != "Finished"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The status input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /* making sure the dates are valid */
        if(strtotime($date_final) < strtotime($date_init)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The return date cannot be set before the beginning of the lease",
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
            "FTime" => $time_final,
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
                "Text" => "We couldn't register this transaction (Error 001)",
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
                    "Text" => "We couldn't register this transaction (Error 002)",
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
                "Cost" => $prod['Cost'],
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
                "Text" => "The Lease was successfully registered",
                "Type" => "success"
            ];
        }else {
            loanModel::delete_loan_model($code, "Detail");
            loanModel::delete_loan_model($code, "Payment");
            loanModel::delete_loan_model($code, "Loan");
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register this transaction (Error 003)",
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
                    <p class="mb-0">Sorry, we are unable to show the requested information. The Date is not valid</p>
                </div>';
                exit();
            }
        }

        $fields = "prestamo.prestamo_id,prestamo.prestamo_codigo,prestamo.prestamo_fecha_inicio,prestamo.prestamo_fecha_final,prestamo.prestamo_total,prestamo.prestamo_pagado,prestamo.prestamo_estado,prestamo.usuario_id,prestamo.cliente_id,cliente.cliente_nombre,cliente.cliente_apellido";

        if($type == "Search" && $date_init != "" && $date_final != ""){
            $query = "SELECT SQL_CALC_FOUND_ROWS $fields FROM prestamo INNER JOIN cliente ON prestamo.cliente_id = cliente.cliente_id WHERE (prestamo.prestamo_fecha_inicio BETWEEN '$date_init' AND '$date_final') ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $init, $n_results";
        }else{
            $query = "SELECT SQL_CALC_FOUND_ROWS $fields FROM prestamo INNER JOIN cliente ON prestamo.cliente_id = cliente.cliente_id WHERE prestamo.prestamo_estado = '$type' ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $init, $n_results";
        }

        $connection = mainModel::connect();

        $data = $connection->query($query);
        $data = $data->fetchAll();

        /* NUmber of registered data */
        $total = $connection->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $N_pages = ceil($total / $n_results);

        $table.='<table class="table table-sm">
        <thead>
        <tr class="t-row">
            <th>#</th>
            <th class="text-center ">Customer</th>
            <th class="text-center ">Date</th>
            <th class="text-center ">return date</th>
            <th class="text-center ">type</th>
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
        <td class="text-center ">'.date("d-m-Y",strtotime($rows['prestamo_fecha_inicio'])).'</td>
        <td class="text-center ">'.date("d-m-Y",strtotime($rows['prestamo_fecha_final'])).'</td>';
        
        if($rows['prestamo_estado'] == "Reservation"){
            $table.='<td class="text-center "><span class="badge badge-secondary">'.$rows['prestamo_estado'].'</span></td>';
        }elseif($rows['prestamo_estado'] == "Finished"){
            $table.='<td class="text-center "><span class="badge badge-success">'.$rows['prestamo_estado'].'</span></td>';
        }else{
            $table.='<td class="text-center "><span class="badge badge-success">'.$rows['prestamo_estado'].'</span></td>';
        }


        if($rows['prestamo_pagado'] < $rows['prestamo_total']){
            $table.='<td class="text-center "><span class="badge badge-warning">Pending: '.CURRENCY.number_format(
                ($rows['prestamo_total'] - $rows['prestamo_pagado']),
                    2, '.', ','
                ).'</span></td>';
        }else{
            $table.='<td class="text-center "><span class="badge badge-info">Payed</span></td>';
        }

        $table.='<td class="text-center">
            <a href="'.SERVER_URL.'receipts/invoice.php?id='.mainModel::encryption($rows['prestamo_id']).'" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-invoice"></i>
            </a>
        </td>';

        if($privilege == 1 || $privilege == 2){
            if($rows['prestamo_estado'] == "Finished" && $rows['prestamo_pagado'] == $rows['prestamo_total']){
                $table.='<td class="text-center ">
                    <button class="btn btn-success" disabled>
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </td>';
            }else{
                $table.='<td class="text-center ">
                    <a href="'.SERVER_URL.'reservation-update/'.mainModel::encryption($rows['prestamo_id']).'/" class="btn 
                btn-success">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </td>';
            }
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
                $table.='<tr><td colspan="9" class="text-center">There are no transactions registered in the system</td></tr>';
            }
        }
        $table.='</tbody></table>';

        if($total >= 1 && $page <= $N_pages){
            $table.='<p class="text-right">'.$total.' loan(s)</p>';
            $table.=mainModel::pagination($page, $N_pages, $url, 7);
        }

        return $table;
    }

    /*--- DELETE LOAN CONTROLLER ---*/
    public function delete_loan_controller()
    {
        $code = mainModel::decryption($_POST['loan_code_del']);
        $code = mainModel::clean_input($code);

        $check_loan = mainModel::execute_simple_queries("SELECT prestamo_codigo FROM prestamo WHERE prestamo_codigo='$code'");

        if($check_loan->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this transaction",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*checking user privilege*/
        session_start(['name' => 'LOAN']);
        if($_SESSION['privilege_loan'] != 1){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "You are not allowed to do this",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_payment = mainModel::execute_simple_queries("SELECT prestamo_codigo FROM pago WHERE prestamo_codigo='$code'");
        $check_payment = $check_payment->rowCount();

        if($check_payment > 0){
            $del_payment = loanModel::delete_loan_model($code, "Payment");
            if($del_payment->rowCount() != $check_payment){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "We couldn't delete this transaction (Error Payment)",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        $check_detail = mainModel::execute_simple_queries("SELECT prestamo_codigo FROM detalle WHERE prestamo_codigo='$code'");
        $check_detail = $check_detail->rowCount();

        if($check_detail > 0){
            $del_detail = loanModel::delete_loan_model($code, "Detail");
            if($del_detail->rowCount() != $check_detail){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "We couldn't delete this transaction (Error Detail)",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        $del_loan = loanModel::delete_loan_model($code, "Loan");
        if($del_loan->rowCount() == 1){
            $alert = [
                "Alert" => "reload",
                "Title" => "Done",
                "Text" => "The Lease was successfully deleted",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't delete this transaction (Error Loan)",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
        exit();
    }

    /*--- ADD PAYMENT TO LOAN CONTROLLER ---*/
    public function add_payment_controller()
    {
        $code = mainModel::decryption($_POST['payment_code_reg']);
        $code = mainModel::clean_input($code);

        $amount = mainModel::clean_input($_POST['payment_amount_reg']);
        $amount = number_format($amount, 2, '.', '');

        if($amount <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The payment must be greater than zero",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data_payment = mainModel::execute_simple_queries("SELECT * FROM prestamo WHERE prestamo_codigo='$code'");

        if($data_payment->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this transaction",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }else {
            $data_payment = $data_payment->fetch();
        }


        $pending = $data_payment['prestamo_total'] - $data_payment['prestamo_pagado'];
        $pending = number_format($pending,2,'.', '');

        if($amount > $pending){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This payment is greater than the amount owed",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $total_payed = number_format(($_POST['payment_amount_reg'] + $data_payment['prestamo_pagado']), 2, '.', '');
        $date = date("Y-m-d");

        $data_payment_reg = [
            "Total" => $amount,
            "Date" => $date,
            "Code" => $code
        ];

        $add_payment = loanModel::add_payment_model($data_payment_reg);

        if($add_payment->rowCount() == 1){

            $data_payment_up = [
                "Type" =>"Payment",
                "Amount" => $total_payed,
                "Code" => $code
            ];

            if(loanModel::update_loan_model($data_payment_up)){
                $alert = [
                    "Alert" => "reload",
                    "Title" => "Done!",
                    "Text" => "The ".CURRENCY.$amount." payment was added successfully",
                    "Type" => "success"
                ];
            }else{
                loanModel::delete_loan_model($code, "Payment");
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "We couldn't add this payment",
                    "Type" => "error"
                ];
            }
            echo json_encode($alert);
            exit();

        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't add this payment",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
        exit();
    }

    /*--- UPDATE LOAN CONTROLLER ---*/
    public function update_loan_controller()
    {
        $code = mainModel::decryption($_POST['loan_code_up']);
        $code = mainModel::clean_input($code);

        $check_loan = mainModel::execute_simple_queries("SELECT prestamo_codigo FROM prestamo WHERE prestamo_codigo='$code'");
        if($check_loan->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this transaction",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $loan_status = mainModel::clean_input($_POST['loan_status_up']);
        $loan_observation = mainModel::clean_input($_POST['loan_observation_up']);

        if($loan_observation != ""){
            if(mainModel::verify_input_data("[a-zA-z0-9????????????????????????#() ]{1,400}", $loan_observation)){
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

        if($loan_status != "Reservation" && $loan_status != "Loan" && $loan_status != "Finished"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The status input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }


        $data_loan_up = [
            "Type" => "Loan",
            "Status" => $loan_status,
            "Observation" => $loan_observation,
            "Code" => $code
        ];

        if(loanModel::update_loan_model($data_loan_up)){
            $alert = [
                "Alert" => "reload",
                "Title" => "Done",
                "Text" => "The Lease was successfully updated",
                "Type" => "success"
            ];
        } else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't update this transaction",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
        exit();
    }

}


