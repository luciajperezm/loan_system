<?php
if($_SESSION['privilege_loan'] < 1 || $_SESSION['privilege_loan'] > 2){
    echo $ins_logout->force_logout_controller();
    exit();
}
?>
<h2>Update Loan</h2>
<p>Here you can update the information of the ongoing leases or reservations. Please make sure that the information you introduce is correct</p>
<div class="buttons">
  <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>reservation-new/">New Lease</a></button>
  <button class="btn btn__cta"><i class="fas fa-business-time ic"></i><a href="<?php echo SERVER_URL;?>reservation-pending/">Active Leases</a></button>
  <button class="btn btn__cta"><i class="fas fa-calendar ic"></i><a href="<?php echo SERVER_URL;?>reservation-reservation/">Reservations</a></button>
  <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>reservation-search/">Search Lease</a></button>
  <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>reservation-list/">Payed Leases</a></button>
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
          <p class="mb-0">You can't update this transaction because it has already been paid</p>
        </div>
    <?php }else{ ?>
    <div class="container-fluid form-neon">
        <?php if($fields['prestamo_pagado'] != $fields['prestamo_total']){ ?>
            <div class="container-fluid">
                <p class="text-center"><strong>ADD NEW PAYMENT</strong></p>
                <p class="text-center">This loan has a pending payment of <strong><?php echo CURRENCY.number_format(
                    ($fields['prestamo_total'] - $fields['prestamo_pagado']), 2, '.', '');?></strong>, you may add a new payment clicking on the following button.</p>
                <p class="text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPago"><i class="far fa-money-bill-alt"></i> &nbsp; Add payment</button>
                </p>
            </div>
        <?php } ?>
        <div class="container-fluid">
            <?php
            require_once "./controllers/customerController.php";
            $ins_customer = new customerController();
            $data_customer = $ins_customer->data_customer_controller("Unique", $ins_logout->encryption($fields['cliente_id']));
            $data_customer = $data_customer->fetch();
            ?>
            <div>
                <span class="roboto-medium">CUSTOMER:</span>
                &nbsp; <?php echo $data_customer['cliente_nombre']." ".$data_customer['cliente_apellido']; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-light table-sm">
                    <thead>
                    <tr class="text-center roboto-medium">
                        <th>ITEM</th>
                        <th>QUANTITY</th>
                        <th>TIME</th>
                        <th>COST</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $data_detail = $ins_loan->data_loan_controller("Detail", $ins_logout->encryption($fields['prestamo_codigo']));
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
        <form class="Ajax_Form" action="<?php echo SERVER_URL; ?>ajax/loanAjax.php" method="post" data-form="update" autocomplete="off">
            <input type="hidden" name="loan_code_up" value="<?php echo $ins_logout->encryption($fields['prestamo_codigo']); ?>">
            <fieldset>
                <legend><i class="far fa-clock"></i> &nbsp; Date and Time</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="loan_date_init">Lease Date</label>
                                <input type="date" class="form-control" readonly="" name="loan_date_init_up" id="loan_date_init" value="<?php echo $fields['prestamo_fecha_inicio']; ?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="loan_time_init">Lease Time</label>
                                <input type="text" class="form-control" readonly="" name="loan_time_init_up" id="loan_time_init" value="<?php echo $fields['prestamo_hora_inicio']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-history"></i> &nbsp; Lease completion</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="loan_date_final_up">Return Date</label>
                                <input type="date" class="form-control" readonly="" name="loan_date_final_up" id="loan_date_final_up" value="<?php echo $fields['prestamo_fecha_final']; ?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="loan_time_final_up">Return Time</label>
                                <input type="text" class="form-control" readonly="" name="loan_time_final_up" id="loan_time_final_up" value="<?php echo $fields['prestamo_hora_final']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-cubes"></i> &nbsp; Other Info</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="loan_status" class="bmd-label-floating">Status</label>
                                <select class="form-control" name="loan_status_up" id="loan_status">
                                    <option value="Reservation" <?php if($fields['prestamo_estado'] == "Reservation"){ echo 'selected=""';}?>>Reservation</option>
                                    <option value="Loan" <?php if($fields['prestamo_estado'] == "Loan"){ echo 'selected=""';}?>>Active Loan</option>
                                    <option value="Finished" <?php if($fields['prestamo_estado'] == "Finished")
                                    { echo 'selected=""';}?>>Payed Loan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="loan_total_up" class="bmd-label-floating">Total owed in <?php echo CURRENCY;?></label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" id="loan_total_up" name="loan_total_up" maxlength="10" value="<?php echo $fields['prestamo_total']; ?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="loan_payed_up" class="bmd-label-floating">Total payed in <?php echo CURRENCY;?></label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="<?php echo $fields['prestamo_pagado']; ?>" id="loan_payed_up" name="loan_payed_up" maxlength="10">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="loan_observation" class="bmd-label-floating">Observation</label>
                                <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="loan_observation_up" id="loan_observation" maxlength="400" value="<?php echo $fields['prestamo_observacion']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; UPDATE</button>
            </p>
        </form>
    </div>

    <!-- MODAL PAYMENTS -->
    <div class="modal fade" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="ModalPago" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="Ajax_Form modal-content" action="<?php echo SERVER_URL; ?>ajax/loanAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPago">Add Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" >
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                            <tr class="text-center bg-dark">
                                <th>DATE</th>
                                <th>AMOUNT</th>
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
                        <input type="hidden" name="payment_code_reg" value="<?php echo $ins_logout->encryption
                        ($fields['prestamo_codigo']); ?>">
                        <div class="form-group">
                            <label for="payment_amount_reg" class="bmd-label-floating">Amount in <?php echo CURRENCY;
                            ?></label>
                            <input type="number" pattern="[0-9.]{1,10}" class="form-control" name="payment_amount_reg" id="payment_amount_reg" maxlength="10" required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-info btn-sm" >Add Payment</button> &nbsp;&nbsp;
                    <button type="button" class="btn btn-raised btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
        <h4 class="alert-heading">Something went wrong!</h4>
        <p class="mb-0">Sorry, we couldn't update this transaction due to an error.</p>
    </div>
    <?php } ?>
</div>