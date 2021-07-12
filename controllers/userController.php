<?php

if($ajaxRequest){
    require_once "../models/userModel.php";
}else{
    require_once "./models/userModel.php";
}

class userController extends userModel
{

    /*--- ADD USER CONTROLLER ---*/
    public function add_user_controller()
    {
        /*- Receiving data from form -*/
        $dni = mainModel::clean_input($_POST['user_dni_reg']);
        $name = mainModel::clean_input($_POST['user_firstname_reg']);
        $last_name = mainModel::clean_input($_POST['user_lastname_reg']);
        $phone = mainModel::clean_input($_POST['user_phone_reg']);
        $address = mainModel::clean_input($_POST['user_address_reg']);
        $email = mainModel::clean_input($_POST['user_email_reg']);
        $username = mainModel::clean_input($_POST['user_username_reg']);
        $password1 = mainModel::clean_input($_POST['user_password_1_reg']);
        $password2 = mainModel::clean_input($_POST['user_password_2_reg']);
        $privilege = mainModel::clean_input($_POST['user_privilege_reg']);

        /*- Checking for empty fields -*/
        if($dni == "" || $name == "" || $last_name == "" || $username == "" || $password1 == "" || $password2 == ""){
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
                "Text" => "The user's Name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $last_name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The user's Last name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($phone != ""){
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
        }

        if($address != ""){
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
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9]{1,35}", $username)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Username is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9$@.-]{7,100}", $password1) || mainModel::verify_input_data("[a-zA-Z0-9$@.-]{7,100}", $password2)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Password is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- Is the user already registered? -*/
        $check_user = mainModel::execute_simple_queries("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$username'");
        if($check_user->rowCount()>0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Username is already registered",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- Is the email valid? -*/
        if($email != ""){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $check_email=mainModel::execute_simple_queries("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
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
        }

        /*- Password validation -*/
        if($password1 != $password2){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Passwords do not match",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }else{
            $password = mainModel::encryption($password1);
        }

        /*- Validating Available privileges -*/
        if($privilege < 1 || $privilege > 3){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The selected Privilege is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- DATA ARRAY TO REGISTER USER -*/
        $user_data_reg = [
            "DNI"=>$dni,
            "Name"=>$name,
            "LastName"=>$last_name,
            "Phone"=>$phone,
            "Address"=>$address,
            "Email"=>$email,
            "Username"=>$username,
            "Password"=>$password,
            "Status"=>"Active",
            "Privilege"=>$privilege
        ];

        $add_user = userModel::add_user_model($user_data_reg);

        if($add_user->rowCount()==1){
            $alert = [
                "Alert" => "clean",
                "Title" => "Done",
                "Text" => "This User was successfully registered",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register this user",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- PAGINATION USERS CONTROLLER ---*/
    public function pagination_user_controller($page, $n_results, $privilege, $id, $url, $search)
    {
        $page = mainModel::clean_input($page);
        $n_results = mainModel::clean_input($n_results);
        $privilege = mainModel::clean_input($privilege);
        $id = mainModel::clean_input($id);

        $url = mainModel::clean_input($url);
        $url = SERVER_URL.$url."/";

        $search = mainModel::clean_input($search);

        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $init = ($page > 0) ? (($page * $n_results) - $n_results) : 0;

        if(isset($search) && $search != ""){
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((usuario_id != '$id' AND usuario_id != '1') AND(usuario_dni LIKE '%$search%' OR usuario_nombre LIKE '%$search%' OR usuario_apellido LIKE '%$search%' OR usuario_email LIKE '%$search%' OR usuario_telefono LIKE '%$search%' OR usuario_usuario LIKE '%$search%')) ORDER BY usuario_nombre ASC LIMIT $init, $n_results";
        }else{
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE usuario_id != '$id' AND usuario_id != '1' ORDER BY usuario_nombre ASC LIMIT $init, $n_results";
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
            <th class="text-center ">DNI</th>
            <th class="text-center ">Full Name</th>
            <th class="text-center ">Phone</th>
            <th class="text-center ">Username</th>
            <th class="text-center ">Email</th>
            <th class="text-center ">Update</th>
            <th class="text-center ">Delete</th>
        </tr></thead><tbody class="table__body">';

        if($total >= 1 && $page <= $N_pages){
            $counter = $init + 1;
            $reg_init = $init + 1;
            foreach($data as $rows) {
                $table.='<tr>
        <td class="text-center ">'.$counter.'</td>
        <td class="text-center ">'.$rows['usuario_dni'].'</td>
        <td class="text-center ">'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
        <td class="text-center ">'.$rows['usuario_telefono'].'</td>
        <td class="text-center ">'.$rows['usuario_usuario'].'</td>
        <td class="text-center ">'.$rows['usuario_email'].'</td>
        
        <td class="text-center ">
            <a href="'.SERVER_URL.'user-update/'.mainModel::encryption($rows['usuario_id']).'/" class="btn 
btn-success">
                <i class="fas fa-sync-alt"></i>
            </a>
        </td>
        <td class="text-center ">
            <form class="Ajax_Form form-table" action="'.SERVER_URL.'ajax/userAjax.php" method="post" data-form="delete"
autocomplete="off"> 
<input type="hidden" name="user_id_del" value="'.mainModel::encryption($rows['usuario_id']).'">
                <button type="submit" class="btn btn-warning">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
        </td>
    </tr>';
                $counter++;
            }
            $reg_final = $counter - 1;
        }else {
            if($total >= 1){
                $table.='<tr><td colspan="9" class="text-center"><a href="'.$url.'" class="btn btn-raised btn-success btn-sm">CLick here to reload list</a></td></tr>';
            }else {
                $table.='<tr><td colspan="9" class="text-center">There are no users registered in the system</td></tr>';
            }
        }
        $table.='</tbody></table>';
        
        if($total >= 1 && $page <= $N_pages){
            $table.='<p class="text-right">'.$reg_final.' out of '.$total.' user(s)</p>';
            $table.=mainModel::pagination($page, $N_pages, $url, 7);
        }

        return $table;
    }

    /*--- DELETE USER CONTROLLER ---*/
    public function delete_user_controller()
    {
        /*- receiving id from form -*/
        $id = mainModel::decryption($_POST['user_id_del']);
        $id = mainModel::clean_input($id);

        /*- checking user identity-*/
        if($id == 1){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We cannot delete the main user of the system",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_user = mainModel::execute_simple_queries("SELECT usuario_id FROM usuario WHERE  usuario_id='$id'");
        if($check_user->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The user you are trying to delete doesn't exist",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_loan = mainModel::execute_simple_queries("SELECT usuario_id FROM prestamo WHERE  usuario_id='$id' LIMIT 1");
        if($check_loan->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "We can't delete this user",
                "Text" => "This user has made loans, you may change their status to Inactive",
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

        $delete_user = userModel::delete_user_model($id);

        if($delete_user->rowCount() == 1){
            $alert = [
                "Alert" => "reload",
                "Title" => "Great news!",
                "Text" => "The selected user was deleted successfully",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't delete this user",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- DATA USER CONTROLLER ---*/
    public function data_user_controller($type, $id)
    {
        $type = mainModel::clean_input($type);
        $id = mainModel::decryption($id);
        $id = mainModel::clean_input($id);

        return userModel::data_user_model($type, $id);
    }

    /*--- UPDATE USER CONTROLLER ---*/
    public function update_user_controller()
    {
        /* receiving id from form */
        $id = mainModel::decryption($_POST['user_id_up']);
        $id = mainModel::clean_input($id);

        /* make sure id is in database*/
        $chek_user = mainModel::execute_simple_queries("SELECT * FROM usuario WHERE usuario_id='$id'");

        if($chek_user->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this user",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        } else{
            $fields = $chek_user->fetch();
        }
        $dni = mainModel::clean_input($_POST['user_dni_up']);
        $name = mainModel::clean_input($_POST['user_firstname_up']);
        $last_name = mainModel::clean_input($_POST['user_lastname_up']);
        $phone = mainModel::clean_input($_POST['user_phone_up']);
        $address = mainModel::clean_input($_POST['user_address_up']);

        $username = mainModel::clean_input($_POST['user_username_up']);
        $email = mainModel::clean_input($_POST['user_email_up']);

        if(isset($_POST['user_status_up'])){
            $status = mainModel::clean_input($_POST['user_status_up']);
        }else{
            $status = $fields['usuario_estado'];
        }

        if(isset($_POST['user_privilege_up'])){
            $privilege = mainModel::clean_input($_POST['user_privilege_up']);
        }else{
            $privilege = $fields['usuario_privilegio'];
        }

        $admin_username = mainModel::clean_input($_POST['user_admin']);
        $admin_password = mainModel::clean_input($_POST['admin_password']);


        $account_type = mainModel::clean_input($_POST['account_type']);

        if($dni == "" || $name == "" || $last_name == "" || $username == "" || $admin_username == "" || $admin_password == ""){
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
                "Text" => "The user's Name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $last_name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The user's Last name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($phone != ""){
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
        }

        if($address != ""){
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
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9]{1,35}", $username)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Username is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9]{1,35}", $admin_username)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Your Username is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9$@-]{7,100}", $admin_password)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Your Password is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $admin_password = mainModel::encryption($admin_password);

        if($privilege < 1 || $privilege > 3){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The selected privilege/User role is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($status != "Active" && $status != "Inactive"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The selected status is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($dni != $fields['usuario_dni']) {
            $check_dni = mainModel::execute_simple_queries("SELECT usuario_dni FROM usuario WHERE usuario_dni='$dni'");
            if ($check_dni->rowCount() > 0) {
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "This DNI is already registered",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        /*- Is the user already registered? -*/
        if($username != $fields['usuario_usuario']) {
            $check_user = mainModel::execute_simple_queries("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$username'");
            if($check_user->rowCount() > 0){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The Username is already registered",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if($email != $fields['usuario_email'] && $email != ""){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $check_email = mainModel::execute_simple_queries("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
                if($check_email->rowCount() > 0){
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
                    "Text" => "The Email is not valid",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if($_POST['user_password_1_up'] != "" || $_POST['user_password_2_up'] != ""){
            if($_POST['user_password_1_up'] != $_POST['user_password_2_up']){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The Passwords don't match",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }else {
                if(mainModel::verify_input_data("[a-zA-Z0-9$@.-]{7,100}", $_POST['user_password_1_up']) ||
                    mainModel::verify_input_data("[a-zA-Z0-9$@.-]{7,100}", $_POST['user_password_2_up'])){
                    $alert = [
                        "Alert" => "simple",
                        "Title" => "Something went wrong",
                        "Text" => "The Passwords are not valid",
                        "Type" => "error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
                $password = mainModel::encryption($_POST['user_password_1_up']);
            }
        }else{
            $password = $fields['usuario_clave'];
        }

        if($account_type == "own_account"){
            $check_account = mainModel::execute_simple_queries("SELECT usuario_id FROM usuario WHERE usuario_usuario='$admin_username' AND usuario_clave='$admin_password' AND usuario_id='$id'");
        }else{
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
            $check_account = mainModel::execute_simple_queries("SELECT usuario_id FROM usuario WHERE usuario_usuario='$admin_username' AND usuario_clave='$admin_password'");
        }

        if($check_account->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This account doesn't exist",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $user_data_up = [
            "DNI" => $dni,
            "Name" => $name,
            "LastName" => $last_name,
            "Phone" => $phone,
            "Address" => $address,
            "Email" => $email,
            "Username" => $username,
            "Status" => $status,
            "Password" => $password,
            "Privilege" => $privilege,
            "ID" => $id
        ];

        if(userModel::update_user_model($user_data_up)){
            $alert = [
                "Alert" => "reload",
                "Title" => "Great News",
                "Text" => "This user was successfully updated",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't update this user",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

}
