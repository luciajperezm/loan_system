<?php
if($_SESSION['privilege_loan'] < 1 || $_SESSION['privilege_loan'] > 2){
    echo $ins_logout->force_logout_controller();
    exit();
}
?>
<h2>Update Product</h2>
<p>Here you can update the information of the registered Products in the company. Make sure the information you
  introduce is correct. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>product-list/">List
        of Products</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>product-search/">Search Product</a></button>
</div>
<?php
require_once "./controllers/productController.php";
$ins_product = new productController();
$data_product = $ins_product->data_product_controller("Unique", $page[1]);

if($data_product->rowCount() == 1){
$fields = $data_product->fetch();
?>
<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/productAjax.php" method="post"
      data-form="update" autocomplete="off">
  <input type="hidden" name="product_id_up" value="<?php echo $page[1];?>">
    <fieldset>
        <legend><i class="fas fa-boxes ic"></i> &nbsp; Product Information</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_code" class="bmd-label-floating">Code</label>
                        <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="product_code_up"
                               id="product_code" maxlength="45" value="<?php echo
                        $fields['item_codigo']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_name" class="bmd-label-floating">Name</label>
                        <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control"
                               name="product_name_up" id="product_name" maxlength="140" value="<?php echo
                        $fields['item_nombre']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_stock" class="bmd-label-floating">Stock</label>
                        <input type="number" pattern="[0-9]{1,9}" class="form-control" name="product_stock_up"
                               id="product_stock" maxlength="9" value="<?php echo
                        $fields['item_stock']; ?>">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_status" class="bmd-label-floating">Status</label>
                        <select class="form-control" name="product_status_up" id="product_status">
                            <option value="Available" <?php if($fields['item_estado'] == "Available"){ echo
                            'selected=""'; } ?>>Available</option>
                            <option value="Unavailable" <?php if($fields['item_estado'] == "Unavailable"){ echo 'selected=""'; } ?>>Unavailable</option>
                        </select>
                    </div>
                </div>
              <div class="col-12 col-md-8">
                <div class="form-group">
                  <label for="product_detail" class="bmd-label-floating">Detail</label>
                  <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control"
                         name="product_detail_up"
                         id="product_detail" maxlength="9" value="<?php echo
                  $fields['item_detalle']; ?>">
                </div>
              </div>
            </div>
        </div>
    </fieldset>
    <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; UPDATE</button>
    </p>
</form>
<?php }else{ ?>
  <div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">Something Went Wrong!</h4>
    <p class="mb-0">Sorry, we couldn't update the Product due to an error.</p>
  </div>
<?php } ?>