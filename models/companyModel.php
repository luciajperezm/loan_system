<?php

require_once "mainModel.php";

class companyModel extends mainModel
{

    /*--- COMPANY DATA MODEL ---*/
    protected static function company_data_model()
    {
        $sql = mainModel::connect()->prepare("SELECT * FROM empresa");
        $sql->execute();
        return $sql;
    }

    /*--- ADD COMPANY MODEL ---*/
    protected static function add_company_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO empresa(empresa_nombre, empresa_email, empresa_telefono, empresa_direccion) VALUES (:Name, :Email,:Phone,:Address)");
        $sql->bindParam("Name", $data['Name']);
        $sql->bindParam("Email", $data['Email']);
        $sql->bindParam("Phone", $data['Phone']);
        $sql->bindParam("Address", $data['Address']);

        $sql->execute();
        return $sql;
    }

    /*--- UPDATE COMPANY MODEL ---*/
    protected static function update_company_model($data)
    {
        $sql = mainModel::connect()->prepare("UPDATE empresa SET empresa_nombre=:Name, empresa_email=:Email, empresa_telefono=:Phone, empresa_direccion=:Address");

        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":Email", $data['Email']);
        $sql->bindParam(":Phone", $data['Phone']);
        $sql->bindParam(":Address", $data['Address']);

        $sql->execute();
        return $sql;
    }

}
