<h2>List of Products</h2>
<p>Here you can find the products of the company. This information is required if you want to make a purchase or an order. Be careful when updating or deleting this information. </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>product-new/">New
        Product</a> </button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;
    ?>product-search/">Search Product</a></button>
</div>

<table class="table table-sm">
    <thead >
    <tr class="t-row">
        <th>#</th>
        <th class="text-center ">Code</th>
        <th class="text-center ">Name</th>
        <th class="text-center ">Stock</th>
        <th class="text-center ">Minimum Required</th>
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
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>