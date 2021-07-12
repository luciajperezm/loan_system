<h2>Search Products</h2>
<p>Here you can search the registered products of the company. If the product is not registered you can add it to the system clicking on the "New Product" button. </p>
<div class="buttons" style="margin: 0;">
    <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>product-new/">New Product</a> </button>
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>product-list/">List of Products</a></button>
</div>
<div class="container-fluid">
    <form class="form-neon" action="" style="margin: 0;">
        <div class="container-fluid">
            <div class="row justify-content-md-center"  style="margin: 0;">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">Which Product are you Looking for?</label>
                        <input type="text" class="form-control" name="busqueda-" id="inputSearch" maxlength="30">
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
</div>

<div class="alert alert-danger text-center search-alert" role="alert">
    <form action="">
        <input type="hidden" name="eliminar-busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center" >
                <div class="col-12 col-md-6" >
                    <p class="text-center result-info" style="font-size: 20px;">
                        Results of search <strong>“Hammer DeWalt”</strong>
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

<table class="table table-sm">
    <thead >
    <tr class="t-row">
        <th>#</th>
        <th class="text-center ">Code</th>
        <th class="text-center ">Name</th>
        <th class="text-center ">Stock</th>
        <th class="text-center ">Minimun Required</th>
        <th class="text-center ">Status</th>
        <th class="text-center ">Update</th>
        <th class="text-center ">Delete</th>
    </tr>
    </thead>
    <tbody class="table__body">
    <tr>
        <td class="text-center ">1</td>
        <td class="text-center ">1265641</td>
        <td class="text-center ">HAMMER</td>
        <td class="text-center ">23</td>
        <td class="text-center ">50</td>
        <td class="text-center "><span class="badge badge-danger">ACTIVE</span></td>
        <td class="text-center ">
            <a href="<?php echo SERVER_URL;?>product-update/" class="btn btn-success">
                <i class="fas fa-sync-alt"></i>
            </a>
        </td>
        <td class="text-center ">
            <form action="" class="form-table">
                <button type="button" class="btn btn-warning">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
        </td>
    </tr>
    </tbody>
</table>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>