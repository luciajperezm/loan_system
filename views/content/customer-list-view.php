<h2>List of Customers</h2>
<p>Here you can find the customers of the company. This information is required if you want to make a new order. Be careful when updating or deleting this information. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>customer-new/">New
        Customer</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>customer-search/">Search Customer</a></button>
</div>
<?php require_once "./controllers/customerController.php";
$ins_customer = new customerController();
echo $ins_customer->pagination_customer_controller($page[1], 15, $_SESSION['privilege_loan'],
    $page[0], "");