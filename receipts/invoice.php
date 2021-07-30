<?php
    $ajaxRequest = true;

    require_once "../config/APP.php";

    /* receiving id */
    $id = (isset($_GET['id'])) ? $_GET['id'] : 0 ;

    /* new instance to loan controller */
    require_once "../controllers/loanController.php";
    $ins_loan = new loanController();
    /* getting data */
    $data_loan = $ins_loan->data_loan_controller("Unique", $id);

    if($data_loan->rowCount() == 1) {
        $data_loan = $data_loan->fetch();

        /* new instance to company controller */
        require_once "../controllers/companyController.php";
        $ins_company = new companyController();
        $data_company = $ins_company->company_data_controller();
        $data_company = $data_company->fetch();

        /* new instance to user controller */
        require_once "../controllers/userController.php";
        $ins_user = new userController();
        $data_user = $ins_user->data_user_controller("Unique", $ins_user->encryption($data_loan['usuario_id']));
        $data_user = $data_user->fetch();

        /* new instance to customer controller */
        require_once "../controllers/customerController.php";
        $ins_customer = new customerController();
        $data_customer = $ins_customer->data_customer_controller("Unique", $ins_customer->encryption
        ($data_loan['cliente_id']));
        $data_customer = $data_customer->fetch();

        require "./fpdf.php";

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->SetMargins(17, 17, 17);
        $pdf->AddPage();
        $pdf->Image('../views/img/logo.png', 10, 18, 40, 15, 'PNG');

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(139, 118, 52);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($data_company['empresa_nombre'])), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(139, 118, 52);
        $pdf->Cell(-35, 10, utf8_decode('Receipt No.'), '', 0, 'C');

        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTextColor(0, 107, 181);
        $pdf->Cell(0, 10, utf8_decode(""), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(-35, 10, utf8_decode($data_loan['prestamo_id']), '', 0, 'C');

        $pdf->Ln(25);

        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(12, 8, utf8_decode('Date:'), 0, 0);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(27, 8, utf8_decode(date("d/m/Y", strtotime($data_loan['prestamo_fecha_inicio']))), 0, 0);
        $pdf->Ln(8);
        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(17, 8, utf8_decode('Sold by:'), "", 0, 0);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(13, 8, utf8_decode($data_user['usuario_nombre']." ".$data_user['usuario_apellido']), 0, 0);

        $pdf->Ln(15);

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(21, 8, utf8_decode('Customer:'), 0, 0);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(60, 8, utf8_decode($data_customer['cliente_nombre']." ".$data_customer['cliente_apellido']), 0, 0);
        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(7, 8, utf8_decode('ID:'), 0, 0);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(40, 8, utf8_decode($data_customer['cliente_dni']), 0, 0);
        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(14, 8, utf8_decode('Phone:'), 0, 0);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(35, 8, utf8_decode($data_customer['cliente_telefono']), 0, 0);
        $pdf->SetTextColor(33, 33, 33);

        $pdf->Ln(8);

        $pdf->Cell(18, 8, utf8_decode('Address:'), 0, 0);
        $pdf->SetTextColor(97, 97, 97);
        $pdf->Cell(109, 8, utf8_decode($data_customer['cliente_direccion']), 0, 0);

        $pdf->Ln(15);

        $pdf->SetFillColor(51, 51, 51);
        $pdf->SetDrawColor(51, 51, 51);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 10, utf8_decode('Qty.'), 1, 0, 'C', true);
        $pdf->Cell(90, 10, utf8_decode('Description'), 1, 0, 'C', true);
        $pdf->Cell(51, 10, utf8_decode('Time - Cost'), 1, 0, 'C', true);
        $pdf->Cell(25, 10, utf8_decode('Subtotal'), 1, 0, 'C', true);

        $pdf->Ln(10);

        $pdf->SetTextColor(97, 97, 97);

        //loan details
        $data_detail = $ins_loan->data_loan_controller("Detail", $ins_loan->encryption($data_loan['prestamo_codigo']));
        $data_detail = $data_detail->fetchAll();

        $total = 0;

        foreach($data_detail as $items) {
            $subtotal = $items['detalle_cantidad']*($items['detalle_costo_tiempo'] * $items['detalle_tiempo']);
            $subtotal = number_format($subtotal, 2, '.', '');

            $pdf->Cell(15, 10, utf8_decode($items['detalle_cantidad']), 'L', 0, 'C');
            $pdf->Cell(90, 10, utf8_decode($items['detalle_descripcion']), 'L', 0, 'C');
            $pdf->Cell(51, 10, utf8_decode($items['detalle_tiempo']." ".$items['detalle_formato']." (".CURRENCY
                .$items['detalle_costo_tiempo']." ea.)"),'L',0, 'C');
            $pdf->Cell(25, 10, utf8_decode(CURRENCY.$subtotal), 'LR', 0, 'C');

            $pdf->Ln(10);

            $total += $subtotal;
        }

        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(15, 10, utf8_decode(''), 'T', 0, 'C');
        $pdf->Cell(90, 10, utf8_decode(''), 'T', 0, 'C');
        $pdf->Cell(51, 10, utf8_decode('TOTAL'), 'LTB', 0, 'C');
        $pdf->Cell(25, 10, utf8_decode(CURRENCY.number_format($total, 2, '.', '')), 'LRTB', 0, 'C');

        $pdf->Ln(15);

        $pdf->MultiCell(0, 9, utf8_decode("OBSERVATION: ".$data_loan['prestamo_observacion']), 0, 'J', false);

        $pdf->SetFont('Arial', '', 12);
        if ($data_loan['prestamo_pagado'] < $data_loan['prestamo_total']) {
            $pdf->Ln(12);

            $pdf->SetTextColor(97, 97, 97);
            $pdf->MultiCell(0, 9, utf8_decode("IMPORTANT NOTE: \nEsta factura presenta un saldo pendiente de pago por la cantidad de ".CURRENCY.number_format(($data_loan['prestamo_total'] - $data_loan['prestamo_pagado']), 2, '.','')), 0, 'J', false);
        }

        $pdf->Ln(25);

        /*----------  INFO. EMPRESA  ----------*/
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(33, 33, 33);
        $pdf->Cell(0, 6, utf8_decode($data_company['empresa_nombre']), 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 6, utf8_decode($data_company['empresa_direccion']), 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(0, 6, utf8_decode("Phone: ".$data_company['empresa_telefono']), 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(0, 6, utf8_decode("Email: ".$data_company['empresa_email']), 0, 0, 'C');


        $pdf->Output("I", "Receipt_".$data_loan['prestamo_id'].".pdf", true);
    }else{
?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <?php include "../views/inc/links.php";?>
            <title><?php echo COMPANY_NAME;?>></title>
        </head>
        <body>
            <div class="container">
                <p class="text-center page__404"><i class="fas fa-search fa-10x"></i></p>
                <h1 class="text-center">Something went wrong!</h1>
                <p class="lead text-center">We couldn't find the selected loan</p>
            </div>

        <?php include "../views/inc/scripts.php";?>
        </body>
        </html>

    <?php }