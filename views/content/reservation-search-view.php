<h2>Search Loans</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore doloremque error explicabo fuga in ipsa
    labore laborum libero minima molestiae  </p>
<div class="buttons">
    <button
        class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>reservation-new/">New
        Loan</a></button>
    <button class="btn btn__cta"><i class="fas fa-business-time ic"></i><a href="<?php echo SERVER_URL;
    ?>reservation-pending/">Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;
    ?>reservation-list/">Payed Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-calendar ic"></i><a href="<?php echo SERVER_URL;?>reservation-reservation
    /">Reservations</a></button>
</div>
<div class="container-fluid">
    <form class="form-neon" action="">
      <input type="hidden" name="module" value="user">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="search_init_loan" >Fecha inicial (día/mes/año)</label>
                        <input type="date" class="form-control" name="search_init_loan" id="search_init_loan" maxlength="30">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="search_final_loan" >Fecha final (día/mes/año)</label>
                        <input type="date" class="form-control" name="search_final_loan" id="search_final_loan"
                               maxlength="30">
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container-fluid">
    <form action="">
      <input type="hidden" name="module" value="user">
        <input type="hidden" name="eliminar_busqueda_prestamo" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Fecha de busqueda: <strong>01/01/2020 &nbsp; a &nbsp; 01/01/2020</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
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
        <th class="text-center ">Cliente</th>
        <th class="text-center ">Loan date</th>
        <th class="text-center ">fecha de entrega</th>
        <th class="text-center ">tipo</th>
        <th class="text-center ">status</th>
        <th class="text-center ">factura</th>
        <th class="text-center ">Update</th>
        <th class="text-center ">Delete</th>
    </tr>
    </thead>
    <tbody class="table__body">
    <tr>
        <td class="text-center ">1</td>
        <td class="text-center ">Lucia Perez</td>
        <td class="text-center ">2017/10/8</td>
        <td class="text-center ">2017/10/8</td>
        <td class="text-center "><span class="badge badge-dark">Finished</span></td>
        <td class="text-center "><span class="badge badge-success">Done</span></td>
        <td class="text-center">
            <button type="button" class="btn btn-danger">
                <i class="fas fa-file-invoice"></i>
            </button>
        </td>
        <td class="text-center ">
            <a href="<?php echo SERVER_URL;?>reservation-update/" class="btn btn-success">
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