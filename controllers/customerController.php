<?php

if($ajaxRequest){
    require_once "../models/customerModel.php";
}else{
    require_once "./models/customerModel.php";
}

class customerController extends customerModel
{

    /*--- ADD CUSTOMER CONTROLLER ---*/
    public function add_customer_controller()
    {
        $dni = mainModel::clean_input($_POST['customer_dni_reg']);
        $name = mainModel::clean_input($_POST['customer_name_reg']);
        $last_name = mainModel::clean_input($_POST['customer_lastname_reg']);
        $phone = mainModel::clean_input($_POST['customer_phone_reg']);
        $address = mainModel::clean_input($_POST['customer_address_reg']);


        /*- Checking for empty fields -*/
        if($dni == "" || $name == "" || $last_name == "" || $phone == "" || $address == ""){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Some input fields are empty",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9-]{1,20}", $dni)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The DNI number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The (Customer Name) input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $last_name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The (Customer Last name) input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9+-]{1,15}", $phone)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The (Phone) input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}", $address)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Address is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_dni = mainModel::execute_simple_queries("SELECT cliente_dni FROM cliente WHERE cliente_dni='$dni'");

        if($check_dni->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This ID is already registered",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data_customer = [
            "DNI" => $dni,
            "Name" => $name,
            "Lastname" => $last_name,
            "Phone" => $phone,
            "Address" => $address
        ];

        $add_customer = customerModel::add_customer_model($data_customer);

        if($add_customer->rowCount() == 1){
            $alert = [
                "Alert" => "clean",
                "Title" => "Great news!",
                "Text" => "The Customer was registered successfully",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register this Customer",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- PAGINATION CONTROLLER ---*/
    public function pagination_customer_controller($page, $n_results, $privilege, $url, $search)
    {
        $page = mainModel::clean_input($page);
        $n_results = mainModel::clean_input($n_results);
        $privilege = mainModel::clean_input($privilege);

        $url = mainModel::clean_input($url);
        $url = SERVER_URL.$url."/";

        $search = mainModel::clean_input($search);

        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $init = ($page > 0) ? (($page * $n_results) - $n_results) : 0;

        if(isset($search) && $search != ""){
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE cliente_dni LIKE '%$search%' OR cliente_nombre LIKE '%$search%' OR cliente_apellido LIKE '%$search%' ORDER BY cliente_nombre ASC LIMIT $init, $n_results";
        }else{
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $init, $n_results";
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
            <th class="text-center ">ID</th>
            <th class="text-center ">Full Name</th>
            <th class="text-center ">Phone</th>
            <th class="text-center ">Address</th>';

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
        <td class="text-center ">'.$rows['cliente_dni'].'</td>
        <td class="text-center ">'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
        <td class="text-center ">'.$rows['cliente_telefono'].'</td>
        <td class="text-center ">
            <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'" data-content="'.$rows['cliente_direccion'].'">
                <i class="fas fa-info-circle"></i>
            </button>
        </td>';

        if($privilege == 1 || $privilege == 2){
            $table.='<td class="text-center ">
            <a href="'.SERVER_URL.'customer-update/'.mainModel::encryption($rows['cliente_id']).'/" class="btn 
btn-success">
                <i class="fas fa-sync-alt"></i>
            </a>
        </td>';
        }

        if($privilege == 1){
            $table.='<td class="text-center ">
            <form class="Ajax_Form form-table" action="'.SERVER_URL.'ajax/customerAjax.php" method="post" data-form="delete"
autocomplete="off"> 
<input type="hidden" name="customer_id_del" value="'.mainModel::encryption($rows['cliente_id']).'">
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
                $table.='<tr><td colspan="9" class="text-center">There are no customers registered in the system</td></tr>';
            }
        }
        $table.='</tbody></table>';

        if($total >= 1 && $page <= $N_pages){
            $table.='<p class="text-right">'.$total.' customer(s)</p>';
            $table.=mainModel::pagination($page, $N_pages, $url, 7);
        }

        return $table;
    }
    
    /*--- DELETE CUSTOMER CONTROLLER ---*/
    public function delete_customer_controller()
    {
        /*- receiving id from form -*/
        $id = mainModel::decryption($_POST['customer_id_del']);
        $id = mainModel::clean_input($id);

        $check_customer = mainModel::execute_simple_queries("SELECT cliente_id FROM cliente WHERE  cliente_id='$id'");
        if($check_customer->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The customer you are trying to delete doesn't exist",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_loan = mainModel::execute_simple_queries("SELECT cliente_id FROM prestamo WHERE  cliente_id='$id' LIMIT 1");
        if($check_loan->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "We can't delete this user",
                "Text" => "We can't delete this this customer because they are involved in a previous transaction",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- checking privileges -*/
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

        $delete_customer = customerController::delete_customer_model($id);

        if($delete_customer->rowCount() == 1){
            $alert = [
                "Alert" => "reload",
                "Title" => "Great news!",
                "Text" => "The selected customer was deleted successfully",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't delete this customer",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- DATA CUSTOMER CONTROLLER ---*/
    public function data_customer_controller($type, $id)
    {
        $type = mainModel::clean_input($type);
        $id = mainModel::decryption($id);
        $id = mainModel::clean_input($id);

        return customerModel::data_customer_model($type, $id);
    }

    /*--- UPDATE CUSTOMER CONTROLLER ---*/
    public function update_customer_controller()
    {
        /* receiving id from form */
        $id = mainModel::decryption($_POST['customer_id_up']);
        $id = mainModel::clean_input($id);

        /* make sure id is in database*/
        $chek_customer = mainModel::execute_simple_queries("SELECT * FROM cliente WHERE cliente_id='$id'");

        if($chek_customer->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this customer",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        } else{
            $fields = $chek_customer->fetch();
        }
        $dni = mainModel::clean_input($_POST['customer_dni_up']);
        $name = mainModel::clean_input($_POST['customer_name_up']);
        $last_name = mainModel::clean_input($_POST['customer_last_name_up']);
        $phone = mainModel::clean_input($_POST['customer_phone_up']);
        $address = mainModel::clean_input($_POST['customer_address_up']);

        /*- Checking for empty fields -*/
        if($dni == "" || $name == "" || $last_name == "" || $phone == "" || $address == ""){
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
        if(mainModel::verify_input_data("[0-9-]{1,20}", $dni)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The ID number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Name input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $last_name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Last name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9+-]{1,15}", $phone)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Phone number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}", $address)){
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
                "Text" => "You are not allowed to update this customer",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $customer_data_up = [
            "DNI" => $dni,
            "Name" => $name,
            "LastName" => $last_name,
            "Phone" => $phone,
            "Address" => $address,
            "ID" => $id
        ];

        if(customerModel::update_customer_model($customer_data_up)){
            $alert = [
                "Alert" => "reload",
                "Title" => "Great News",
                "Text" => "This customer was successfully updated",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't update this customer",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }
}

