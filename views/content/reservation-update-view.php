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

    <div class="container-fluid form-neon">
        <div class="container-fluid">
            <p class="text-center"><strong>AGREGAR NUEVO PAGO A ESTE PRÉSTAMO</strong></p>
            <p class="text-center">Este préstamo presenta un pago pendiente por la cantidad de <strong>$50</strong>, puede agregar un pago a este préstamo haciendo clic en el siguiente botón.</p>
            <p class="text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPago"><i class="far fa-money-bill-alt"></i> &nbsp; Agregar pago</button>
            </p>
        </div>
        <div class="container-fluid">
            <div>
                <span class="roboto-medium">CLIENTE:</span>
                &nbsp; Carlos Alfaro
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
                    <tr class="text-center" >
                        <td>Silla plastica</td>
                        <td>7</td>
                        <td>Hora</td>
                        <td>$5.00</td>
                        <td>$35.00</td>
                    </tr>
                    <tr class="text-center" >
                        <td>Silla metalica</td>
                        <td>9</td>
                        <td>Día</td>
                        <td>$5.00</td>
                        <td>$45.00</td>
                    </tr>
                    <tr class="text-center" >
                        <td>Mesa plastica</td>
                        <td>5</td>
                        <td>Evento</td>
                        <td>$10.00</td>
                        <td>$50.00</td>
                    </tr>
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

    <!-- MODAL PAGOS -->
    <div class="modal fade" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="ModalPago" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content">
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
                            <tr class="text-center">
                                <td>Fecha</td>
                                <td>Monto</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="container-fluid">
                        <input type="hidden" name="pago_codigo_reg">
                        <div class="form-group">
                            <label for="pago_monto_reg" class="bmd-label-floating">Monto en $</label>
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
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
</div>