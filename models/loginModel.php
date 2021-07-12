<?php

require_once "mainModel.php";

class loginModel extends mainModel
{
    /*--- LOGIN MODEL ---*/
    protected static function login_model($data)
    {
        $sql = mainModel::connect()->prepare("SELECT * FROM usuario WHERE usuario_usuario=:Username AND usuario_clave=:Password AND usuario_estado='Active'");
        $sql->bindParam(":Username", $data['Username']);
        $sql->bindParam(":Password", $data['Password']);
        $sql->execute();
        return $sql;
    }
}
