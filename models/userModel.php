<?php

require_once "mainModel.php";

class userModel extends mainModel
{
    /*--- ADD USER MODEL---*/
    protected static function add_user_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO usuario(usuario_dni, usuario_nombre, usuario_apellido, usuario_telefono, usuario_direccion, usuario_email, usuario_usuario, usuario_clave, usuario_estado, usuario_privilegio) VALUES(:DNI, :Name, :LastName, :Phone, :Address, :Email, :Username, :Password, :Status, :Privilege)");

        $sql->bindParam(":DNI", $data['DNI']);
        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":LastName", $data['LastName']);
        $sql->bindParam(":Phone", $data['Phone']);
        $sql->bindParam(":Address", $data['Address']);
        $sql->bindParam(":Email", $data['Email']);
        $sql->bindParam(":Username", $data['Username']);
        $sql->bindParam(":Password", $data['Password']);
        $sql->bindParam(":Status", $data['Status']);
        $sql->bindParam(":Privilege", $data['Privilege']);

        $sql->execute();
        return $sql;
    }

    /*--- DELETE USER MODEL---*/
    protected static function delete_user_model($id)
    {
        $sql = mainModel::connect()->prepare("DELETE FROM usuario WHERE usuario_id=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*--- DATA USER MODEL---*/
    protected static function data_user_model($type, $id)
    {
        if($type == "Unique"){
            $sql = mainModel::connect()->prepare("SELECT * FROM usuario WHERE usuario_id=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($type == "Count"){
            $sql = mainModel::connect()->prepare("SELECT usuario_id FROM usuario WHERE usuario_id!='1'");
        }
        $sql->execute();
        return $sql;
    }

    /*--- UPDATE USER MODEL ---*/
    protected static function update_user_model($data)
    {
        $sql = mainModel::connect()->prepare("UPDATE usuario SET usuario_dni=:DNI, usuario_nombre=:Name, usuario_apellido=:LastName, usuario_telefono=:Phone, usuario_direccion=:Address, usuario_email=:Email, usuario_usuario=:Username, usuario_estado=:Status, usuario_clave=:Password, usuario_privilegio=:Privilege WHERE usuario_id=:ID");

        $sql->bindParam(":DNI", $data['DNI']);
        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":LastName", $data['LastName']);
        $sql->bindParam(":Phone", $data['Phone']);
        $sql->bindParam(":Address", $data['Address']);
        $sql->bindParam(":Email", $data['Email']);
        $sql->bindParam(":Username", $data['Username']);
        $sql->bindParam(":Status", $data['Status']);
        $sql->bindParam(":Password", $data['Password']);
        $sql->bindParam(":Privilege", $data['Privilege']);
        $sql->bindParam(":ID", $data['ID']);

        $sql->execute();
        return $sql;
    }


}
