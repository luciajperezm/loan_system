<h2>Company</h2>
<p>Here you can introduce information about the company. This data will be used to generate reports. Make sure the information is correct. </p> <br>
<?php
  require_once "./controllers/companyController.php";
  $ins_company = new companyController();

  $data_company = $ins_company->company_data_controller();
  if($data_company->rowCount() == 0){
?>
    <form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/companyAjax.php" method="post"
          data-form="save" autocomplete="off">
      <fieldset>
        <legend><i class="fas fa-store ic"></i> &nbsp; Company Information</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_name" class="bmd-label-floating">Company Name:</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="company_name_reg" id="company_name" maxlength="70">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_email" class="bmd-label-floating">Email:</label>
                        <input type="email" class="form-control" name="company_email_reg" id="company_email" maxlength="70">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_phone" class="bmd-label-floating">Phone:</label>
                        <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="company_phone_reg" id="company_phone" maxlength="20">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_address" class="bmd-label-floating">Address:</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="company_address_reg" id="company_address" maxlength="190">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="reset" class="btn btn-raised btn-secondary "><i class="fas fa-paint-roller"></i> &nbsp; CLEAR</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-success "><i class="far fa-save"></i> &nbsp; SAVE</button>
    </p>
</form><br>
<?php }elseif($data_company->rowCount() == 1 && (($_SESSION['privilege_loan'] == 1 || $_SESSION['privilege_loan'] == 2))
){
    $fields = $data_company->fetch();
    ?>
<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/companyAjax.php" method="post"
       data-form="update" autocomplete="off">
      <input type="hidden" name="company_id_up" value="<?php echo $fields['empresa_id']; ?>">
      <fieldset>
        <legend><i class="fas fa-store ic"></i> &nbsp; Update Company Information</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_name" class="bmd-label-floating">Company Name:</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control"
                               name="company_name_up" id="company_name" maxlength="70" value="<?php echo
                        $fields['empresa_nombre']; ?>">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_email" class="bmd-label-floating">Email:</label>
                        <input type="email" class="form-control" name="company_email_up" id="company_email"
                               maxlength="70" value="<?php echo $fields['empresa_email']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_phone" class="bmd-label-floating">Phone:</label>
                        <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="company_phone_up"
                               id="company_phone" maxlength="20" value="<?php echo $fields['empresa_telefono']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="company_address" class="bmd-label-floating">Address:</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control"
                               name="company_address_up" id="company_address" maxlength="190" value="<?php echo
                        $fields['empresa_direccion']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; UPDATE</button>
    </p>
</form><br>
<?php }else{ ?>
<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">Something went Wrong!</h4>
    <p class="mb-0">Sorry, we are unable to show the requested information.</p>
</div>
<?php } ?>