<h2>New Customer</h2>
<p>Here you can add Customers to the system. This information is required if you want to transfer products between the company's warehouses. Make sure the information you introduce is correct. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>customer-list/">List of Customer</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>customer-search/">Search
        Customers</a></button>
</div>

<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/customerAjax.php" method="post"
      data-form="save" autocomplete="off">
    <fieldset>
        <legend><i class="fas fa-users ic"></i> &nbsp; Customer Information</legend>
        <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="customer_dni" class="bmd-label-floating"> DNI</label>
                  <input type="text" pattern="[0-9-]{1,20}" class="form-control"
                         name="customer_dni_reg" id="customer_dni" maxlength="20">
                </div>
              </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="customer_name" class="bmd-label-floating">First Name</label>
                        <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control"
                               name="customer_name_reg" id="customer_name" maxlength="40">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="customer_lastname" class="bmd-label-floating">Last Name</label>
                        <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control"
                               name="customer_lastname_reg" id="customer_lastname" maxlength="40">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="customer_phone" class="bmd-label-floating">Phone</label>
                        <input type="text" pattern="[0-9+-]{1,15}" class="form-control" name="customer_phone_reg"
                               id="customer_phone" maxlength="15">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="customer_address" class="bmd-label-floating">Address</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control"
                               name="customer_address_reg" id="customer_address" maxlength="150">
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
</form>
