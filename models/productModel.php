<?php
require_once "mainModel.php";

class productModel extends mainModel
{

    /*--- ADD PRODUCT MODEL ---*/
    protected static function add_product_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO item(item_codigo, item_nombre, item_stock, item_estado, item_detalle) VALUES(:Code, :Name, :Stock, :Status, :Detail)");

        $sql->bindParam(":Code", $data['Code']);
        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":Stock", $data['Stock']);
        $sql->bindParam(":Status", $data['Status']);
        $sql->bindParam(":Detail", $data['Detail']);

        $sql->execute();
        return $sql;
    }

    /*--- DELETE PRODUCT MODEL ---*/
    protected static function delete_product_model($id){
        $sql = mainModel::connect()->prepare("DELETE FROM item WHERE item_id  = :ID");

        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*--- DATA PRODUCT MODEL ---*/
    protected static function data_product_model($type, $id){
        if($type == "Unique"){
            $sql = mainModel::connect()->prepare("SELECT * FROM item WHERE item_id =:ID");
            $sql->bindParam(":ID", $id);
        }elseif($type == "Count"){
            $sql = mainModel::connect()->prepare("SELECT item_id FROM item");
        }
        $sql->execute();
        return $sql;
    }

    /*--- UPDATE PRODUCT MODEL ---*/
    protected static function update_product_model($data){
        $sql = mainModel::connect()->prepare("UPDATE item SET item_codigo=:Code, item_nombre=:Name, item_stock=:Stock, item_estado=:Status, item_detalle=:Detail WHERE item_id=:ID");

        $sql->bindParam(":Code", $data['Code']);
        $sql->bindParam(":Name", $data['Name']);
        $sql->bindParam(":Stock", $data['Stock']);
        $sql->bindParam(":Status", $data['Status']);
        $sql->bindParam(":Detail", $data['Detail']);
        $sql->bindParam(":ID", $data['ID']);

        $sql->execute();
        return $sql;
    }

}