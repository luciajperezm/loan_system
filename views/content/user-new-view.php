<?php
if($_SESSION['privilege_loan'] != 1){
    echo $ins_logout->force_logout_controller();
    exit();
}
?>
<h2>New User</h2>
<p>Here you can add Users to the system. Make sure the information you introduce is correct. </p>
<div class="buttons">
  <button class="btn btn__cta active"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>user-new/">New User</a></button>
  <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>user-list/">List of Users</a></button>
  <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>user-search/">Search Users</a></button>
</div>

<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/userAjax.php" method="post" data-form="save"
      autocomplete="off">
    <fieldset>
        <legend><i class="fas fa-id-card-alt ic"></i> &nbsp; User Information</legend>
        <div class="container-fluid">
            <div class="row">
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="user_dni" class="bmd-label-floating">DNI: </label>
                          <input type="text" pattern="[0-9-]{1,20}" class="form-control" name="user_dni_reg" id="user_dni" maxlength="45">
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="user_firstname" class="bmd-label-floating">First Name: </label>
                          <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="user_firstname_reg" id="user_firstname" maxlength="45">
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="user_lastname" class="bmd-label-floating">Last Name: </label>
                          <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="user_lastname_reg" id="user_lastname" maxlength="45">
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="user_phone" class="bmd-label-floating">Phone:</label>
                          <input type="text" pattern="[0-9+-]{1,15}" class="form-control" name="user_phone_reg"
                                 id="user_phone" maxlength="15">
                      </div>
                  </div>
                  <div class="col-12 ">
                      <div class="form-group">
                          <label for="user_address" class="bmd-label-floating">Address:</label>
                          <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="user_address_reg" id="user_address" maxlength="150">
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
                        <label for="user_username" class="bmd-label-floating">Username:</label>
                        <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="user_username_reg" id="user_username" maxlength="35" >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_email" class="bmd-label-floating">Email:</label>
                        <input type="email" class="form-control" name="user_email_reg" id="user_email" maxlength="70">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_password_1" class="bmd-label-floating">Password:</label>
                        <input type="password" class="form-control" name="user_password_1_reg" id="user_password_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="user_password_2" class="bmd-label-floating">Repeat Password:</label>
                        <input type="password" class="form-control" name="user_password_2_reg" id="user_password_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                    </div>
                </div>
            </div>
        </div>
    </fieldset><br><br><br>
    <fieldset>
        <legend><i class="fas fa-medal ic"></i> &nbsp; User Roles</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <p><span class="badge badge-warning">Full Control</span> This user can Register, Update and Delete information</p>
                    <p><span class="badge badge-success">Edit</span> This user can Register and Update information</p>
                    <p><span class="badge badge-dark">Register</span> This user can only Register information</p>
                    <div class="form-group">
                        <select class="form-control" name="user_privilege_reg">
                            <option value="" selected="" disabled="">Choose an option</option>
                            <option value="1">Full Control</option>
                            <option value="2">Edit</option>
                            <option value="3">Register</option>
                        </select>
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