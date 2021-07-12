<?php

if($ajaxRequest){
    require_once "../models/loginModel.php";
}else{
    require_once "./models/loginModel.php";
}

class loginController extends loginModel
{
    /*--- LOGIN CONTROLLER ---*/
    public function login_controller()
    {
        $username = mainModel::clean_input($_POST['username_log']);
        $password = mainModel::clean_input($_POST['password_log']);

        if($username == "" || $password == ""){
            /*- here we are not using ajax, so we have to send the alert with pure js */
            echo '<script>
                Swal.fire({
                    title: "Something went wrong",
                    text: "The input fields are empty",
                    type: "error",
                    confirmButtonColor: "#333"
                });
                </script>';
            exit();
        }

        /*-- checking data integrity --*/
        if(mainModel::verify_input_data("[a-zA-Z0-9]{1,35}", $username)){
            echo '<script>
                Swal.fire({
                    title: "Something went wrong",
                    text: "The Username is not valid",
                    type: "error",
                    confirmButtonColor: "#333"
                });
                </script>';
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-Z0-9@.-]{7,100}", $password))
        {
            echo '<script>
                Swal.fire({
                    title: "Something went wrong",
                    text: "The Password is not valid",
                    type: "error",
                    confirmButtonColor: "#333"
                });
                </script>';
            exit();
        }

        $password = mainModel::encryption($password);

        /*- data array for model-*/
        $login_data = [
            "Username" => $username,
            "Password" => $password
        ];

        $login = loginModel::login_model($login_data);

        if($login->rowCount()==1){
            $row = $login->fetch();

            session_start(['name' => 'LOAN']);
            $_SESSION['id_loan'] = $row['usuario_id'];
            $_SESSION['name_loan'] = $row['usuario_nombre'];
            $_SESSION['last_name_loan'] = $row['usuario_apellido'];
            $_SESSION['username_loan'] = $row['usuario_usuario'];
            $_SESSION['privilege_loan'] = $row['usuario_privilegio'];
            $_SESSION['token_loan'] = md5(uniqid(mt_rand(), true));

            return header("Location: ".SERVER_URL."home/");
        }else{
            echo '<script>
                Swal.fire({
                    title: "Something went wrong",
                    text: "The Username or Password are incorrect",
                    type: "error",
                    confirmButtonColor: "#333"
                });
                </script>';
        }
    }

    /*--- FORCE LOGOUT CONTROLLER ---*/
    public function force_logout_controller()
    {
        session_unset();
        session_destroy();

        if(headers_sent()){
            return "<script>window.location.href='".SERVER_URL."login/';</script>";
        }else {
            return header("Location: ".SERVER_URL."login/");
        }
    }

    /*---  LOGOUT CONTROLLER ---*/
    public function logout_controller()
    {
        session_start(['name' => 'LOAN']);
        $token = mainModel::decryption($_POST['token']);
        $username = mainModel::decryption($_POST['username']);

        if($token == $_SESSION['token_loan'] && $username == $_SESSION['username_loan']){
            session_unset();
            session_destroy();
            $alert = [
                "Alert" => "redirect",
                "URL" => SERVER_URL."login/"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't close your session",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }



}