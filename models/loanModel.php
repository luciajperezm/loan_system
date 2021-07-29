<?php
require_once "mainModel.php";

class loanModel extends mainModel
{

    /*--- ADD LOAN MODEL ---*/
    protected static function add_loan_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO prestamo(prestamo_codigo, prestamo_fecha_inicio, prestamo_hora_inicio, prestamo_fecha_final, prestamo_hora_final, prestamo_cantidad, prestamo_total, prestamo_pagado, prestamo_estado, prestamo_observacion, usuario_id, cliente_id) VALUES(:Code, :IDate, :ITime, :FDate, :FTime, :Quantity, :Total, :Payed, :Status, :Observation, :User, :Customer)");

        $sql->bindParam(":Code", $data['Code']);
        $sql->bindParam(":IDate", $data['IDate']);
        $sql->bindParam(":ITime", $data['ITime']);
        $sql->bindParam(":FDate", $data['FDate']);
        $sql->bindParam(":FTime", $data['FTime']);
        $sql->bindParam(":Quantity", $data['Quantity']);
        $sql->bindParam(":Total", $data['Total']);
        $sql->bindParam(":Payed", $data['Payed']);
        $sql->bindParam(":Status", $data['Status']);
        $sql->bindParam(":Observation", $data['Observation']);
        $sql->bindParam(":User", $data['User']);
        $sql->bindParam(":Customer", $data['Customer']);
        $sql->execute();

        return $sql;

    }

    /*--- ADD DETAIL MODEL ---*/
    protected static function add_detail_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO detalle(detalle_cantidad, detalle_formato, detalle_tiempo, detalle_costo_tiempo, detalle_descripcion, prestamo_codigo, item_id) VALUES (:Quantity, :Format, :Time, :Cost, :Description, :Code, :Product)");

        $sql->bindParam(":Quantity", $data['Quantity']);
        $sql->bindParam(":Format", $data['Format']);
        $sql->bindParam(":Time", $data['Time']);
        $sql->bindParam(":Cost", $data['Cost']);
        $sql->bindParam(":Description", $data['Description']);
        $sql->bindParam(":Code", $data['Code']);
        $sql->bindParam(":Product", $data['Product']);
        $sql->execute();

        return $sql;
    }

    /*--- ADD PAYMENT MODEL ---*/
    protected static function add_payment_model($data)
    {
        $sql = mainModel::connect()->prepare("INSERT INTO pago(pago_total, pago_fecha, prestamo_codigo) VALUES (:Total, :Date, :Code)");
        $sql->bindParam(":Total", $data['Total']);
        $sql->bindParam(":Date", $data['Date']);
        $sql->bindParam(":Code", $data['Code']);
        $sql->execute();

        return $sql;
    }

    /*--- DELETE LOAN MODEL ---*/
    protected static function delete_loan_model($code, $type)
    {
        if($type == "Loan"){
            $sql = mainModel::connect()->prepare("DELETE FROM prestamo WHERE prestamo_codigo=:Code");
        }elseif($type == "Detail"){
            $sql = mainModel::connect()->prepare("DELETE FROM detalle WHERE prestamo_codigo=:Code");
        }elseif($type == "Payment"){
            $sql = mainModel::connect()->prepare("DELETE FROM pago WHERE prestamo_codigo=:Code");
        }
        $sql->bindParam(":Code", $code);
        $sql->execute();

        return $sql;
    }

    /*--- DATA LOAN MODEL ---*/
    protected static function data_loan_model($type, $id)
    {
        if($type == "Unique"){
            $sql = mainModel::connect()->prepare("SELECT * FROM prestamo WHERE prestamo_id=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($type == "Count_Reservation"){
            $sql = mainModel::connect()->prepare("SELECT prestamo_id FROM prestamo WHERE prestamo_estado='Reservation'");
        }elseif($type == "Count_Loan"){
            $sql = mainModel::connect()->prepare("SELECT prestamo_id FROM prestamo WHERE prestamo_estado='Loan'");
        }elseif($type == "Count_Finished"){
            $sql = mainModel::connect()->prepare("SELECT prestamo_id FROM prestamo WHERE prestamo_estado='Finished'");
        }elseif($type == "Count"){
            $sql = mainModel::connect()->prepare("SELECT prestamo_id FROM prestamo");
        }elseif($type == "Detail"){
            $sql = mainModel::connect()->prepare("SELECT * FROM detalle WHERE prestamo_codigo=:Code");
            $sql->bindParam(":Code", $id);
        }elseif($type == "Payment"){
            $sql = mainModel::connect()->prepare("SELECT * FROM pago WHERE prestamo_codigo=:Code");
            $sql->bindParam(":Code", $id);
        }
        $sql->execute();
        return $sql;
    }

    /*--- UPDATE LOAN MODEL ---*/
    protected static function update_loan_model($data)
    {
        if($data['Type']=="Payment"){
            $sql = mainModel::connect()->prepare("UPDATE prestamo SET prestamo_pagado=:Amount WHERE prestamo_codigo=:Code");
            $sql->bindParam(":Amount", $data['Amount']);
        }elseif($data['Type']=="Loan"){
            $sql = mainModel::connect()->prepare("UPDATE prestamo SET prestamo_estado=:Status, prestamo_observacion=:Observation WHERE prestamo_codigo=:Code");
            $sql->bindParam(":Status", $data['Status']);
            $sql->bindParam(":Observation", $data['Observation']);
        }
        $sql->bindParam(":Code", $data['Code']);
        $sql->execute();
        return $sql;
    }

}