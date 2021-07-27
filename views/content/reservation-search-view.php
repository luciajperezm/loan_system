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
<?php
if(!isset($_SESSION['date_init_loan']) && empty($_SESSION['date_init_loan']) && !isset($_SESSION['date_final_loan']) &&
    empty($_SESSION['date_final_loan'])){
?>
<div class="container-fluid">
				<form class="Ajax_Form form-neon" action="<?php echo SERVER_URL;?>ajax/searchAjax.php" method="post" autocomplete="off">
          <input type="hidden" name="module" value="loan">
					<div class="container-fluid">
						<div class="row justify-content-md-center">
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="date_init" >Fecha inicial (día/mes/año)</label>
									<input type="date" class="form-control" name="date_init" id="date_init" maxlength="30">
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="date_final" >Fecha final (día/mes/año)</label>
									<input type="date" class="form-control" name="date_final" id="date_final" maxlength="30">
								</div>
							</div>
							<div class="col-12">
								<p class="text-center" style="margin-top: 40px;">
									<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp;
                    SEARCH</button>
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>
<?php }else {?>
<div class="container-fluid">
    <form class="Ajax_Form" action="<?php echo SERVER_URL;?>ajax/searchAjax.php" method="post" autocomplete="off" data-form="search">
        <input type="hidden" name="module" value="loan">
            <input type="hidden" name="delete_search" value="delete">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <p class="text-center" style="font-size: 20px;">
                          Fecha de busqueda: <strong>01/01/2020 &nbsp; a &nbsp; 01/01/2020</strong>
                        </p>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 20px;">
                          <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i>
                            &nbsp; DELETE SEARCH</button>
                        </p>
                    </div>
              </div>
        </div>
  </form>
</div>

<?php require_once "./controllers/loanController.php";
$ins_loan = new loanController();
echo $ins_loan->pagination_loan_controller($page[1], 15, $_SESSION['privilege_loan'], $page[0], "Search", $_SESSION['date_init_loan'], $_SESSION['date_final_loan']);?>
<?php } ?>