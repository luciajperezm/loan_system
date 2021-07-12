<?php
if($ins_logout->encryption($_SESSION['id_loan']) != $page[1]){
    if($_SESSION['privilege_loan'] != 1){
      echo $ins_logout->force_logout_controller();
      exit();
    }
}
?>
<h2>Update User</h2>
<p>Here you can update the selected profile, make sure the changes you make are correct. </p>
<?php if($_SESSION['privilege_loan'] == 1){ ?>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>user-list/">List of Users</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>user-search/">Search Users</a></button>
</div>
<?php } ?>
<?php
require_once "./controllers/userController.php";
  $ins_user = new userController();
  $data_user = $ins_user->data_user_controller("Unique", $page[1]);

  if($data_user->rowCount() == 1){
    $fields = $data_user->fetch();
?>
<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/userAjax.php" method="post" data-form="update" autocomplete="off">
    <input type="hidden" name="user_id_up" value="<?php echo $page[1];?>">
        <fieldset>
            <legend><i class="fas fa-id-card-alt ic"></i> &nbsp; User Information</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="user_dni" class="bmd-label-floating">DNI </label>
                            <input type="text" pattern="[0-9-]{1,20}" class="form-control" name="user_dni_up"
                                   id="user_dni" maxlength="20" value="<?php echo
                            $fields['usuario_dni']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="user_firstname" class="bmd-label-floating">First Name </label>
                            <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="user_firstname_up"
                                   id="user_firstname" maxlength="45" value="<?php echo
                            $fields['usuario_nombre']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="user_lastname" class="bmd-label-floating">Last Name </label>
                            <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="user_lastname_up"
                                   id="user_lastname" maxlength="45" value="<?php echo
                            $fields['usuario_apellido']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="user_phone" class="bmd-label-floating">Phone</label>
                            <input type="text" pattern="[0-9+-]{1,15}" class="form-control" name="user_phone_up"
                                   id="user_phone" maxlength="15" value="<?php echo
                            $fields['usuario_telefono']; ?>">
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="form-group">
                            <label for="user_address" class="bmd-label-floating">Address</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control"
                                   name="user_address_up" id="user_address" maxlength="150" value="<?php echo
                            $fields['usuario_direccion']; ?>">
                        </div>
                    </div>
                </div>
            </div>
    </fieldset><br><br><br>
    <fieldset>
        <legend><i class="fas fa-user-lock ic"></i> &nbsp; User Account</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_username" class="bmd-label-floating">Username</label>
                        <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="user_username_up"
                               id="user_username" maxlength="35" value="<?php echo
                        $fields['usuario_usuario']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_email" class="bmd-label-floating">Email</label>
                        <input type="email" class="form-control" name="user_email_up" id="user_email" maxlength="70"
                               value="<?php echo
                        $fields['usuario_email']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_password_1" class="bmd-label-floating">Password</label>
                        <input type="password" class="form-control" name="user_password_1_up" id="user_password_1"
                               pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_password_2" class="bmd-label-floating">Repeat Password</label>
                        <input type="password" class="form-control" name="user_password_2_up" id="user_password_2"
                               pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                    </div>
                </div>
                <?php  if($_SESSION['privilege_loan'] == 1 && $fields['usuario_id'] != 1){ ?>
                <div class="col-12 ">
                    <div class="form-group">
                        <span>Account status &nbsp;  <?php
                            if($fields['usuario_estado'] == "Active"){ echo'<span class="badge badge-info">Active</span>';
                            }else { echo '<span class="badge badge-danger">Inactive</span>';}
                            ?></span>
                        <select class="form-control" name="user_status_up">
                            <option value="Active" <?php if($fields['usuario_estado'] == "Active"){ echo 'selected=""'; } ?>>Active</option>
                            <option value="Inactive" <?php if($fields['usuario_estado'] == "Inactive"){ echo 'selected=""';} ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </fieldset>
    <?php if($_SESSION['privilege_loan'] == 1 && $fields['usuario_id'] != 1){ ?>
  <br><br><br>
      <fieldset>
          <legend><i class="fas fa-medal ic"></i> &nbsp; User Roles</legend>
              <div class="container-fluid">
                  <div class="row">
                  <div class="col-12">
                      <p><span class="badge badge-warning">Full Control</span> This user can Register, Update and Delete information</p>
                      <p><span class="badge badge-success">Edit</span> This user can Register and Update information</p>
                      <p><span class="badge badge-dark">Register</span> This user can only Register information</p>
                      <div class="form-group">
                          <select class="form-control" name="user_privilege_up">
                              <option value="1" <?php if($fields['usuario_privilegio'] == 1){ echo 'selected=""';}?>>Full Control <?php if($fields['usuario_privilegio'] == 1){ echo '(Current)';} ?></option>
                              <option value="2" <?php if($fields['usuario_privilegio'] == 2){ echo 'selected=""';}?>>Edit <?php if($fields['usuario_privilegio'] == 2){ echo '(Current)';} ?></option>
                              <option value="3" <?php if($fields['usuario_privilegio'] == 3){ echo 'selected=""';}?>>Register <?php if($fields['usuario_privilegio'] == 3){ echo '(Current)';} ?></option>
                          </select>
                      </div>
                  </div>
              </div>
          </div>
      </fieldset>
      <?php } ?>
    <br><br><br>
  <fieldset>
      <p class="text-center">Please enter your username and password to save the changes made</p>
      <div class="container-fluid">
          <div class="row">
              <div class="col-12 col-md-6">
                  <div class="form-group">
                      <label for="user_admin" class="bmd-label-floating">Username</label>
                      <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="user_admin" id="user_admin" maxlength="35" required="" >
                  </div>
              </div>
              <div class="col-12 col-md-6">
                  <div class="form-group">
                      <label for="admin_password" class="bmd-label-floating">Password</label>
                      <input type="password" class="form-control" name="admin_password" id="admin_password" pattern="[a-zA-Z0-9$@-]{7,100}" maxlength="100" required="" >
                  </div>
              </div>
        </div>
    </div>
  </fieldset>
  <?php if($ins_logout->encryption($_SESSION['id_loan']) != $page[1]){ ?>
      <input type="hidden" name="account_type" value="someone_else">
      <?php }else{ ?>
      <input type="hidden" name="account_type" value="own_account">
  <?php } ?>
      <p class="text-center" style="margin-top: 40px;">
          <button type="reset" class="btn btn-raised btn-secondary "><i class="fas fa-paint-roller"></i> &nbsp; CLEAR</button>
          &nbsp; &nbsp;
          <button type="submit" class="btn btn-raised btn-success "><i class="far fa-save"></i> &nbsp; SAVE</button>
      </p>
</form>
<?php }else{ ?>
<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">Something went Wrong!</h4>
    <p class="mb-0">Sorry, we are unable to show the requested information.</p>
</div>
<?php } ?>