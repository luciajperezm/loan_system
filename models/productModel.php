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

}