<div class="container">
    <div class="row row__login justify-content-center">
        <div class="col-md-4 column align-items-center">
            <h1 class=" title-left">Inventory System</h1>
            <p class="login__info title-left">Keep track of your products and take control of your warehouse</p>
        </div>
        <div class="col-md-4 column">
            <h1 class="login__header">Welcome!</h1>
            <form class="" action="" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="username_log" class="login__label"><i class="fa fa-user" aria-hidden="true"></i>
                      Username:</label>
                    <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control login__input" id="username_log"
                           name="username_log" maxlength="35">
                </div>
                <div class="form-group">
                    <label for="password_log" class="login__label"><i class="fa fa-key" aria-hidden="true"></i>
                      Password:</label>
                    <input type="password" pattern="[a-zA-Z0-9@.-]{7,100}" class="form-control login__input"
                           name="password_log" id="password_log" maxlength="100">
                </div>
                <button class="button" type="submit">Sign in</button>
                <p class="login__demo"><small>Try a Demo user</small></p>
                <div class="demo">
                    <button class="button">Admin</button>
                    <button class="button">Manager</button>
                    <button class="button">Seller</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if(isset($_POST['username_log']) && isset($_POST['password_log'])){
    require_once "./controllers/loginController.php";
    $ins_login = new loginController();

    echo $ins_login->login_controller();
}
?>