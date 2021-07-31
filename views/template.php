<?php session_start(['name' => 'LOAN']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo COMPANY_NAME; ?></title>
    <?php include "./views/inc/links.php";?>
</head>
<body>
<?php
    $ajaxRequest = false;
    require_once "./controllers/viewsController.php";
    $ins_views = new viewsController();
    $views = $ins_views->get_views_controller();
    if($views == "login" || $views == "404"){
      require_once "./views/content/".$views."-view.php";
    }else {


        $page = explode("/", $_GET['views']);

        require_once "./controllers/loginController.php";
        $ins_logout = new loginController();

        if(!isset($_SESSION['token_loan']) || !isset($_SESSION['username_loan']) || !isset
            ($_SESSION['privilege_loan']) || !isset($_SESSION['id_loan'])){
            $ins_logout->force_logout_controller();
            exit();
        }
?>
<div class="wrapper">
    <?php include"./views/inc/sidebar.php";?>
    <!-- Page Content  -->
    <div id="content">
        <?php
            include "./views/inc/navbar.php";
            /*--- content goes here ---*/
            include $views;
        ?>
    </div> <!--end of content-->
</div>  <!--end of wrapper-->
<?php
        include "./views/inc/logout.php";
    }
    include "./views/inc/scripts.php";
?>
</body>
</html>