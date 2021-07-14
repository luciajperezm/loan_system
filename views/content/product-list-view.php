<h2>List of Products</h2>
<p>Here you can find the products of the company. This information is required if you want to make a purchase or an order. Be careful when updating or deleting this information. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>product-new/">New
        Product</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>product-search/">Search Product</a></button>
</div>
<?php require_once "./controllers/productController.php";
$ins_product = new productController();
echo $ins_product->pagination_product_controller($page[1], 15, $_SESSION['privilege_loan'],
    $page[0], "");