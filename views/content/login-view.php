<div class="login-cont">
  <div class="container">
    <div class="row row__login justify-content-center">
      <div class="col-md-4 column align-items-center">
        <h2 class=" title-left">Lease Management System</h2>
        <p class="login__info title-left">Keep track of your Leases and take control of your business</p>
      </div>
      <div class="col-md-4 column">
        <h1 class="login__header">Welcome!</h1>
        <form class="" action="" method="post" autocomplete="off">
          <div class="form-group">
            <label for="username_log" class="login__label"><i class="fa fa-user" aria-hidden="true"></i>                      Username:</label>
            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control login__input" id="username_log" name="username_log" maxlength="35">
          </div>
          <div class="form-group">
            <label for="password_log" class="login__label"><i class="fa fa-key" aria-hidden="true"></i> Password:</label>
            <input type="password" pattern="[a-zA-Z0-9@.-]{7,100}" class="form-control login__input" name="password_log" id="password_log" maxlength="100">
          </div>
          <button class="button" type="submit">Log in</button>
          <p class="login__demo"><small>Try a Demo user</small></p>
          <div class="demo"><strong>
              <p>Username: admin</p>
              <p>Password: demouser</p></strong>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_POST['username_log']) && isset($_POST['password_log'])){
    require_once "./controllers/loginController.php";
    $ins_login = new loginController();
    $ins_login->login_controller();
}
?>