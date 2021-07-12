<?php

require_once "mainModel.php";

class customerModel extends mainModel
{

    /*--- ADD CUSTOMER MODEL ---*/
    protected static function add_customer_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO cliente(CLIENTE_DNI, CLIENTE_NOMBRE, CLIENTE_APELLIDO, CLIENTE_TELEFONO, CLIENTE_DIRECCION) VALUES(:DNI, :Name, :Lastname, :Phone, :Address) ");

        $sql->bindParam(":DNI", $data['DNI']);
        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":Lastname", $data['Lastname']);
        $sql->bindParam(":Phone", $data['Phone']);
        $sql->bindParam(":Address", $data['Address']);

        $sql->execute();
        return $sql;
    }

    /*--- DELETE CUSTOMER MODEL---*/
    protected static function delete_customer_model($id)
    {
        $sql = mainModel::connect()->prepare("DELETE FROM cliente WHERE cliente_id=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*--- DATA CUSTOMER MODEL---*/
    protected static function data_customer_model($type, $id)
    {
        if($type == "Unique"){
            $sql = mainModel::connect()->prepare("SELECT * FROM cliente WHERE cliente_id=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($type == "Count"){
            $sql = mainModel::connect()->prepare("SELECT cliente_id FROM cliente WHERE cliente_id!='1'");
        }
        $sql->execute();
        return $sql;
    }

    /*--- UPDATE CUSTOMER MODEL ---*/
    protected static function update_customer_model($data)
    {
        $sql = mainModel::connect()->prepare("UPDATE cliente SET cliente_nombre=:DNI, cliente_nombre=:Name, cliente_apellido=:LastName, cliente_telefono=:Phone, cliente_direccion=:Address WHERE cliente_id=:ID");

        $sql->bindParam(":DNI", $data['DNI']);
        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":LastName", $data['LastName']);
        $sql->bindParam(":Phone", $data['Phone']);
        $sql->bindParam(":Address", $data['Address']);

        $sql->bindParam(":ID", $data['ID']);

        $sql->execute();
        return $sql;
    }

}
