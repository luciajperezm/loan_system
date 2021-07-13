<h2>New Product</h2>
<p>Here you can add Products to the system. This information is required if you want to make a purchase or an order. Make sure the information you introduce is correct. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>product-list/">List
        of Products</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>product-search/">Search Product</a></button>
</div>
<form class="Ajax_Form form-neon box" action="<?php echo SERVER_URL;?>ajax/productAjax.php" method="post"
      data-form="save"
      autocomplete="off">
    <fieldset>
        <legend><i class="fas fa-boxes ic"></i> &nbsp; Product Information</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="product_code" class="bmd-label-floating">Code</label>
                        <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="product_code_reg" id="product_code" maxlength="45">
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="product_name" class="bmd-label-floating">Name</label>
                        <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="product_name_reg" id="product_name" maxlength="140">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="product_stock" class="bmd-label-floating">Stock</label>
                        <input type="number" pattern="[0-9]{1,9}" class="form-control" name="product_stock_reg"
                               id="product_stock" maxlength="9">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="product_status" class="bmd-label-floating">Status</label>
                        <select class="form-control" name="product_status_reg" id="product_status">
                            <option value="" selected="">Choose an option</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>
                </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="product_detail" class="bmd-label-floating">Detail</label>
                  <input type="text" pattern="[a-zA-Z0-9- ]{1,45}" class="form-control" name="product_detail_reg"
                         id="product_detail" maxlength="45"></div>
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