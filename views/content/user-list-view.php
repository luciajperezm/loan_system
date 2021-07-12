<?php
  if($_SESSION['privilege_loan'] != 1){
      echo $ins_logout->force_logout_controller();
      exit();
  }
?>
<h2>List of Users</h2>
<p>Here you can find the users of the company. Be careful when updating or deleting this information. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>user-new/">New
        User</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>user-search/">Search Users</a></button>
</div>
<?php require_once "./controllers/userController.php";
      $ins_user = new userController();
      echo $ins_user->pagination_user_controller($page[1], 15, $_SESSION['privilege_loan'],$_SESSION['id_loan'],
          $page[0], "");




