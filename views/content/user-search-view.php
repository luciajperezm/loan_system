<?php
if($_SESSION['privilege_loan'] != 1){
    echo $ins_logout->force_logout_controller();
    exit();
}
?>
<h2>Search Users</h2>
<p>Here you can search the registered users of the company.</p>
<div class="buttons" style="margin: 0;">
  <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>user-new/">New User</a></button>
  <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>user-list/">List of Users</a></button>
  <button class="btn btn__cta active"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>user-search/">Search Users</a></button>
</div>
<?php
if(!isset($_SESSION['search_user']) && empty($_SESSION['search_user'])){
?>
<div class="container-fluid">
    <form class="Ajax_Form form-neon" action="<?php echo SERVER_URL;?>ajax/searchAjax.php"
          method="post"
          autocomplete="off" style="margin: 0;">
        <input type="hidden" name="module" value="user">
        <div class="container-fluid">
            <div class="row justify-content-md-center"  style="margin: 0;">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">Which user are you looking for?</label>
                        <input type="text" class="form-control" name="search_init" id="inputSearch" maxlength="30">
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info" style="margin: 0;"><i class="fas fa-search"></i> &nbsp; SEARCH</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div><br>
<?php }else {?>
<div class="alert alert-dark text-center search-alert" role="alert">
    <form class="Ajax_Form" action="<?php echo SERVER_URL;?>ajax/searchAjax.php" method="post" autocomplete="off" data-form="search" >
        <input type="hidden" name="module" value="user">
        <input type="hidden" name="delete_search" value="delete">
        <div class="container-fluid">
            <div class="row justify-content-md-center" >
                <div class="col-12 col-md-6">
                    <p class="text-center result-info" style="font-size: 20px;">
                        Results of search <strong>“<?php echo $_SESSION['search_user']; ?>”</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger" style="margin: 0; "><i class="far fa-trash-alt"></i> &nbsp; DELETE SEARCH</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<?php require_once "./controllers/userController.php";
$ins_user = new userController();
echo $ins_user->pagination_user_controller($page[1], 15, $_SESSION['privilege_loan'],$_SESSION['id_loan'],
    $page[0], $_SESSION['search_user']);
?>
<?php } ?>