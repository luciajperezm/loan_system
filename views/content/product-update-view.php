<h2>Update Product</h2>
<p>Here you can update the information of the registered Products in the company. Make sure the information you introduce is correct. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>product-list/">List
        of Products</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>product-search/">Search Product</a></button>
</div>

<form action="" class="form-neon box" autocomplete="off">
    <fieldset>
        <legend><i class="fas fa-boxes ic"></i> &nbsp; Product Information</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_code" class="bmd-label-floating">Code</label>
                        <input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="product_code_reg" id="product_code" maxlength="45">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_name" class="bmd-label-floating">Name</label>
                        <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="product_name_reg" id="product_name" maxlength="140">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_stock" class="bmd-label-floating">Stock</label>
                        <input type="num" pattern="[0-9]{1,9}" class="form-control" name="product_stock_reg" id="product_stock" maxlength="9">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="product_min" class="bmd-label-floating">Minimun Required</label>
                        <input type="num" pattern="[0-9]{1,9}" class="form-control" name="product_min_reg" id="product_min" maxlength="9">
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label for="product_status" class="bmd-label-floating">Status</label>
                        <select class="form-control" name="product_status_reg" id="product_status">
                            <option value="" selected="" disabled="">Choose an option</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
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
<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">Something Went Wrong!</h4>
    <p class="mb-0">Sorry, we couldn't update the Supplier due to an error.</p>
</div>