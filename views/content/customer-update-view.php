<?php
    if($_SESSION['privilege_loan'] < 1 || $_SESSION['privilege_loan'] > 2){
        echo $ins_logout->force_logout_controller();
        exit();
    }
?>
<h2>Update Customer</h2>
<p>Here you can update upistered Customers. Make sure the information you introduce is correct. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>customer-list/">List of Customer</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>customer-search/">Search
        Customers</a></button>
</div>
<?php
require_once "./controllers/customerController.php";
$ins_customer = new customerController();
$data_customer = $ins_customer->data_customer_controller("Unique", $page[1]);

if($data_customer->rowCount() == 1){
$fields = $data_customer->fetch();
?>
<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/customerAjax.php" method="post"
      data-form="update" autocomplete="off">
  <input type="hidden" name="customer_id_up" value="<?php echo $page[1];?>">
    <fieldset>
        <legend><i class="fas fa-users ic"></i> &nbsp; Customer Information</legend>
        <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="customer_dni" class="bmd-label-floating">DNI</label>
                  <input type="text" pattern="[0-9-]{1,20}" class="form-control"
                         name="customer_dni_up" id="customer_dni" maxlength="20" value="<?php echo
                  $fields['cliente_dni']; ?>">
                </div>
              </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="customer_name" class="bmd-label-floating">First Name</label>
                        <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control"
                               name="customer_name_up" id="customer_name" maxlength="45" value="<?php echo
                        $fields['cliente_nombre']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="customer_last_name" class="bmd-label-floating">Last Name</label>
                        <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control"
                               name="customer_last_name_up"
                               id="customer_last_name" maxlength="45" value="<?php echo
                        $fields['cliente_apellido']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="customer_phone" class="bmd-label-floating">Phone</label>
                        <input type="text" pattern="[0-9+-]{1,15}" class="form-control" name="customer_phone_up"
                               id="customer_phone" maxlength="20" value="<?php echo
                        $fields['cliente_telefono']; ?>">
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-group">
                        <label for="customer_address" class="bmd-label-floating">Address</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control"
                               name="customer_address_up" id="customer_address" maxlength="150" value="<?php echo
                        $fields['cliente_direccion']; ?>">
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

<?php }else{ ?>
<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">Something Went Wrong!</h4>
    <p class="mb-0">Sorry, we couldn't update the Customer due to an error.</p>
</div>
<?php } ?>