<header class="hero">
    <h2 class="welcome">Welcome <?php echo $_SESSION['name_loan'];?>!</h2><br><br><br><br><br>
    <div class="hero-footer">
        <div class="date">Today is 17/04/21</div>
    </div>
</header><br><br>
<div class="home-cont">
  <div class="full-box tile-container">
      <?php
      require_once "./controllers/customerController.php";
      $ins_customer = new customerController();
      $reg_customers = $ins_customer->data_customer_controller("Count",0)
      ?>
    <a href="<?php echo SERVER_URL; ?>customer-search/" class="tile">
      <div class="tile-tittle">Clientes</div>
      <div class="tile-icon">
        <i class="fas fa-users fa-fw"></i>
        <p><?php echo $reg_customers->rowCount();?> Registered</p>
      </div>
    </a>

      <?php
      if($_SESSION['privilege_loan'] == 1){
      require_once "./controllers/productController.php";
      $ins_product = new productController();
      $reg_products = $ins_product->data_product_controller("Count",0)
      ?>
    <a href="<?php echo SERVER_URL; ?>product-search/" class="tile">
      <div class="tile-tittle">products</div>
      <div class="tile-icon">
        <i class="fas fa-pallet fa-fw"></i>
        <p><?php echo $reg_products->rowCount();?> Registered</p>
      </div>
    </a>
      <?php } ?>
    <a href="<?php echo SERVER_URL; ?>reservation-reservation/" class="tile">
      <div class="tile-tittle">Reservaciones</div>
      <div class="tile-icon">
        <i class="far fa-calendar-alt fa-fw"></i>
        <p>30 Registradas</p>
      </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>reservation-pending/" class="tile">
      <div class="tile-tittle">Prestamos</div>
      <div class="tile-icon">
        <i class="fas fa-hand-holding-usd fa-fw"></i>
        <p>200 Registrados</p>
      </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>reservation-list/" class="tile">
      <div class="tile-tittle">Finalizados</div>
      <div class="tile-icon">
        <i class="fas fa-clipboard-list fa-fw"></i>
        <p>700 Registrados</p>
      </div>
    </a>
    <?php
    if($_SESSION['privilege_loan'] == 1){
      require_once "./controllers/userController.php";
      $ins_user = new userController();
      $reg_users = $ins_user->data_user_controller("Count",0)
      ?>
    <a href="<?php echo SERVER_URL; ?>user-list/" class="tile">
      <div class="tile-tittle">users</div>
      <div class="tile-icon">
        <i class="fas fa-id-card-alt fa-fw"></i>
        <p><?php echo $reg_users->rowCount();?> Registered</p>
      </div>
    </a>
    <?php } ?>
    <a href=<?php echo SERVER_URL; ?>company/" class="tile">
      <div class="tile-tittle">Company</div>
      <div class="tile-icon">
        <i class="fas fa-store-alt fa-fw"></i>
        <p>1 Registered</p>
      </div>
    </a>
  </div>
</div>
