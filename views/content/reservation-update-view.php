<?php
if($_SESSION['privilege_loan'] < 1 || $_SESSION['privilege_loan'] > 2){
    echo $ins_logout->force_logout_controller();
    exit();
}
?>
<h2>Update Loan</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore doloremque error explicabo fuga in ipsa
    labore laborum libero minima molestiae</p>
<div class="buttons">
    <button
        class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>reservation-new/">New
        Loan</a></button>
    <button class="btn btn__cta"><i class="fas fa-business-time ic"></i><a href="<?php echo SERVER_URL;
    ?>reservation-pending/">Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;
    ?>reservation-list/">Payed Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-calendar ic"></i><a href="<?php echo SERVER_URL;
    ?>reservation-reservation/">Payed Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>reservation-search/">Search Loans</a></button>
</div>
<div class="container-fluid">
    <?php
    require_once "./controllers/loanController.php";
    $ins_loan = new loanController();
    $data_loan = $ins_loan->data_loan_controller("Unique", $page[1]);

    if($data_loan->rowCount() == 1){
    $fields = $data_loan->fetch();

    if($fields['prestamo_estado'] == "Finished" && $fields['prestamo_pagado'] == $fields['prestamo_total']){
    ?>
        <div class="alert alert-danger text-center" role="alert">
          <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
          <h4 class="alert-heading">Wait a minute!</h4>
          <p class="mb-0">You can't update this loan because it has already been paid</p>
        </div>
    <?php }else{ ?>
    <div class="container-fluid form-neon">

      <?php if($fields['prestamo_pagado'] != $fields['prestamo_total']){ ?>
        <div class="container-fluid">
            <p class="text-center"><strong>AGREGAR NUEVO PAGO A ESTE PRÉSTAMO</strong></p>
            <p class="text-center">Este préstamo presenta un pago pendiente por la cantidad de <strong><?php echo
                        CURRENCY.number_format(($fields['prestamo_total'] - $fields['prestamo_pagado']), 2, '.', '') ?>
            </strong>, puede agregar un pago a este préstamo haciendo clic en el siguiente botón.</p>
            <p class="text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPago"><i class="far fa-money-bill-alt"></i> &nbsp; Agregar pago</button>
            </p>
        </div>
      <?php } ?>


        <div class="container-fluid">
            <?php
            require_once "./controllers/customerController.php";
            $ins_customer = new customerController();
            $data_customer = $ins_customer->data_customer_controller("Unique", $ins_logout->encryption
            ($fields['cliente_id']));
            $data_customer = $data_customer->fetch();
            ?>
            <div>
                <span class="roboto-medium">CLIENTE:</span>
                &nbsp; <?php echo $data_customer['cliente_nombre']." ".$data_customer['cliente_apellido']; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-light table-sm">
                    <thead>
                    <tr class="text-center roboto-medium">
                        <th>ITEM</th>
                        <th>CANTIDAD</th>
                        <th>TIEMPO</th>
                        <th>COSTO</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $data_detail = $ins_loan->data_loan_controller("Detail", $ins_logout->encryption
                    ($fields['prestamo_codigo']));
                    $data_detail = $data_detail->fetchAll();
                    foreach($data_detail as $det){
                      $subtotal = $det['detalle_cantidad']*($det['detalle_costo_tiempo'] * $det['detalle_tiempo']);
                      $subtotal = number_format($subtotal, 2, '.', '');
                    ?>
                    <tr class="text-center" >
                        <td><?php echo $det['detalle_descripcion']; ?></td>
                        <td><?php echo $det['detalle_cantidad']; ?></td>
                        <td><?php echo $det['detalle_tiempo']." ".$det['detalle_formato']; ?></td>
                        <td><?php echo CURRENCY.$det['detalle_costo_tiempo']." x 1 ".$det['detalle_formato']; ?></td>
                        <td><?php echo CURRENCY.$subtotal; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-clock"></i> &nbsp; Fecha y hora de préstamo</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_fecha_inicio">Fecha de préstamo</label>
                                <input type="date" class="form-control" readonly="" id="prestamo_fecha_inicio">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_hora_inicio">Hora de préstamo</label>
                                <input type="text" class="form-control" readonly="" id="prestamo_hora_inicio">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-history"></i> &nbsp; Fecha y hora de entrega</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_fecha_final">Fecha de entrega</label>
                                <input type="date" class="form-control" readonly="" id="prestamo_fecha_final">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_hora_final">Hora de entrega</label>
                                <input type="text" class="form-control" readonly="" id="prestamo_hora_final">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-cubes"></i> &nbsp; Otros datos</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_estado" class="bmd-label-floating">*** Estado ***</label>
                                <select class="form-control" name="prestamo_estado_up" id="prestamo_estado">
                                    <option value="Reservacion">Reservación</option>
                                    <option value="Prestamo">Préstamo</option>
                                    <option value="Finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_total" class="bmd-label-floating">Total a pagar en $</label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="100.00" id="prestamo_total" maxlength="10">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_pagado" class="bmd-label-floating">Total depositado en $</label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="100.00" id="prestamo_pagado" maxlength="10">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="prestamo_observacion" class="bmd-label-floating">*** Observación ***</label>
                                <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="prestamo_observacion_up" id="prestamo_observacion" maxlength="400">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
            </p>
        </form>
    </div>



    <!-- MODAL PAYMENTS -->
    <div class="modal fade" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="ModalPago" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="Ajax_Form modal-content" action="<?php echo SERVER_URL; ?>ajax/loanAjax.php" method="post" data-form="save"
                  autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPago">Agregar pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" >
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                            <tr class="text-center bg-dark">
                                <th>FECHA</th>
                                <th>MONTO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $data_payment = $ins_loan->data_loan_controller("Payment", $ins_logout->encryption
                            ($fields['prestamo_codigo']));

                            if($data_payment->rowCount() > 0){
                                $data_payment = $data_payment->fetchAll();
                                foreach($data_payment as $rows){
                                    echo '
                                    <tr class="text-center">
                                        <td>'.date("d-m-Y", strtotime($rows['pago_fecha'])).'</td>
                                        <td>'.CURRENCY.$rows['pago_total'].'</td>
                                    </tr>
                                    ';
                                }
                            }else{
                            ?>
                            <tr class="text-center">
                                <td colspan="2">No payments registered</td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="container-fluid">
                        <input type="hidden" name="pago_codigo_reg" value="<?php $ins_logout->encryption
                        ($fields['prestamo_codigo']); ?>">
                        <div class="form-group">
                            <label for="pago_monto_reg" class="bmd-label-floating">Monto en <?php echo CURRENCY;
                            ?></label>
                            <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="pago_monto_reg" id="pago_monto_reg" maxlength="10" required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-info btn-sm" >Agregar pago</button> &nbsp;&nbsp;
                    <button type="button" class="btn btn-raised btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
        }
    }else{
      ?>
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
    <?php } ?>


</div>