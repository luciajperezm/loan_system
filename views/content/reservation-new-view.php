<h2>New Loan</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore doloremque error explicabo fuga in ipsa
    labore laborum libero minima molestiae  </p>
<div class="buttons">
    <button class="btn btn__cta"><i class="fas fa-calendar ic"></i><a
          href="<?php echo SERVER_URL;?>reservation-reservation/">Reservations</a></button>
    <button class="btn btn__cta"><i class="fas fa-business-time ic"></i><a
          href="<?php echo SERVER_URL;?>reservation-pending/">Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>reservation-list/">Payed Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>reservation-search/">Search Loans</a></button>
</div>
<p class="text-center roboto-medium">ADD A CUSTOMER OR PRODUCTS</p>
<p class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCustomer"><i class="fas
    fa-user-plus"></i> &nbsp; Add a Customer</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalItem"><i class="fas
    fa-box-open"></i> &nbsp; Add Products</button>
</p>
<div>
    <span class="roboto-medium">Customer:</span>
    <span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> Choose a Customer</span>
    <form action="" style="display: inline-block !important;">
        Carlos Lopez
        <button type="button" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
    </form>
</div>

<table class="table table-sm">
    <thead >
    <tr class="t-row">
        <th>#</th>
        <th class="text-center ">Item</th>
        <th class="text-center ">cantidad</th>
        <th class="text-center ">tiempo</th>
        <th class="text-center ">costo</th>
        <th class="text-center ">subtotal</th>
        <th class="text-center ">detalle</th>
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
        <td class="text-center ">23</td>
        <td class="text-center">
            <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                <i class="fas fa-info-circle"></i>
            </button>
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
<form action="" autocomplete="off">
    <fieldset>
        <legend><i class="far fa-clock"></i> &nbsp;Date and time of Loan</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="loan_date_init">Loan Date</label>
                        <input type="date" class="form-control" name="loan_date_init_reg" id="loan_date_init">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="loan_time_init">Loan Time</label>
                        <input type="time" class="form-control" name="loan_time_init_reg" id="loan_time_init">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend><i class="fas fa-history"></i> &nbsp; Date and time of Loan completion</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="loan_date_final">Date of loan completion</label>
                        <input type="date" class="form-control" name="loan_date_final_reg" id="loan_date_final">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="loan_time_final">Time of loan completion</label>
                        <input type="time" class="form-control" name="loan_time_final_reg" id="loan_time_final">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend><i class="fas fa-cubes"></i> &nbsp; Other Info</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="loan_status" class="bmd-label-floating">Status</label>
                        <select class="form-control" name="loan_status_reg" id="loan_status">
                            <option value="" selected="" disabled="">Choose an option</option>
                            <option value="Reservation">Reservation</option>
                            <option value="Loan">Loan</option>
                            <option value="Finished">Finished</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="loan_total" class="bmd-label-floating">Total amount to pay ($)</label>
                        <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="100.00"
                               id="loan_total" maxlength="10">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="loan_payed" class="bmd-label-floating">Total payed ($)</label>
                        <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="loan_payed_reg"
                               id="loan_payed" maxlength="10">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="loan_observation" class="bmd-label-floating">Observation</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control"
                               name="loan_observation_reg" id="loan_observation" maxlength="400">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp;
          CLEAN</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; SAVE</button>
    </p>
</form>

<!-- MODAL CUSTOMER -->
<div class="modal fade" id="ModalCustomer" tabindex="-1" role="dialog" aria-labelledby="ModalCustomer"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCustomer">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_customer" class="bmd-label-floating">DNI, Name, Last Name</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control"
                               name="input_customer" id="input_customer" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="table_customers">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                            <tr class="text-center">
                                <td>0000000000 - Lucia Perez</td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        We couldn't find any customer that matched with <strong>“Search”</strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="search_customer()"><i class="fas fa-search
                fa-fw"></i> &nbsp;
                  Search</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ITEM -->
<div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalItem">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_item" class="bmd-label-floating">Code, Name</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_item" id="input_item" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_items">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                            <tr class="text-center">
                                <td>000000000000 - Wooden Table</td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fas fa-box-open"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        We couldn't find any product that matches with <strong>“Search”</strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> &nbsp; Search</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD PRODUCT MODAL -->
<div class="modal fade" id="ModalAddProduct" tabindex="-1" role="dialog" aria-labelledby="ModalAddProduct"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content Ajax_Form">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAddProduct">Choose a format, quantity of items, cost of time per
                  item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_add_product" id="id_add_product">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="detail_format" class="bmd-label-floating">Loan Format</label>
                                <select class="form-control" name="detail_format" id="detail_format">
                                    <option value="Hours" selected="" >Hours</option>
                                    <option value="Days">Days</option>
                                    <option value="Event">Event</option>
                                    <option value="Month">Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detail_quantity" class="bmd-label-floating">Quantity of items</label>
                                <input type="number" pattern="[0-9]{1,7}" class="form-control" name="detail_quantity"
                                       id="detail_quantity" maxlength="7" required="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detail_time" class="bmd-label-floating">Time (according to format)</label>
                                <input type="number" pattern="[0-9]{1,7}" class="form-control" name="detail_time"
                                       id="detail_time" maxlength="7" required="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detail_cost_time" class="bmd-label-floating">Cost per time unit</label>
                                <input type="text" pattern="[0-9.]{1,15}" class="form-control" name="detail_cost_time"
                                       id="detail_cost_time" maxlength="15" required="" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Add</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" >Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php include_once "./views/inc/loan.php"; ?>